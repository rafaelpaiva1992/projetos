<!-- App.svelte -->
<script>
  import { Router, Link, Route } from "svelte-routing";
  import Home from "./routes/Home.svelte";
  import users from './routes/Users.svelte';
  import dispositivos from './routes/Dispositivos.svelte';
  export let url = "";

</script>

<Router url="{url}">
  <nav class="menu" tabindex="0">
	<div class="smartphone-menu-trigger"></div>
  <header class="avatar">
		<img src='image/softmus.jpg'/>
    <h2>Softmus Tecnologia</h2>
  </header>
	<ul>
    <Link to="/"><li tabindex="0" class="icon-dashboard" to="/"><span>Home</span></li></Link>
    <Link to="users"><li tabindex="0" class="icon-users"><span>Usuários</span></li></Link>
    <Link to="dispositivos"><li tabindex="0" class="icon-mobile"><span>Dispositivos</span></li></Link>
    <li tabindex="0" class="icon-grafic"><span>Gráficos</span></li>
    <li tabindex="0" class="icon-settings"><span>Configurações</span></li>
    <li tabindex="0" class="icon-log-out"><span>Sair</span></li>
  </ul>
</nav>
  <div>
    <Route path="/" component="{Home}" />
    <Route path="users" component="{users}" />
    <Route path="dispositivos" component="{dispositivos}" />
  </div>
</Router>

