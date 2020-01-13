<script>
    //  import {users} from './../data-users.js'
    //  import {onMount} from 'svelte'
    //  import User from './User.svelte'

     
      import {dispositivos} from './../data-dispositivos.js'
      import {onMount} from 'svelte'
      import Dispositivo from './Dispositivo.svelte'

     onMount( async() => {
      
      const url = 'http://localhost:8080/back/get-dispositivos.php'
      let res = await fetch(url);
      res = await res.json();
      $dispositivos = res.data;

     });

</script>


<!-- ###################################### -->
<div id="dispositivos">
   {#each $dispositivos as dispositivo}
   <Dispositivo {dispositivo} />
   {/each}
</div>
<!-- ###################################### -->