<script>
  import { Table, Button, Input } from "sveltestrap";
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
    <th>Email</th>
    <th>Empresa</th>
    <th>Permissão</th>
    <th>Logo</th>
    <th>Excluir</th>
  </tr>
  </thead>
  <tbody class="user">

 {#each $users as data}
   <tr>
    <th scope="row"> {data.ID} </th>
    <td><input type="text" bind:value={data.Nome} on:input={updateName} /></td>
    <td><input type="text" bind:value={data.Email}  /></td>
     <td><input type="text" bind:value={data.Empresa}  /></td>
     <td><input type="text" bind:value={data.Permissao}  /></td>
    <td><label for="picture{data.ID}">
    <input
      type="file"
      bind:this={txtFile}
      name="picture{data.ID}"
      id="picture{data.ID}"
      on:input={updateImage} />
    <img bind:this={txtPicture} src="{imgPath}{data.Imagem}" alt="Logo Usuario"/>
  </label>
  </td>
    <td><button on:click={deleteUser}>🗑️</button> </td>
  </tr>
  {/each}

 </tbody>
</Table>







<!-- ############# HTML ######################### -->
<!-- <div class="user"> -->
  <!-- {JSON.stringify({user})} -->
  <!-- <input type="text" bind:value={user.Nome} on:input={updateName} />
  <label for="picture{user.ID}">
    <input
      type="file"
      bind:this={txtFile}
      name="picture{user.ID}"
      id="picture{user.ID}"
      on:input={updateImage} />
    <img bind:this={txtPicture} src="{imgPath}{user.Imagem}" alt="Logo Usuario"/>
  </label>
   <button on:click={deleteUser}>🗑️</button>
</div> -->
<!-- ###################################### -->

<style>
  .user {
    padding-top: 20px;
  }
  .user img {
    width: 30px;
  }
  input {
    width: 100%;
    border: none;
    outline: none;
    font-size: inherit;
    background-color: transparent;
  }

  button {
    outline: none;
    border: none;
    background-color: transparent;
  }

  input[type="file"] {
    display: none;
  }

</style>

