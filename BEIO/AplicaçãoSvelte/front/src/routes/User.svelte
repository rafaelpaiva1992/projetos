<script>
  import { users } from "./../data-users.js";
  export let user = {};
  const imgPath = 'http://localhost:8080/back/pictures/';
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

<!-- ############# HTML ######################### -->
<div class="user">
  <!-- {JSON.stringify({user})} -->
  <input type="text" bind:value={user.Nome} on:input={updateName} />
  <label for="picture{user.ID}">
    <input
      type="file"
      bind:this={txtFile}
      name="picture{user.ID}"
      id="picture{user.ID}"
      on:input={updateImage} />
    <img bind:this={txtPicture} src="{imgPath}{user.Imagem}" />
  </label>
   <button on:click={deleteUser}>🗑️</button>
</div>
<!-- ###################################### -->

<style>
  .user {
    display: grid;
    grid-template-columns: 100fr 20fr 20fr;
    padding-top: 20px;
  }
  .user img {
    width: 30px;
  }
  input {
    width: 100%;
    border: none;
    outline: none;
    color: white;
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

