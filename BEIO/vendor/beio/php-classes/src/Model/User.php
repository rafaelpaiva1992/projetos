<?php

namespace Beio\Model;

use \Beio\DB\Sql;
use \Beio\Model;

class User extends Model
{

    const SESSION = "User";

    public static function log()
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int) $_SESSION[User::SESSION]["ID"] > 0
        ) {
            return false;
        } else {
            return true;
        }

    }

    public static function verifyLogin()
    {
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int) $_SESSION[User::SESSION]["ID"] > 0
        ) {
            header("Location: /");
            exit;
        } else {
            header("Location: /painel");

        }
    }

    public static function login($login, $password)
    {
        $sql = new Sql();

        $resultado = $sql->select("SELECT * FROM Usuario Where Email =  :LOGIN ", array(
            ":LOGIN" => $login,
        ));

        if (count($resultado) === 0) {
            throw new \Exception("Usuário inexistente ou senha inválida", 1);
        }

        $dados = $resultado[0];
        if (password_verify($password, $dados['Senha']) === true) {

            $user = new user();
            $user->setData($dados);
            $_SESSION[User::SESSION] = $user->getValues();

            return $user;

        } else {
            throw new \Exception("Usuário inexistente ou senha inválida", 1);
        }

    }

    public static function logout()
    {

        $_SESSION[User::SESSION] = null;

    }

    private function hashPassword($password)
    {

        return password_hash($password, PASSWORD_DEFAULT,
            ['cost' => 12,
            ]);
    }

    public function registrar($dados = array())
    {

        if (!isset($dados['nome'])) {$this->err('Falta o campo name!', __LINE__);}
        if ($dados['nome'] === "") {$this->err('Preencha o campo nome!', __LINE__);}
        if (strlen($dados['nome']) < 3) {$this->err('Usuário com no minimo 3 letras!', __LINE__);}

///////////////////validação da Foto//////////////////

        if ($dados['Imagem']['name'] == 0
            || $dados['Imagem']['name'] == ""
            || $dados['Imagem']['name'] == null
        ) {
            $uniquePictureName = "padrao.PNG";

        } else {
            // Saber o tipo da imagem se é png, jpeg etc....
            $extension = pathinfo($dados['Imagem']['name'], PATHINFO_EXTENSION);
//var_dump($extension);

//Validar a extensions
            $allowedExtensions = ['png', 'jpg', 'gif', 'jpeg'];

            if (!in_array($extension, $allowedExtensions)) {

                $this->err('A imagem deve ser uma dessa extensão ' . implode(',', $allowedExtensions));
            }

//Validar o tamanho da imagem SIZE
            if (($dados['Imagem']['size']) < 300) {$this->err('Imagem muito pequena!', __LINE__);}
            if (($dados['Imagem']['size']) > 20000) {$this->err('Imagem muito grande!', __LINE__);}

//unique name for the image

            $uniquePictureName = bin2hex(random_bytes(16)); // 32 long char+dig
            $uniquePictureName .= '.' . $extension;

        }

//salvar no banco

        try {

            $sql = new Sql();
            $params = array(
                ':EMPRESA' => $dados['nome'],
                ':LOGO' => $uniquePictureName,
            );
            $query = "INSERT INTO Empresa ( Empresa, Logo ) values ( :EMPRESA, :LOGO )";
            $results = $sql->inserir($query, $params);
            $query = "SELECT Max(ID) AS ID from Empresa";
            $result = $sql->select($query);
            $id = $result[0]['ID'];

            $teste = $dados['password'];
            $password = $this->hashPassword($teste);

            $query = "INSERT INTO Usuario (PermissaoIDFK, EmpresaIDFK, Nome, Email, Senha, Imagem) values ( :PERMISSAO, :EMPRESA,  :NOME, :EMAIL, :SENHA, :IMAGEM )";
            $params = array(
                ':PERMISSAO' => 2,
                ':EMPRESA' => $id,
                ':NOME' => $dados['nome'],
                ':EMAIL' => $dados['email'],
                ':SENHA' => $password,
                ':IMAGEM' => $uniquePictureName,

            );
            $results = $sql->inserir($query, $params);
            //mover a Imagem da pasta TMP para pasta pictures
            $destinationFolder = "assets/logo/";
            $finalPath = $destinationFolder . $uniquePictureName;
            move_uploaded_file($dados['Imagem']['tmp_name'], $finalPath);

        } catch (PDOException $ex) {

            $this->err('Não pode criar o usuário!', __LINE__);

        }
    }

    public static function info($id)
    {

        $sql = new Sql();
        $query = "SELECT ID, PermissaoIDFK, EmpresaIDFK, Nome, Email, Imagem FROM Usuario WHERE ID = :ID ";
        $params = array(
            ':ID' => $id,
        );

        $results = $sql->select($query, $params);

        return $results;
    }

    public static function todos()
    {

        $sql = new Sql();
        $query = "SELECT * FROM Usuario";

        $results = $sql->select($query);

        return $results;
    }

    public function inserir($dados)
    {
        $sql = new Sql();

        $password = $this->hashPassword($dados['password']);
        $query = "INSERT INTO Usuario (PermissaoIDFK, EmpresaIDFK, Nome, Email, Senha, Imagem ) VALUES(:PERMISSAO, :EMPRESA, :NOME, :EMAIL, :SENHA, :IMAGEM)";

        $params = array(
            ':PERMISSAO' => $dados['permissao'],
            ':EMPRESA' => $dados['empresa'],
            ':NOME' => $dados['nome'],
            ':EMAIL' => $dados['email'],
            ':SENHA' => $password,
            ':IMAGEM' => "padrao.PNG",
        );
        $sql->query($query, $params);
        $query = "SELECT Max(ID) AS ID from Usuario";
        $result = $sql->select($query);
        $id = $result[0]['ID'];
        return $id;
    }

    public function buscaUsuarios($id)
    {

        $sql = new Sql();
        $query = "SELECT ID FROM Empresa Where ID = :ID OR EmpresaIDFK = :ID ";
        $params = array(
            ':ID' => $id,
        );

        $results = $sql->select($query, $params);

        foreach ($results as $key => $values) {

            $query = "SELECT U.ID, U.Nome, U.Email, U.Imagem, P.Nome as Permissao, E.Empresa FROM Usuario as U, Permissao as P, Empresa as E where U.EmpresaIDFK = :ID AND U.EmpresaIDFK = E.ID AND U.PermissaoIDFK = P.ID ";
            $params = array(
                ':ID' => (int) $values['ID'],
            );
            $result = $sql->select($query, $params);

            foreach ($result as $value) {

                $user[] = $value;
            }
        }

        return $user;

    }

    public function deletar()
    {

    }

    public function alterar()
    {

    }

    public function err($message = 'error', $debug = 0)
    {

        echo '{ "status":0,
              "message":"' . $message . '",
              "debug":' . $debug . '}';
        exit();
    }

}
