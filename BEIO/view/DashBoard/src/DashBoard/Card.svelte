<script>  

import Chart from './Charts.svelte';

    export let title;
    export let description;
    export let chartsid;

</script>

<article>

    <div class="cards_item">
      <div class="card">
       <h2 class="card_title">{title}</h2>
        <div class="card_image">
          <Chart {chartsid} />
        </div>
        <div class="card_content">
         
          <p class="card_text">{description}</p>
        </div>
      </div>
    </div>



</article>

<style>
/* Font */
@import url('https://fonts.googleapis.com/css?family=Quicksand:400,700');

/* Design */
*,
*::before,
*::after {
  box-sizing: border-box;
}




img {
  height: auto;
  max-width: 100%;
  vertical-align: middle;
}




.card {
  background-color: white;
  border-radius: 0.25rem;
  box-shadow: 0 20px 40px -14px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  overflow: hidden;
}

.card_content {
  padding: 1rem;
  background: linear-gradient(to bottom left, #dfe6e9 40%, #dfe6e9 100%);
}

.card_title {
  color: gray;
  font-size: 1.1rem;
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: capitalize;
  margin: 0px;
  text-align: center;
}

.card_text {
  color: #000000;
  font-size: 0.875rem;
  line-height: 1.5;
  margin-bottom: 1.25rem;    
  font-weight: 400;
}

</style>