<script>
  import {
    Button, Card, CardBody, CardFooter, CardHeader,
    CardImg, CardSubtitle, CardText, CardTitle,Input,Label
  } from "sveltestrap";
  const color = "primary";
</script>


<form action="/login" method="post">
<div class=" largura">
<Card>
  <CardHeader>
    <CardTitle>Login</CardTitle>
  </CardHeader>
  <CardBody>
    <Label >Email:</Label>
    <Input type="email"  name="login" />

    <Label>Senha:</Label>
    <Input type="password" name="password" />
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
 .align{
     width: 200px;
     margin-top:5%;
     margin-left: auto;
     margin-right: auto;
     display:block;
     }
</style>