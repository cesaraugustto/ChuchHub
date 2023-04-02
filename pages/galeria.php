<?php
session_start();
if (isset($_SESSION['id'])) {

    //Puxar a classe de conexão
    include '../Connection/classeConexao.php';
    //Puxar a função de conexão
    $conexao = getConnection();

    $_SESSION['sessaoMenu'] = 'galeria';

?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <title>Galeria de imagens</title>
        <?php include './header.php'; ?>
        <?php include './headerCadMembro.php'; ?>
    </head>

    <body>


        <div class="wrapper">
            <?php include './menu.php'; ?>

            <div class="main">
                <?php include 'topo.php'; ?>

                <!--Aqui começa o body-->
                <div class="row mt-2">
                    <div class="col-12">
                        <figure>
                            <div class="text-center">
                                <blockquote class="blockquote">
                                    <p style="font-size:14px; ">
                                        <?php if (isset($_SESSION['conteudo'])) {
                                            echo $_SESSION['conteudo'];
                                        ?>
                                    </p>
                                </blockquote>

                                <figcaption class="blockquote-footer">
                                    <cite title="Source Title">
                                        <?php echo $_SESSION['livro'] ?>
                                    </cite>
                                <?php echo ' ' . $_SESSION['capitulo'] . ':' . $_SESSION['versiculo'];
                                            unset($_SESSION['conteudo']);
                                            unset($_SESSION['livro']);
                                            unset($_SESSION['capitulo']);
                                            unset($_SESSION['versiculo']);
                                        } ?>
                                </figcaption>

                            </div>
                        </figure>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-1"></div>
                    <div class="col">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                    </div>
                    <div class="col-xl-1"></div>
                </div>

                <div class="row px-3">

                    <!--Botão para CURSO -->



                    <div class="col-xl-4"></div>
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title mb-0">Alterar imagens da galeria</h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn-custom btn btn-outline-primary col-xl-6 col-10 mt-1" data-bs-toggle="modal" data-bs-target="#primeiraImagem" data-bs-whateverIdConsagrar="3">1º Imagem</button>
                                </div>
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn-custom btn btn-outline-primary col-xl-6 col-10 mt-1" data-bs-toggle="modal" data-bs-target="#segundaImagem" data-bs-whateverId="1">2º Imagem</button>
                                </div>
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn-custom btn btn-outline-primary col-xl-6 col-10 mt-1" data-bs-toggle="modal" data-bs-target="#terceiraImagem" data-bs-whateverIdConsagrar="4">3º Imagem</button>
                                </div>
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn-custom btn btn-outline-primary col-xl-6 col-10 mt-1" data-bs-toggle="modal" data-bs-target="#quartaImagem" data-bs-whateverIdConsagrar="4">4º Imagem</button>
                                </div>
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn-custom btn btn-outline-primary col-xl-6 col-10 mt-1" data-bs-toggle="modal" data-bs-target="#quintaImagem" data-bs-whateverIdConsagrar="4">5º Imagem</button>
                                </div>
                                <div class="col-12 mb-2">
                                    <button type="button" class="btn-custom btn btn-outline-primary col-xl-6 col-10 mt-1" data-bs-toggle="modal" data-bs-target="#sextaImagem" data-bs-whateverIdConsagrar="4">6º Imagem</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4"></div>

                </div>








                <footer class="footer mt-5 flex-shrink-0 mt-auto">
                    <?php include 'footer.php' ?>
                </footer>
            </div>




            <!--Modal 1º Imagem-->
            <div class="modal fade" id="primeiraImagem" tabindex="-1" aria-labelledby="primeiraImagem" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title1Imagem fs-5" id="exampleModalLabelr">1º Imagem </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="galeria_ok.php" enctype="multipart/form-data">
                                <input type="hidden" name="id" id="id" value="1">
                                <?php
                                //Abrindo a conexão e executando o comando sql
                                $sql1 = $conexao->query("SELECT * FROM galeria WHERE id = 1");
                                //Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
                                foreach ($sql1 as $dadosBanco1){}
                                ?>

                                <figure class="image-container">
                                    <img id="chosen-image" src="../site/images/galeria/<?php echo $dadosBanco1['foto'];?>" class="rounded-4 mb-2" style="width: 150px;">
                                    <figcaption id="file-name"></figcaption>
                                    <input type="file" id="upload-button" name="foto" accept="image/png, image/jpeg">
                                    <label for="upload-button" class="labelFoto p-2 rounded">
                                        <i class="align-middle" data-feather="camera"></i> 
                                        &nbsp; Escolha uma foto
                                    </label>
                                </figure>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline-primary">Alterar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

<!--Modal 2º Imagem-->
<div class="modal fade" id="segundaImagem" tabindex="-1" aria-labelledby="segundaImagem" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title1Imagem fs-5" id="exampleModalLabelr">2º Imagem </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="galeria_ok.php" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="2">
          <?php
          //Abrindo a conexão e executando o comando sql
          $sql1 = $conexao->query("SELECT * FROM galeria WHERE id = 2");
          //Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
          foreach ($sql1 as $dadosBanco1){}
          ?>
            <figure class="image-container">
                <img id="chosen-image2" src="../site/images/galeria/<?php echo $dadosBanco1['foto'];?>" class="rounded-4 mb-2" style="width: 150px;">
                <figcaption id="file-name2"></figcaption>
                <input type="file" id="upload-button2" name="foto" accept="image/png, image/jpeg">
                <label for="upload-button2" class="labelFoto p-2 rounded">
                <i class="align-middle" data-feather="camera"></i> 
                &nbsp; Escolha uma foto
                </label>
            </figure>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-outline-primary">Alterar</button>
      </div>
        </form>
    </div>
  </div>
</div>


            <!--Modal 3º Imagem-->
            <div class="modal fade" id="terceiraImagem" tabindex="-1" aria-labelledby="terceiraImagem" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title1Imagem fs-5" id="exampleModalLabelr">3º Imagem </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="galeria_ok.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="3">
                                <?php
                                //Abrindo a conexão e executando o comando sql
                                $sql1 = $conexao->query("SELECT * FROM galeria WHERE id = 3");
                                //Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
                                foreach ($sql1 as $dadosBanco1){}
                                ?>

                            <figure class="image-container">
                                <img id="chosen-image3" src="../site/images/galeria/<?php echo $dadosBanco1['foto'];?>" class="rounded-4 mb-2" style="width: 150px;">
                                <figcaption id="file-name3"></figcaption>
                                <input type="file" id="upload-button3" name="foto" accept="image/png, image/jpeg">
                                <label for="upload-button3" class="labelFoto p-2 rounded">
                                <i class="align-middle" data-feather="camera"></i> 
                                &nbsp; Escolha uma foto
                                </label>
                            </figure>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline-primary">Alterar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Modal 4º Imagem-->
            <div class="modal fade" id="quartaImagem" tabindex="-1" aria-labelledby="quartaImagem" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title1Imagem fs-5" id="exampleModalLabelr">4º Imagem </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="galeria_ok.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="4">
                                <?php
                                //Abrindo a conexão e executando o comando sql
                                $sql1 = $conexao->query("SELECT * FROM galeria WHERE id = 4");
                                //Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
                                foreach ($sql1 as $dadosBanco1){}
                                ?>

                            <figure class="image-container">
                                <img id="chosen-image4" src="../site/images/galeria/<?php echo $dadosBanco1['foto'];?>" class="rounded-4 mb-2" style="width: 150px;">
                                <figcaption id="file-name4"></figcaption>
                                <input type="file" id="upload-button4" name="foto" accept="image/png, image/jpeg">
                                <label for="upload-button4" class="labelFoto p-2 rounded">
                                <i class="align-middle" data-feather="camera"></i> 
                                &nbsp; Escolha uma foto
                                </label>
                            </figure>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline-primary">Alterar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--Modal 5º Imagem-->
            <div class="modal fade" id="quintaImagem" tabindex="-1" aria-labelledby="quintaImagem" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title1Imagem fs-5" id="exampleModalLabelr">5º Imagem </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="galeria_ok.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="5">
                                <?php
                                //Abrindo a conexão e executando o comando sql
                                $sql1 = $conexao->query("SELECT * FROM galeria WHERE id = 5");
                                //Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
                                foreach ($sql1 as $dadosBanco1){}
                                ?>


                            <figure class="image-container">
                                <img id="chosen-image5" src="../site/images/galeria/<?php echo $dadosBanco1['foto'];?>" class="rounded-4 mb-2" style="width: 150px;">
                                <figcaption id="file-name5"></figcaption>
                                <input type="file" id="upload-button5" name="foto" accept="image/png, image/jpeg">
                                <label for="upload-button5" class="labelFoto p-2 rounded">
                                <i class="align-middle" data-feather="camera"></i> 
                                &nbsp; Escolha uma foto
                                </label>
                            </figure>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline-primary">Alterar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Modal 6º Imagem-->
            <div class="modal fade" id="sextaImagem" tabindex="-1" aria-labelledby="sextaImagem" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title1Imagem fs-5" id="exampleModalLabelr">6º Imagem </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="galeria_ok.php" enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="6">
                                <?php
                                //Abrindo a conexão e executando o comando sql
                                $sql1 = $conexao->query("SELECT * FROM galeria WHERE id = 6");
                                //Aqui no foreach aparentemente estou criando um vetor com dadosBanco com os dados referente a consulta
                                foreach ($sql1 as $dadosBanco1){}
                                ?>

                            <figure class="image-container">
                                <img id="chosen-image6" src="../site/images/galeria/<?php echo $dadosBanco1['foto'];?>" class="rounded-4 mb-2" style="width: 150px;">
                                <figcaption id="file-name6"></figcaption>
                                <input type="file" id="upload-button6" name="foto" accept="image/png, image/jpeg">
                                <label for="upload-button6" class="labelFoto p-2 rounded">
                                <i class="align-middle" data-feather="camera"></i> 
                                &nbsp; Escolha uma foto
                                </label>
                            </figure>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-outline-primary">Alterar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>





                <!--Liga o menu-->
                <script src="../js/app.js"></script>
                <script src="../js/previewGaleria.js"></script>

            <!--Função que faz o alert sumir sozinho-->
            <script>
                window.setTimeout(function() {
                    $(".alert").fadeTo(500, 0).slideUp(500, function() {
                        $(this).remove();
                    });
                }, 3000);
            </script>
    </body>

    </html>


<?php } else {
    $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
    echo "<script>location.href = '../index.php'</script>";
} ?>