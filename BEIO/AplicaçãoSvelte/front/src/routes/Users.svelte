<script>
     import {users} from './../data-users.js'
     import {onMount} from 'svelte'
     import User from './User.svelte'

     onMount( async() => {
      
      const url = 'http://localhost:8080/back/get-users.php'
      let res = await fetch(url);
      res = await res.json();
      $users = res.data;
      console.log($users);

     });

</script>

<!-- ###################################### -->
<!-- <div id="users">
   {#each $users as user}
   <User {user} />
   {/each}
</div> -->
<!-- ###################################### -->