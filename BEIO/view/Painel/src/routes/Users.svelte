<script>
    import { Router, Link, Route } from "svelte-routing";
     import {  Button, Input } from "sveltestrap";
     import {users} from './../data-users.js'
     import {onMount} from 'svelte'
     import User from './User.svelte'
     import {modeluser} from './../modeluser.js'
     
    

     let color = 'warning';


     onMount( async() => {
      
      const url = 'http://localhost:8080/usuarios?id='+$modeluser.EmpresaIDFK;
      let res = await fetch(url);
      res = await res.json();
      $users = res;
      console.log($users);
     });

</script>


<!-- ###################################### -->


<div class="container" id="users">
<div class="grid end" >
 <Input
      type="search"
      name="search"
      id="exampleSearch"
      placeholder="Digite sua Busca" />

<Button type="action" {color}  > Adicionar Usuario
</Button>


</div>
 <User />
</div>

<style> 
.container{
    padding: 2%;
}

.grid{
    
	display: grid;
	grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(1, 40px);
    padding-bottom: 2%;

}

.end {
	justify-items: end;
}

</style>