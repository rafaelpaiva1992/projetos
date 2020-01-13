<script>
    import Card from './Card.svelte';
    export let info;


</script>


<section id="cards">

  {#each info as data}
    <Card
      title = {data.title}
      chartsid = {data.title} />

  {/each}

</section>

<style>
section{
    margin:10px;
    width: 90%;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    grid-gap: 1rem;
}

@media (max-width: 768px){
    section{
        grid-template-columns:  1fr;
    }
}
</style>