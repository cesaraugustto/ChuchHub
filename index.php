<?php
session_start();

//Puxar a classe de conexão
include './Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="./site/images/icons/angel.png">
  <link href="https://fonts.googleapis.com/css?family=Quicksand:400,600,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./site/fonts/icomoon/style.css">




  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@700&family=Pacifico&family=Tilt+Neon&display=swap" rel="stylesheet">


  <!-- Lib Animation -->
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <!-- Style -->
  <link rel="stylesheet" href="./site/css/style.css">
  <title>Comunidade Betel</title>
</head>

<body>

  <!--Alerts-->
  <?php
  if (isset($_SESSION['msgLogin'])) {
    echo $_SESSION['msgLogin'];
    unset($_SESSION['msgLogin']);
  }
  ?>



<form method="POST" action="./pages/login_ok.php">
            <div class="row pt-3">
              <div class="col-3"></div>
              <div class="col-xl-6 col-12">
                <label class="azulEscuro">Login</label>
                <input type="text" class="form-control" placeholder="Digite seu CPF" name="login" id="login">
              </div>
              <div class="col-3"></div>
            </div>
            <div class="row pb-2">
              <div class="col-3"></div>
              <div class="col-xl-6 col-12">
                <label class="azulEscuro">Senha</label>
                <input type="password" class="form-control" placeholder="Digite sua senha" name="senha" id="senha">
              </div>
              <div class="col-2"></div>
            </div>
            <div class="row pb-2 pt-1">
              <div class="col-xl-3"></div>
              <div class="col-6">
                  <button type="submit" class="btn btn-primary">Entrar</button>
              </div>
              <div class="col-2"></div>
            </div>
            <div class="row pb-2">
              <div class="text-center">
                <p class="pb-0 mb-0 azulEscuro">Ainda não é um membro?</p> <a class="secondaryColor" style="cursor: pointer;" href="https://api.whatsapp.com/send?phone=5531992005608&text=Mensagem%20padrao%20betel" target="_blank">Entre em contato!</a>
              </div>
            </div>
          </form>




<!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>