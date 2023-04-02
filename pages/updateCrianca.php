<?php
session_start();
if (isset($_SESSION['id'])) {

    //Puxar a classe de conexão
    include '../Connection/classeConexao.php';
    //Puxar a função de conexão
    $conexao = getConnection();

    $_SESSION['sessaoMenu'] = 'crianca';

    $id = "";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $comando = "SELECT * FROM crianca WHERE id = " . $id;
    } else {
        $comando = "SELECT * FROM crianca ORDER BY nome";
    }



    //Abrindo a conexão e executando o comando sql
    $sql = $conexao->query($comando);


    foreach ($sql as $dadosBanco) {
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Editar Criança</title>
        <?php include './header.php'; ?>
        <?php include './headerCadMembro.php'; ?>
    </head>

    <body>
        <div class="wrapper">
            <?php include './menu.php'; ?>

            <div class="main">
                <?php include 'topo.php'; ?>


                <div class="row p-3">
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
                        } ?>
                    </div>
                    <div class="col-xl-1"></div>
                </div>

                <!--Body começa aqui-->
                <div class="row mx-4">
                    <div class="card px-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Cadastro de Membros</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="excluirCrianca.php">
                                <button type="submit" class="btn btn-outline-danger">Excluir</button>
                                <input type="hidden" id="id" name="id" value="<?php echo $dadosBanco['id']; ?>">
                            </form>
                            <form method="POST" action="updateCrianca_ok.php" enctype="multipart/form-data" id="formCrianca" onsubmit="return verificarCampos('formCrianca')">
                                <div class="row">
                                    <div class="col-12 col-xl-3 container d-flex align-items-end">
                                        <figure class="image-container">
                                            <img id="chosen-image" src="../upload/<?php echo $dadosBanco['foto'] ?>" class="rounded-4" style="width: 150px;">
                                            <figcaption id="file-name"></figcaption>
                                            <input type="file" id="upload-button" name="foto" accept="image/png, image/jpeg">
                                            <label for="upload-button" class="labelFoto p-2 rounded">
                                                <i class="align-middle" data-feather="camera"></i> &nbsp;
                                                Escolha uma foto
                                            </label>
                                        </figure>

                                    </div>
                                    <div class="col">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome" value="<?php echo $dadosBanco['nome'] ?>">

                                        <div class="row">
                                            <div class="col-12 col-xl-6">
                                                <label>Nome Pai</label>
                                                <input type="text" class="form-control" name="nomePai" id="nomePai" value="<?php echo $dadosBanco['nomePai'] ?>">
                                            </div>
                                            <div class="col-12 col-xl-6">
                                                <label>Nome Mãe</label>
                                                <input type="text" class="form-control" name="nomeMae" id="nomeMae" value="<?php echo $dadosBanco['nomeMae'] ?>">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-8 col-xl-6">
                                                <label>Data Nascimento:</label>
                                                <input type="date" class="form-control" value="<?php echo $dadosBanco['dataNascimento']; ?>" name="dataNascimento" id="dataNascimento">
                                            </div>
                                            <div class="col-8 col-xl-6">
                                                <label>Data Apresentacao:</label>
                                                <input type="date" class="form-control" value="<?php echo $dadosBanco['dataInclusao']; ?>" name="dataInclusao" id="dataInclusao">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8 col-xl-6">
                                                <label>Sexo </label><br>
                                                <!--Esses if são para deixar marcado o sexo a depender do cadastro-->
                                                <input type="radio" class="form-check-input" id="sexo" name="sexo" value="M" <?php if ($dadosBanco['sexo'] == "M") { ?> checked <?php } ?>>
                                                <label>Masculino</label>
                                                <input type="radio" class="form-check-input" id="sexo" name="sexo" value="F" <?php if ($dadosBanco['sexo'] == "F") { ?> checked <?php } ?>>
                                                <label>Feminino</label>

                                                <input type="hidden" value="<?php echo $dadosBanco['id']; ?>" name="id" id="id">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-10 col-4">
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="ps-5 pe-5 btn btn-outline-primary" value="Alterar">Alterar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!--Fim do card principal-->


                <footer class="footer flex-shrink-0 mt-auto">
                    <?php include 'footer.php' ?>
                </footer>

            </div>

        </div>




        <script>
            function verificarCampos(formId) {
                const campos = document.querySelectorAll(`#${formId} input:not([type="file"]):not([name="dataInclusao"]), #${formId} select`);
                let erroEncontrado = false;
                let mensagemErro = '';

                for (let i = 0; i < campos.length; i++) {
                    const campo = campos[i];
                    const valor = campo.value.trim();

                    if (valor === "") {
                        erroEncontrado = true;
                        mensagemErro += `<li>O campo ${campo.name} está vazio!</li>`;
                    }
                }

                if (erroEncontrado) {
                    const alerta = document.createElement("div");
                    alerta.classList.add("alert", "alert-danger", "fade", "show");
                    alerta.innerHTML = `<h5>Os seguintes campos estão vazios:</h5><ul>${mensagemErro}</ul>`;
                    const modalBody = document.querySelector(`#${formId}`);
                    modalBody.insertBefore(alerta, modalBody.firstChild);

                    setTimeout(() => {
                        alerta.classList.remove("show");
                        setTimeout(() => {
                            alerta.remove();
                        }, 1000);
                    }, 3000);

                    return false; // Cancela o envio do formulário
                } else {
                    return true; // Permite o envio do formulário
                }
            }
        </script>

        <!--Função que faz o alert sumir sozinho-->
        <script>
            window.setTimeout(function() {
                $(".alert").fadeTo(1000, 0).slideUp(1000, function() {
                    $(this).remove();
                });
            }, 1000);
        </script>



        <script src="../js/app.js"></script>
        <script src="../js/imgPreview.js"></script>
    </body>

    </html>


<?php } else {
    $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
    echo "<script>location.href = '../index.php'</script>";
} ?>