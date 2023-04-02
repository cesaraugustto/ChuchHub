<?php
session_start();
if(isset($_SESSION['id'])){

$_SESSION['sessaoMenu'] = 'crianca';
//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


$nome = "";
if(isset($_GET['nome'])){
    $nome = $_GET['nome'];
}


//Procedimentos para abrir numa pesquisa geral se não existir filtro
if(!isset($_GET['nome'])){ $sqlPesquisa = "SELECT * FROM crianca ORDER BY id DESC";}
else{ $sqlPesquisa = "SELECT * FROM crianca WHERE nome LIKE '%".$_GET['nome']."%' ";}





//<!--Paginação aqui-->

//Se recebeu parametro 'página' via GET, então vai armazenar, se não tá na primeira pag
$pagina = 1;
if(isset($_GET['pagina'])){
    $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT); //Arredondar pra cima
}
if(!$pagina)//Se não existir página, volta a receber pag 1
    $pagina = 1;

$resultadosPorPagina = 10;
$inicio = ($pagina * $resultadosPorPagina) - $resultadosPorPagina;

                
//pegando o número total de registros de acordo com os filtros
$paginacao = str_replace("SELECT * FROM","SELECT COUNT(*) count FROM",$sqlPesquisa);
//echo $paginacao;

//Para pegar o ultimo registro
$totalResultados = $conexao->query($paginacao)->fetch()["count"];
$totalPaginas = ceil($totalResultados / $resultadosPorPagina);
//echo 'As páginas: '.$totalPaginas.', Total de resultados: '.$totalResultados;    


//Concatenando a variavel de pesquisa aos filtros acima
$sqlPesquisa .= " LIMIT $inicio, $resultadosPorPagina";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Crianças</title>
    <?php include './header.php';?>
    <?php include './headerCadMembro.php'; ?>

    <style>
        /*Botão listagem na tabela*/
        .imgPerfil{ width: 10vw; }

            @media(max-width: 425px){
                .imgPerfil{
                    width: 30vw; 
                }
            }
    </style>

</head>
<body>
<div class="wrapper">
        <?php include './menu.php';?>

        <div class="main">
            <?php include 'topo.php';?>
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
                            unset($_SESSION['msg']);}?>
                    </div>
                    <div class="col-xl-1"></div>
                </div>

                <div class="row mx-4"><!--Inicio do formulário de pesquisa-->
                    <div class="card p-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Pesquisar Crianças</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="apresentarCrianca.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome">
                                    </div>
                                    <div class="col-xl-1"></div>
                                    <div class="col-5 mt-4">
                                        <button type="submit" class="btn btn-outline-primary" value="Pesquisar">Pesquisar</button>
                                    </div>
                                    <div class="col mt-4">
                                        <!--Incluir membro Modal-->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whateverNome="" data-bs-whateverSexo="" data-bs-whateverData="">Adicionar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!--Fim do formulário de pesquisa-->
                <div class="row mx-4"><!--Inicio da tabela-->
                    <div class="card p-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Ultimas crianças apresentadas</h5>
                        </div>
                        <table class="table table-hover" name="table" id="table">
                            <thead class="table-light">
                                <tr>
                                    <td class="d-none d-sm-table-cell"></td>
                                    <td class="d-none d-sm-table-cell"><strong>Nome</strong></td>
                                    <td class="d-none d-sm-table-cell"><strong>Pais</strong></td>
                                    <td class="d-none d-sm-table-cell"></td>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                        //Abrindo a conexão e executando o comando sql
                                        $sql = $conexao->query($sqlPesquisa);
                                        //Efetuando a pesquisa e apresentando na tabela
                                            foreach($sql as $sqlPesquisa){
                                                if(empty($sqlPesquisa['foto'])){
                                                    $fotoCrianca = "../upload/fotoSemfoto.png";
                                                }else{ $fotoCrianca = $sqlPesquisa['foto'];}
                                    ?>
                                    <tr>
                                        <td><a href= "updateCrianca.php?id=<?php echo $sqlPesquisa['id']?>">
                                            <img src="../upload/<?php echo $fotoCrianca?>" class="rounded-4 imgPerfil"></a>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <?php echo $sqlPesquisa['nome']."<br>Nasceu em: ".$sqlPesquisa['dataNascimento']?>
                                        </td>
                                        <td class="d-none d-sm-table-cell">
                                            <?php echo $sqlPesquisa['nomeMae'].'<br> e '.$sqlPesquisa['nomePai']?>
                                        </td>
                                        <td>
                                            <a href= "../pdf/pdf_crianca.php?id=<?php echo $sqlPesquisa['id']?>" class="btn btn-outline-primary">Certificado</a>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                        </table>
                    </div>
                </div><!--Fim da linha tabela-->





            <div class="row mx-2">
                <div class="row">
                <!--Paginação aqui-->
                <div class="col">
                    <nav aria-label="Navegação de página exemplo">
                    <ul class="pagination">
                        <li class="page-item"><a class="page-link" href="?pagina=1">Primeira</a></li>
                            <?php if($pagina > 1):?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?=$pagina-1?>"><<</a></li>
                            <?php endif; ?>
                        <li class="page-item"><a class="page-link" href="#"><?=$pagina?></a></li>
                            <?php if($pagina < $totalPaginas):?>
                                <li class="page-item"><a class="page-link" href="?pagina=<?=$pagina+1?>">>></a></li>
                            <?php endif; ?>
                        <li class="page-item"><a class="page-link" href="?pagina=<?=$totalPaginas?>">Ultima</a></li>
                    </ul>
                    </nav>
                </div>


                <div class="col">                    
                </div>
            </div>
            </div>




            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
</div>

<!--Modal para Cadastrar Criança-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"> </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">


            <form method="POST" action="apresentarCrianca_ok.php" enctype="multipart/form-data" id="formCrianca" onsubmit="return verificarCampos('formCrianca')">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-12 col-xl-12 mt-5">
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
                            <label for="recipient-name" class="col-form-label">Nome Criança:</label>
                            <input type="text" class="form-control" id="recipient-name" name="nome">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <label for="recipient-name" class="col-form-label">Nome Pai:</label>
                            <input type="text" class="form-control" id="recipient-name" name="nomePai">
                        </div>
                        <div class="col-xl-6 col-12">
                            <label for="recipient-name" class="col-form-label">Nome Mãe:</label>
                            <input type="text" class="form-control" id="recipient-name" name="nomeMae">
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-xl-4 col-6">
                            <label>Sexo</label>
                            <select class="form-select m-0" aria-label="Default select example" id="modalBodySexo" name="sexo">
                                <option value="F">Feminino</option>
                                <option value="M">Masculino</option>
                            </select>
                        </div>
                        <div class="col-xl-4 col-8">
                            <label>Data Nascimento</label>
                            <input type="date" id="modalBodyData" name="dataNascimento" class="form-control">
                        </div>
                        <div class="col-xl-4 col-8">
                            <label>Data Apresentação</label>
                            <input type="date" id="modalBodyData" name="dataInclusao" class="form-control" class="form-control" value="<?php echo date('Y-m-d');?>">
                        </div>
                    </div>                 
                </div>

                <!--<label>Foto</label>-->
                <!--<input type="file" id="modalBodyFoto" name="foto">-->

                <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
            </form>


        </div>
    </div>
  </div>
</div>





<!--JavaScript Modal Cadastro-->
<script type="text/javascript">
    const exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipientId = button.getAttribute('data-bs-whateverId')
        const recipientNome = button.getAttribute('data-bs-whateverNome')
        const recipientCargo = button.getAttribute('data-bs-whateverCargo')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const modalTitle = exampleModal.querySelector('.modal-title')
        const modalBodyInput = exampleModal.querySelector('.modal-body input')
        const modalBodyText = exampleModal.querySelector('.modal-body #cargo-text')
        const modalBodyId = exampleModal.querySelector('.modal-body #modalBodyId')

        modalTitle.textContent = `Apresentar Criança`
        modalBodyInput.value = recipientNome
        modalBodyText.value= recipientCargo
        modalBodyId.value = recipientId

})
</script>

    <script src="../js/app.js"></script>
    <script src="../js/imgPreview.js"></script>

<!--Função que faz rolar a tela na navegação-->
<script>
    $(document).ready(function() {
    $(".page-link").click(function(event){
        event.preventDefault();
        var params = $(this).attr('href').split('?')[1];
        window.location.href = '?'+params+'#table';
    });
    });

    window.onload = function() {
    var hash = window.location.hash;
    if (hash === '#table') {
        $(window).scrollTop($('#table').offset().top);
    }
    }
</script>



<!--Função que verifica campos do modal-->
<script>
function verificarCampos(formId) {
  const campos = document.querySelectorAll(`#${formId} input:not([type="file"]):not([name="dataInclusao"]):not([type="date"][name="dataBatismo"]), #${formId} select`);
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
    alerta.classList.add("alert", "alert-danger");
    alerta.innerHTML = `<h5>Os seguintes campos estão vazios:</h5><ul>${mensagemErro}</ul>`;
    const modalBody = document.querySelector(`#${formId}`);
    modalBody.insertBefore(alerta, modalBody.firstChild);

    setTimeout(() => {
        alerta.classList.add("show");
        alerta.classList.remove("fade");
        setTimeout(() => {
        alerta.remove();
        }, 3000);
    }, 100);

    return false; // Cancela o envio do formulário
  } else {
    return true; // Permite o envio do formulário
  }
}

</script>



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