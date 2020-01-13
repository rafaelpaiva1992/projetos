<script>
import { Table, Button } from "sveltestrap";
import { users } from "./../data-users.js";
export let user = {};
const imgPath = 'http://localhost:8080/assets/logo/';
let txtFile, txtPicture;



  const updateName = async () => {
    const updateRoute = 'http://localhost:8080/back/update-user-name.php?ID=' + user.ID;
    const data = new FormData();
    data.append("Nome", user.Nome);
    let res = await fetch(updateRoute, {
      method: "POST",
      body: data
    });
  };

  const updateImage = async () => {
    let picture = new FileReader();
    picture.onload = async(e) => {
         txtPicture.setAttribute('src', e.target.result);
        const updateRoute = 'http://localhost:8080/back/update-user-picture.php?ID=' + user.ID;
        const data = new FormData();
        data.append("Imagem", txtFile.files[0]);
        let res = await fetch(updateRoute, {
        method: "POST",
        body: data
        });
    };
    picture.readAsDataURL(txtFile.files[0]);
  };

  const deleteUser = async() =>{

      const deleteUrl = 'http://localhost:8080/back/delete-user.php?ID=' + user.ID;
      let res = await fetch(deleteUrl);
      res = await res.json();
      $users = $users.filter(
               item => user.ID != item.ID
      );
  }

  
</script>

<Table hover>
  <thead>
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Codigo</th>
    <th>Descrição</th>
  </tr>
  </thead>
  <tbody>

 {#each $users as data}
   <tr>
    <th scope="row">{data.ID}</th>
    <td>{data.Nome}</td>
    <td>{data.CodigoLabel}</td>
    <td>{data.DescricaoDispositivo}</td>
  </tr>
 

  {/each}

 </tbody>
</Table>