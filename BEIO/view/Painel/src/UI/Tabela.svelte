<script>
import { Table, Button } from "sveltestrap";
import {dispositivos} from './../dispositivos.js'
export let disp = {};

console.log("disp0:", disp);
</script>

<Table hover>
  <thead>
  <tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Codigo</th>
    <th>Descrição</th>
  </tr>
  </thead>
  <tbody>

 {#each $dispositivos as data}
   <tr>
    <th scope="row">{data.ID}</th>
    <td>{data.Nome}</td>
    <td>{data.CodigoLabel}</td>
    <td>{data.DescricaoDispositivo}</td>
  </tr>
 

  {/each}

 </tbody>
</Table>