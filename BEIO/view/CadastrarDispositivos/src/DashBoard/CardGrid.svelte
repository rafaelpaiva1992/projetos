<script>
    import Card from './Card.svelte';
    export let info;


</script>


<section id="cards">
  {#each info as data}
    <Card
      title = {data.title}
      description = {data.description}
      chartsid = {data.title} />

  {/each}

</section>

<style>
section{
    margin:10px;
    width: 100%;
    display: grid;
    grid-template-columns: 1fr;
    grid-gap: 1rem;
}

@media (min-width: 768px){
    section{
        grid-template-columns: repeat(3, 1fr);
    }
}
</style>