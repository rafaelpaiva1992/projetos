<script>
  import {
    Button, Card, CardBody, CardFooter, CardHeader,
    CardImg, CardSubtitle, CardText, CardTitle,Input,Label
  } from "sveltestrap";
  const color = "primary";
</script>


<form enctype="multipart/form-data" action="/registrar" method="post">
<div class=" largura">
<Card>
  <CardHeader>
    <CardTitle>Registrar:</CardTitle>
  </CardHeader>
  <CardBody>
    <Label >Nome:</Label>
    <Input type="text"  name="nome" />

    <Label >Email:</Label>
    <Input type="email"  name="email" />

    <Label>Senha:</Label>
    <Input type="password" name="password" />

    <input type="file" name="picture" id="picture" />


    <Button type="submit" {color} block > Enviar </Button>
  </CardBody>

</Card>
</div>

</form>
<style>


 .largura{
   margin: 0 auto;
	width: 300px;
	margin-top:5%;
    position: relative;
    
 }

 #picture{
   width: 90%;

 }


 .align{
     width: 200px;
     margin-top:5%;
     margin-left: auto;
     margin-right: auto;
     display:block;
     }
</style>