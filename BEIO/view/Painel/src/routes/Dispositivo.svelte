<script>
  import {  Button, Input } from "sveltestrap";
  import {onMount} from 'svelte'
  import Tabela from "./../UI/Tabela.svelte";
  import {modeluser} from './../modeluser.js'
  import {dispositivos} from './../dispositivos.js'
  const color = "warning";
  let search = '*';
  onMount( async() => {
      const url = 'http://localhost:8080/dispositivos' ;
      const data = new FormData();
      data.append("ID", $modeluser.ID);
      data.append("Campo", 'Campo');
      data.append("Busca", search);
     
      let res = await fetch(url,
      {
      
    method: "POST",
    body: data

    });

      res = await res.json();
      $dispositivos = res;
      console.log($dispositivos);   

     });

</script>

<div class="container">
<div class="grid end" >
 <Input
      type="search"
      name="search"
      id="exampleSearch"
      placeholder="Digite sua Busca" />

<Button type="action" {color}  > Adicionar Dispositivo </Button>

</div>
 <Tabela /> 

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