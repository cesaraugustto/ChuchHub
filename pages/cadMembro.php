<?php
session_start();
if(isset($_SESSION['id'])){

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

$_SESSION['sessaoMenu'] = 'cadMembro';

//Pega a data de hoje
$dataHoje = date('Y/m/d');

//Formatando a data
$dataFormatada = strtotime($dataHoje);
date('d/m/Y', $dataFormatada);



?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title>Cadastro de Membros</title>
    <?php include './header.php'; ?>
    <?php include './headerCadMembro.php'; ?>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#cpf").mask("000.000.000-00");
            $("#telefone").mask("(00) 00000-0000");
            $("#cep").mask("00000-000");

        })
    </script>
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
                                    <?php if(isset($_SESSION['conteudo']))
                                        { echo $_SESSION['conteudo']; 
                                    ?>
                                </p>
                            </blockquote>

                            <figcaption class="blockquote-footer">
                                <cite title="Source Title">
                                    <?php echo $_SESSION['livro']?>
                                </cite>
                                <?php echo ' '.$_SESSION['capitulo'].':'.$_SESSION['versiculo'];
                                unset($_SESSION['conteudo']);
                                unset($_SESSION['livro']);
                                unset($_SESSION['capitulo']);
                                unset($_SESSION['versiculo']);
                            }?>
                            </figcaption>

                        </div>
                    </figure>
                </div>
            </div>
            <div class="row mt-3">
                    <div class="col-xl-1"></div>
                    <div class="col">
                        <?php 
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                        ?>
                    </div>
                    <div class="col-xl-1"></div>
            </div>


            <div class="row"><!--Aqui começa formulário de cad-->
                <div class="col-xl-8"></div>
                <div class="col">
                    <form method="POST" name="form" action="cadMembro_ok.php" enctype="multipart/form-data" onsubmit="return verificarCampos()">
                        <div class="card flex-fill mx-4 mb-1">
                            <div CLASS="card-body">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="switchAdm" name="switchAdm">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">Este membro será Adm?</label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="row mx-4">
                <div class="card px-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Cadastro de Membros</h5>
                    </div>
                    <div class="card-body">
                    <div class="row">
                            <div class="col-12 col-xl-3 container d-flex align-items-end mt-2">
                                <figure class="image-container">
                                    <img id="chosen-image">
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
                                <input type="text" class="form-control" name="nome" id="nome">

                                <div class="row">
                                    <div class="col-8 col-xl-6">
                                        <label>Sexo</label>
                                        <select class="form-select m-0" aria-label="Default select example" name="sexo" id="sexo">
                                            <option value=""> </option>
                                            <option value="M">Masculino</option>
                                            <option value="F">Feminino</option>
                                        </select>
                                    </div>
                                    <div class="col-8 col-xl-6">
                                        <label>CPF</label>
                                        <input type="text" class="form-control" name="cpf" id="cpf">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8 col-xl-6">
                                        <label>Estado Civil</label>
                                        <select class="form-select m-0" aria-label="Default select example" name="estadoCivil" id="tipo">
                                            <option value=""></option>    
                                            <option value="Casado">Casado (a)</option>
                                            <option value="Solteiro">Solteiro (a)</option>
                                        </select>
                                    </div>
                                    <div class="col-8 col-xl-6">
                                        <label>Nascimento</label>
                                        <input type="date" id="dataNasc" name="dataNasc" class="form-control" value="" min="1940-01-01" max="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8 col-xl-6">
                                        <label>Telefone</label>
                                        <input type="text" class="form-control" name="telefone" id="telefone">
                                    </div>
                                    <div class="col-12 col-xl-6">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" id="email">
                                    </div>
                                </div>

                            </div>
                            <div class="col">

                                <div class="row">
                                    <div class="col-12 col-xl-8">
                                        <label>Endereço</label>
                                        <input type="text" class="form-control" name="endereco" id="endereco">
                                        <label>Cidade</label>
                                        <input type="text" class="form-control" name="cidade" id="cidade">
                                    </div>
                                </div>

                                <div class="row">

                                <div class="col-6 col-xl-8">
                                    <label>Estado</label>
                                    <select class="form-select m-0" aria-label="Default select example" name="uf" id="uf">
                                        <option value="MG">MG</option>
                                        <option value="AC">AC</option>
                                        <option value="AL">AL</option>
                                        <option value="AP">AP</option>
                                        <option value="AM">AM</option>
                                        <option value="BA">BA</option>
                                        <option value="CE">CE</option>
                                        <option value="DF">DF</option>
                                        <option value="ES">ES</option>
                                        <option value="GO">GO</option>
                                        <option value="MA">MA</option>
                                        <option value="MT">MT</option>
                                        <option value="MS">MS</option>
                                        <option value="PA">PA</option>
                                        <option value="PB">PB</option>
                                        <option value="PR">PR</option>
                                        <option value="PE">PE</option>
                                        <option value="PI">PI</option>
                                        <option value="RJ">RJ</option>
                                        <option value="RN">RN</option>
                                        <option value="RS">RS</option>
                                        <option value="RO">RO</option>
                                        <option value="RR">RR</option>
                                        <option value="SC">SC</option>
                                        <option value="SP">SP</option>
                                        <option value="SE">SE</option>

                                    </select>
                                </div>
                                    <div class="col-8">
                                        <label>CEP</label>
                                        <input type="text" class="form-control" name="cep" id="cep">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div><!--Fim do card principal-->




            <div class="row"><!--Inicio das informações complementares-->
                <div class="col-xl-12">
                    <div class="card mx-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Mais informações</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-2 col-10">
                                    <label>Foi batizado onde?</label>
                                    <select class="form-select m-0" aria-label="Default select example" name="localBatismo" id="localBatismo">
                                        <option value=""> </option>
                                        <option value="Aqui">Betel</option>
                                        <option value="Fora">Fora</option>
                                    </select>
                                </div>

                                <div class="col-xl-2 col-10">
                                    <label>Data do batismo</label>
                                    <input type="date" id="dataBatismo" name="dataBatismo" class="form-control" value="" min="" max="">
                                </div>
                                <div class="col-xl-1"></div>
                                <div class="col-xl-2 col-10">
                                    <label>Entrada na Betel</label>
                                    <input type="date" id="dataCadastro" name="dataCadastro" class="form-control" value="<?php echo date('Y-m-d'); ?>" min="1940-01-01" max="">
                                </div>

                                <div class="col-xl"></div>
                                <div class="col-xl-2">
                                    <button type="submit" class="mt-2 btn btn-outline-primary rounded-pill" value="Cadastrar">Cadastrar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--Fim das informações complementares-->



            <footer class="footer mt-5 flex-shrink-0 mt-auto">
                <?php include 'footer.php' ?>
            </footer>




<script>
   function verificarCampos() {
  const campos = document.querySelectorAll('input[type="text"], input[type="date"], select'); // Seleciona todos os campos de entrada de texto, date e select
  for (let i = 0; i < campos.length; i++) {
    const campo = campos[i];
    const valor = campo.value.trim();

    if (campo.type === 'date' && campo.name !== 'dataBatismo') {
      if (valor === '') {
        const alerta = document.createElement('div');
        alerta.classList.add('alert', 'alert-danger');
        alerta.textContent = `O campo ${campo.name} está vazio!`;

        const formulario = document.querySelector('form');
        formulario.insertBefore(alerta, formulario.firstChild);

        setTimeout(() => {
          alerta.remove();
        }, 5000);

        return false; // Cancela o envio do formulário
      }
    } else {
      if (campo.type !== 'file' && campo.name !== 'dataBatismo' && valor === '') {
        const alerta = document.createElement('div');
        alerta.classList.add('alert', 'alert-danger');
        alerta.textContent = `O campo ${campo.name} está vazio!`;

        const formulario = document.querySelector('form');
        formulario.insertBefore(alerta, formulario.firstChild);

        setTimeout(() => {
          alerta.remove();
        }, 5000);

        return false; // Cancela o envio do formulário
      }
    }
  }

  return true; // Permite o envio do formulário
}

</script>




<!--Liga o menu-->
<script src="../js/app.js"></script>
<script src="../js/imgPreview.js"></script>


<!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>
</body>
</html>


<?php } else{
        $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
        echo "<script>location.href = '../index.php'</script>" ;
}?>