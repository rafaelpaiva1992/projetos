<script>
 import {Button, Input, Label } from "sveltestrap";
 import {onMount} from 'svelte'
   import {modeluser} from './../modeluser.js'

let color="warning";
let empresas = {};

 onMount( async() => {
      const url = 'http://localhost:8080/empresas' ;
      const data = new FormData();
      data.append("EmpresaIDFK", $modeluser.EmpresaIDFK);
     
      let res = await fetch(url,
      {
      
    method: "POST",
    body: data

    });
      res = await res.json();
      empresas = res;
         

     });

</script>

<div class="Container">

<h3> Adicionar Usuario </h3>
<hr>
<form action="adicionarusuario" method="POST" >



<h5 class="title"> Usuario :</h5>




<section class="Container colunas ">

<div class=" tamanho ">
 <Label for="Empresa">Vincular a uma Empresa:</Label>
    <Input type="select" name="empresa" id="empresa">
    
    {#each empresas as data}
      <option value="{data.ID} "> {data.Empresa} </option>
     {/each}

     </Input> 
     </div>
 
<div class=" tamanho ">
 <Label for="permissao">Permissao:</Label>
    <Input type="select" name="permissao" id="permissao">
      <option value = "2" selected > Editar e Visualizar </option>
      <option value = "3"> Visualizar </option>
     </Input> 
     </div>    


<div class=" tamanho ">
<Label for="nome"  >Nome:</Label>
<Input id="nome" name="nome" />
</div>

<div class=" tamanho ">
<Label for="Email">Email</Label>
<Input id="Email" type="email" name="email" />
</div>

<div class=" tamanho ">
<Label for="Senha">Senha</Label>
<Input id="Senha" type="password" name="senha" />
</div>

</section>

<hr>
<h5 class="title"> Endereço : </h5>


<section class="Container colunas ">

<div class=" tamanho ">
<Label for="CEP">CEP:</Label>
<Input id="CEP" name="cep" />
</div>

<div class=" tamanho ">
<Label for="Cidade">Cidade:</Label>
<Input id="Cidade" name="cidade" />
</div>

<div class=" tamanho ">
<Label for="Estado">Estado:</Label>
<Input id="Estado" name="estado" />
</div>

<div class=" tamanho ">
<Label for="Pais">Pais:</Label>
<Input id="Pais" name="pais" />
</div>


<div class=" tamanho ">
<Label for="Logradouro">Logradouro:</Label>
<Input id="Logradouro" name="logradouro" />
</div>

<div class=" tamanho ">
<Label for="Bairro">Bairro:</Label>
<Input id="Bairro" name="bairro" />
</div>

<div class=" tamanho ">
<Label for="Numero">Numero:</Label>
<Input id="Numero" name="numero" />
</div>

<div class=" tamanho ">
<Label for="Descrição">Descrição:</Label>
<Input type="textarea" id="descricao" name="descricao" maxlength="250"  rows="2" />
</div>


</section>

<Button type="submit" {color} > Salvar </Button>

</form>

</div>


<style>



.title{
color:red;
font-size: 20px;
}


.tamanho{
width: 95%;
}
.Container{
    padding: 2%;  
    display: grid;
}

.colunas {
	grid-template-columns: 1fr 1fr;
}

@media (max-width: 768px){
    .colunas{
        grid-template-columns: 1fr;
    }
}

</style>