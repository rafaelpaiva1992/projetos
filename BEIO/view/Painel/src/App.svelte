<!-- App.svelte -->
<script>
  import { Router, Link, Route } from "svelte-routing";
  import Home from "./routes/Home.svelte";
  import users from './routes/Users.svelte';
  import AddUsuario from './routes/AdicionarUsuario.svelte';
  import AddDispositivo from './routes/AdicionarDipositivo.svelte';
  import dispositivo from './routes/Dispositivo.svelte';
  import {onMount} from 'svelte'
  import {modeluser} from './modeluser.js'

  export let url = "";
   let logo = "assets/logo/";
    
  onMount( async() => {
      var nome = document.getElementById("id").value;
      const url = 'http://localhost:8080/user?ID=' + nome;
       let res = await fetch(url);
       res = await res.json();
     $modeluser = res[0];
       logo +=  $modeluser.Imagem;
      
     });
    
     

</script>

<Router url="{url}">
  <!-- <nav>
    <Link to="/">Home</Link>
    <Link to="Users">Users</Link>
  </nav> -->
  <nav class="menu" tabindex="0">
	<div class="smartphone-menu-trigger"></div>
  <header class="avatar">
		<img src="{logo}" alt ="Logo Usuario"/>
    <h2>{$modeluser.Nome}</h2>
  </header>
	<ul>
    <Link to="/painel"><li tabindex="0" class="icon-dashboard" to="/"><span>Home</span></li></Link>
    <Link to="users"><li tabindex="0" class="icon-users"><span>Usuários</span></li></Link>
    <Link to="dispositivo"><li tabindex="0" class="icon-mobile"><span>Dispositivos</span></li></Link>
    <Link to="Adddispositivo"><li tabindex="0" class="icon-mobile"><span>AddDispositivo</span></li></Link>
    <Link to="AddUsuario"><li tabindex="0" class="icon-mobile"><span>AddUsuario</span></li></Link>
    <li tabindex="0" class="icon-grafic"><span>Gráficos</span></li>
    <li tabindex="0" class="icon-settings"><span>Configurações</span></li>

    
    <a href="/logout"><li tabindex="0" class="icon-log-out " > <span >Sair</span> </li> </a>
  </ul>
</nav>
  <div>
    <Route path="/painel" component="{Home}" />
    <Route path="users" component="{users}" />
    <Route path="dispositivo" component="{dispositivo}" />
    <Route path="AddUsuario" component="{AddUsuario}" />
    <Route path="Adddispositivo" component="{AddDispositivo}" />
  </div>
</Router>

<style>
a {
  text-decoration: none;
  color: white;

}

a:active {
  text-decoration: none;
  color: white;

}

li{
  text-decoration:none;
  color:white;
}

li:active{
  text-decoration:none;
  color:white;

}

h2{
  padding-top: 15px;
  color:black;
  font-size: 20px;
}
</style>

