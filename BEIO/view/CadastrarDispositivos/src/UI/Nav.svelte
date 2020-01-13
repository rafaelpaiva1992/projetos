<script>

 function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}


</script>

<nav class="menu" tabindex="0">
	<div class="smartphone-menu-trigger"></div>
  <header class="avatar">
		<img src='image/softmus.jpg'/>
    <h2>Softmus Tecnologia</h2>
  </header>
	<ul>
    <li tabindex="0" class="icon-mobile"><span>Dispositivos</span></li>
    <li tabindex="0" class="icon-dashboard"><span>Dashboard</span></li>
    <li tabindex="0" class="icon-grafic"><span>Gráficos</span></li>
    <li tabindex="0" class="icon-users"><span>Usuários</span></li>
    <li tabindex="0" class="icon-settings"><span>Configurações</span></li>
    <li tabindex="0" class="icon-log-out"><span>Sair</span></li>
  </ul>
</nav>

<style>

</style>