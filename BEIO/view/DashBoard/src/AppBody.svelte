<script>
  import CardGrid from './DashBoard/CardGrid.svelte';
  
  const info = [
    {
      nome: "  DashBoard",
      title: "Dash 1",
      description: "Aqui vamos testar nosso Codigo",
      imageUrl:
        "https://img2.gratispng.com/20180420/ugq/kisspng-computer-icons-management-chart-5ada1f60528a85.2393371215242443203381.jpg"
    },
    {
      nome: "  DashBoard 2",
      title: "Dash  2",
      description: "Aqui vamos testar nosso Codigo",
      imageUrl:
        "https://img2.gratispng.com/20180420/ugq/kisspng-computer-icons-management-chart-5ada1f60528a85.2393371215242443203381.jpg"
	},
	{
      nome: "  DashBoard 3",
      title: "Dash  3",
      description: "Aqui vamos testar nosso Codigo",
      imageUrl:
        "https://img2.gratispng.com/20180420/ugq/kisspng-computer-icons-management-chart-5ada1f60528a85.2393371215242443203381.jpg"
    }
  ];
</script>

<CardGrid info ={info} /> 