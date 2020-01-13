
<script>
export let chartsid;

import {onMount} from 'svelte';

function createChart()
{
var chart = {chartsid}
 
var ctx = document.getElementById(chart.chartsid).getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [{
            label: 'My First dataset',
            backgroundColor: 'rgba(255, 255, 255, 0)',
            borderColor: 'rgb(155, 0, 0)',
            data: [0, 10, 5, 2, 20, 30, 45]
        }]
    },

    // Configuration options go here
    options: {}
});

}

onMount(createChart);

</script>

<canvas id="{chartsid}"></canvas>

<style> 
canvas{
    width: 100%;
}
</style>


