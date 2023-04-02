<?php
//Iniciando as variáveis de sessão
session_start();
if(isset($_SESSION['id'])){


$_SESSION['sessaoMenu'] = 'loginMembro';



//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


    //Sql para busca
    $sql = "SELECT * FROM usuario WHERE id = " . $_SESSION['id'];
    //Preparando para executar o comando SQL com a conexão
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    foreach ($stmt as $dadosBanco) {}
        if(empty($dadosBanco['foto'])){
            $foto = "fotoSemfoto.png";
        } else {
            $foto = $dadosBanco['foto']; }


    //Verificações para alteração de dados do usuário
    if (isset($_POST['verifica'])) {
        $verifica = $_POST['verifica'];
    } else {
        $verifica = null;
    }

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include './header.php'; ?>
    
    

    <title>Perfil de usuário</title>
    <style>
  /*Botão outline*/
  
  .btn-primary{
    background-color: #000b1f;
    color: #eff7ff;
    border-color: #000b1f;
    font-family: 'Tilt Neon', cursive;
    font-size: 17px; }

  .btn-primary:hover {
    border-color: #000b1f;
    background-color: #eff7ff;
    color: #000b1f;
    font-family: 'Tilt Neon', cursive;
  }

  .btn-outline-primary {
    border-color: #000b1f;
    background-color: #000b1f;
    color: #eff7ff;
    font-family: 'Tilt Neon', cursive;
  }
  .btn-outline-primary:hover {
    border-color: #000b1f;
    background-color: #000b1f;
    color: #eff7ff;
    font-family: 'Tilt Neon', cursive;
  }


  .btn-outline-secondary {
    color: #eff7ff;
    border-color: #000b1f;
    font-family: 'Tilt Neon', cursive;
    font-size: 15px;
  }
  .btn-outline-secondary:hover {
    border-color: #eff7ff;
    background-color: #eff7ff;
    color: #000b1f;
    font-family: 'Tilt Neon', cursive;
  }

.profile-head {
    transform: translateY(5rem);
}

.cover {
    background-image: url("../upload/user/waterfall2.png");
    background-size: cover;
    background-repeat: no-repeat;
}

.fonteTitulo{
    font-family: 'Tilt Neon', serif;
    color: #000b1f;
  }
  a, a:hover {
    color: inherit;
    text-decoration: none;
  }
    </style>
</head>

    <body>
        <div class="wrapper">
            <?php include './menu.php'; ?>

            <div class="main">
                <?php include 'topo.php'; ?>

                <div class="row my-4">

                <!--Alerts de update-->
                <?php 
                    if(isset($_SESSION['msgMembro'])){
                        echo $_SESSION['msgMembro'];
                        unset($_SESSION['msgMembro']);}
                ?>
                    <div class="col-md-5 mx-auto"> <!-- Profile widget -->
                        <div class="bg-white shadow rounded overflow-hidden">
                            <div class="px-2 pt-0 pb-4 cover">
                                <div class="media align-items-end profile-head">
                                    <div class="row">
                                        <div class="col-6">
                                            <img src="../upload/<?php echo $foto ?>" alt="Imagem Perfil" width="150" class="rounded mb-2 img-thumbnail">
                                        </div>
                                        <div class="col-6">
                                            <h3 class="fonteTitulo mb-0"><?php echo $dadosBanco['nome'] ?></h4>
                                            <h5 class="fonteTitulo"> <?php echo $dadosBanco['telefone'] ?></h5>
                                            <form method="POST" action="loginMembro.php">
                                                <input type="hidden" name="verifica" id="verifica" value="verifica">
                                                <button type="submit" class="btn btn-outline-primary" value="Alterar">Editar Perfil</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!--telefone,email,senha,foto-->


                            <div class="bg-light p-4 d-flex justify-content-end text-center">
                            </div>
                            <div class="px-4 py-3">
                                <h3 class="mb-0 fonteTitulo">Perfil</h3>
                                <div class="p-4 rounded shadow-sm bg-light">
                                    <!-- Se o membro não clicou em "alterar" então vai mostrar os dados em label-->
                                    <?php if (isset($verifica)) { ?>

                                        <form method="POST" action="loginMembro_update.php" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-xl-6 col-12">
                                                    <label class="fonteTitulo">Telefone</label>
                                                    <input type="text" class="form-control fonteTitulo" name="telefone" id="telefone" value="<?php echo $dadosBanco['telefone'] ?>">
                                                </div>
                                                <div class="col-xl-8 col-12">
                                                    <label class="fonteTitulo">Email</label>
                                                    <input type="text" class="form-control fonteTitulo" name="email" id="email" value="<?php echo $dadosBanco['email'] ?>">
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-8 col-12">
                                                    <label class="fonteTitulo">Senha</label>
                                                    <input type="password" class="form-control fonteTitulo" name="senha" id="senha" placeholder="Preencha caso queira alterar">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label>Foto</label>
                                                <input type="file" name="foto" id="foto">
                                                <input type="hidden" name="id" id="id" value="<?php echo $dadosBanco['id'] ?>">
                                            </div>
                                            <button type="submit" class="mt-2 btn btn-outline-primary rounded-pill" value="Alterar">Alterar</button>
                                        </form>
                                    <?php } else { ?>
                                        <h5>Telefone: </h5>
                                        <label><?php echo $dadosBanco['telefone'] ?></label>

                                        <h5>Email: </h5>
                                        <label><?php echo $dadosBanco['email'] ?></label>

                                        <h5>Cargo: </h5>
                                        <label><?php echo $dadosBanco['cargo'] ?></label>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="bg-light py-4 px-4">

                                <div class="row">
                                    <div class="col-12">
                                        <h3 class="fonteTitulo mb-0">Certificados</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 col-12">
                                        <button class="mt-2 btn btn-outline-primary rounded"><a class="text-decoration-none" href="../pdf/pdf_carteirinha.php?id=<?php echo $dadosBanco['id'] ?>">Carteirinha <?=$dadosBanco['cargo'];?></a></button>
                                    </div>

                                    <div class="col-12">
                                        <!--Verificações se o membro é consagrado-->
                                        <?php
                                            $sqlConsagrar = "SELECT * FROM consagracao WHERE idMembro = " . $_SESSION['id'];
                                            $buscaConsagrar = $conexao->prepare($sqlConsagrar);
                                            $buscaConsagrar->execute();

                                            

                                        if (($buscaConsagrar) and ($buscaConsagrar->rowCount() != 0)) { 
                                            foreach ($buscaConsagrar as $dadosConsagrar) {?>
                                            <button class="mt-2 btn btn-outline-primary rounded"><a href="../pdf/pdf_consagrar.php?consagracao_id=<?php echo $dadosConsagrar['id'] ?>">Certificado Consagracao a <?= $dadosConsagrar['novoCargo']; ?></a></button>
                                        <?php } } ?>
                                    </div>


                                    <div class="col-12">
                                        <!--Verificações se o membro é batizado-->
                                        <?php
                                            $sqlBatismo = "SELECT * FROM batismo WHERE idMembro = " . $_SESSION['id'];
                                            $buscaBatismo = $conexao->query($sqlBatismo);
                                            foreach($buscaBatismo as $dadosBatismo){};
                                            
                                        if ($dadosBatismo['batismoAqui'] == "Aqui") { ?>
                                            <button class="mt-2 btn btn-outline-primary rounded"><a href="../pdf/pdf_batismo.php?usuario_id=<?php echo $dadosBanco['id'] ?>">Certificado Batismo</a></button>
                                        <?php } ?>
                                    </div>


                                    <div class="col-12">
                                        <!--Verificações se o membro fez curso -->
                                        <?php
                                            $sqlCurso = "SELECT * FROM cursoobreiro WHERE idAluno = " . $_SESSION['id'];
                                            $buscaCurso = $conexao->prepare($sqlCurso);
                                            $buscaCurso->execute();
                                            

                                        if (($buscaCurso) and ($buscaCurso->rowCount() != 0)) {
                                            foreach($buscaCurso as $dadosCurso){ ?>
                                            <button class="mt-2 btn btn-outline-primary rounded"><a href="../pdf/pdf_curso.php?cursoobreiro_id=<?php echo $dadosCurso['id'] ?>">Certificado Curso <?= $dadosCurso['nomeCurso']; ?></a></button>
                                        <?php } } ?>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer">
                    <?php include 'footer.php' ?>
                </footer>
            </div>
        </div>


        <script src="../js/app.js"></script>
        <script type="text/javascript">
            $("#telefone, #celular").mask("(00) 00000-0000");
        </script>
    </body>

<!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>
</html>



<?php } else{
        $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
        echo "<script>location.href = '../index.php'</script>" ;
}?>