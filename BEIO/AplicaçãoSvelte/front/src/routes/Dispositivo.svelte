<script>
  import {dispositivos} from './../data-dispositivos.js'
  export let dispositivo = {};
 

  const updateName = async () => {
    const updateRoute = 'http://localhost:8080/back/update-dispositivo.php?ID=' + dispositivo.ID;
    console.log(updateRoute);
    const data = new FormData();
    data.append("Nome", dispositivo.Nome);
    let res = await fetch(updateRoute, {
      method: "POST",
      body: data
    });
  };

  const deleteDispositivo = async() =>{
      const deleteUrl = 'http://localhost:8080/back/delete-dispositivo.php?ID=' + dispositivo.ID;
      let res = await fetch(deleteUrl);
      res = await res.json();
      $dispositivos = $dispositivos.filter(
               item => dispositivo.ID != item.ID
      );
  }
</script>

<!-- ############# HTML ######################### -->
<div class="dispositivo">
  <!-- {JSON.stringify({user})} -->
  <input type="text" bind:value={dispositivo.Nome} on:input={updateName} />
  <!-- <label for="picture{user.ID}">
    <input
      type="file"
      bind:this={txtFile}
      name="picture{user.ID}"
      id="picture{user.ID}"
      on:input={updateImage} />
    <img bind:this={txtPicture} src="{imgPath}{user.Imagem}" />
  </label> -->
   <button on:click={deleteDispositivo}>🗑️</button>
</div>
<!-- ###################################### -->

<style>
  .dispositivo {
    display: grid;
    grid-template-columns: 100fr 20fr 20fr;
    padding-top: 20px;
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

</style>