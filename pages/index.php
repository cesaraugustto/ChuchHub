<?php
session_start();
if(isset($_SESSION['id'])){

$_SESSION['sessaoMenu'] = 'index';

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include './header.php';?>
    
    <!--Máscara de valor, tive que tirar do header pois entrava em conflito com a máscara de cpf-->
    <script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>
    <title>ChurchHub 1.0</title>
	
</head>
<body>
    <div class="wrapper">
        <?php include './menu.php';?>

        <div class="main">
            <?php include 'topo.php';?>
    
            <?php include 'corpo.php';?>

            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
    </div>

    <script src="../js/app.js"></script>



<!--Máscara valor-->
<script>
    $(function(){
        $('#valorInserir').maskMoney({
            prefix:'R$ ',
            allowNegative: true,
            thousands:'.', decimal:',',
            affixesStay: true});
    })
</script>


<!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>

<script>//Função para verificar preenchimento do formulário
function verificarValor() {
  const campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
  for (let i = 0; i < campos.length; i++) {
    const campo = campos[i];
    const valor = campo.value.trim();

    if (valor === "") {
      const alerta = document.createElement("div");
      alerta.classList.add("alert", "alert-danger");
      alerta.textContent = `O campo ${campo.name} está vazio!`;
      const formulario = document.querySelector("form");
      formulario.insertBefore(alerta, formulario.firstChild);
      setTimeout(() => {
        alerta.classList.add("show");
        alerta.classList.remove("fade");
        setTimeout(() => {
          alerta.remove();
        }, 3000);
      }, 100);
      return false; // Cancela o envio do formulário
    }
  }
  return true; // Permite o envio do formulário
}
</script>


</body>
</html>




<?php } else{
        $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
        echo "<script>location.href = '../index.php'</script>" ;
}?>