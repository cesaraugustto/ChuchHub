<?php
session_start();
if(isset($_SESSION['id'])){

$_SESSION['sessaoMenu'] = 'consagrar';
//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();


//Procedimentos para abrir numa pesquisa geral se não existir filtro
if(!isset($_POST['nome']) || empty($_POST['nome'])){
    $comandoPesquisa = "SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, consagracao.novoCargo, consagracao.id AS 'consagracao_id',consagracao.dataConsagracao FROM consagracao INNER JOIN usuario
    ON usuario.id = consagracao.idMembro ORDER BY consagracao.id DESC ";}
else{
    $comandoPesquisa = "SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, consagracao.novoCargo, consagracao.id AS 'consagracao_id',consagracao.dataConsagracao FROM consagracao INNER JOIN usuario
    ON usuario.id = consagracao.idMembro WHERE usuario.nome LIKE '%".$_POST['nome']."%' ORDER BY consagracao.id DESC ";}




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
$paginacao = str_replace("SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, consagracao.novoCargo, consagracao.id AS 'consagracao_id',consagracao.dataConsagracao ","SELECT COUNT(*) count ",$comandoPesquisa);

//Para pegar o ultimo registro
$totalResultados = $conexao->query($paginacao)->fetch()["count"];
$totalPaginas = ceil($totalResultados / $resultadosPorPagina);
//echo 'As páginas: '.$totalPaginas.', Total de resultados: '.$totalResultados;    


//Concatenando a variavel de pesquisa aos filtros acima
$comandoPesquisa .= " LIMIT $inicio, $resultadosPorPagina";


?>
<!DOCTYPE html>
<html lang="en">
<head>

    <title>Consagrações</title>
    <?php include './header.php';?>

    <style>
        /*Botão listagem na tabela*/
        .btn-custom {
            width: 120px; }

            @media(max-width: 425px){
                .btn-custom{
                    height: 30px;
                    padding: 0px; margin: 0px;}
            }
    </style>

</head>
<body>
<div class="wrapper">
        <?php include './menu.php';?>

        <div class="main">
            <?php include 'topo.php';?>

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

            <div class="row">
                <div class="col-xl-1"></div>
                <div class="col">
                    <?php 
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }?>
                </div>
                <div class="col-xl-1"></div>
            </div>

    
            <div class="row">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="card flex-fill w-100 mt-3 mx-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filtros</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="consagrarMembro.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-4">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome">
                                    </div>
                                    <div class="col-xl-6"></div>
                                    <div class="col-xl-2">
                                        <button type="submit" class="mt-4 btn btn-outline-primary" value="Pesquisar">Pesquisar</button>
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="card flex-fill w-100 mt-1 mx-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Consagrações Recentes</h5>
                        </div>
                        <table class="table table-hover" name="table" id="table">
                            <thead class="table-light">
                                <td class="d-none d-sm-table-cell"></td>
                                <td class=""><strong>Informações</strong></td>
                                <td class=""><strong>Funções</strong></td>
                                <td class="d-none d-sm-table-cell"></td>
                            </thead>
                            <tbody>
                                <?php //Abrindo a conexão e executando o comando sql
                                $sql = $conexao->query($comandoPesquisa);
                                foreach($sql as $dadosBanco){?>
                                <tr>
                                    <td class="d-none d-sm-table-cell">
                                        <img src="../upload/<?php echo $dadosBanco['foto']?>" class="rounded-4" style="height: 140px"></a>
                                    </td>
                                    <td>
                                        <?php echo $dadosBanco['nome'].'<br><strong>Novo cargo:</strong> '.$dadosBanco['novoCargo'].'<br><strong>Data: </strong>'.date('d/m/Y', strtotime ($dadosBanco['dataConsagracao']))?>
                                    </td>
                                    <td>
                                        <!--Modal editar curso-->
                                        <button type="button" class="btn-custom btn btn-primary mt-1" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                                        data-bs-whateverId="<?php echo $dadosBanco['usuario_id']?>" data-bs-whateverId2="<?php echo $dadosBanco['consagracao_id']?>" data-bs-whateverNome="<?php echo $dadosBanco['nome']?>" data-bs-whateverCargo="<?php echo $dadosBanco['novoCargo']?>">Editar</button>
                                        <!--Imprimir certificado-->
                                        <a href= "../pdf/pdf_consagrar.php?consagracao_id=<?php echo $dadosBanco['consagracao_id']?>" class="btn-custom btn btn-outline-primary mt-1">Certificado</a>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row ms-3">
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
                </div>
            </div>

            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
    </div>


<!--Modal de consagração-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"> </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row mb-2">
            <div class="col-xl-6 col">
                <form method="POST" action="excluirConsagracao.php">
                    <button type="submit" class="btn btn-outline-danger">Excluir</button>
                    <input type="hidden" id="modalBodyId2" name="id">
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 col-6"></div>
            <div class="col-xl-6">
                <form method="POST" action="updateConsagrar.php" id="formConsagrar" onsubmit="return verificarCampos('formConsagrar')">
                    <label for="recipient-name" class="col-form-label">Data:</label>
                        <input type="date" class="form-control" name="dataConsagracao" id="dataConsagracao" value="<?php echo date('Y-m-d');?>">
                        <input type="hidden" id="modalBodyId" name="id">
                
            </div>
        </div>
            <div class="col"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Alterar</button>
        </div>
        
</div>
</div>
</div>

<!--Script Menu-->
<script src="../js/app.js"></script>


<!--Script modal consagrar-->
<script type="text/javascript">
const exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipientId = button.getAttribute('data-bs-whateverId2')
        const recipientId2 = button.getAttribute('data-bs-whateverId2')
        const recipientNome = button.getAttribute('data-bs-whateverNome')
        const recipientCargo = button.getAttribute('data-bs-whateverCargo')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const modalTitle = exampleModal.querySelector('.modal-title')
        const modalBodyInput = exampleModal.querySelector('.modal-body input')
        
        const modalBodyId = exampleModal.querySelector('.modal-body #modalBodyId')
        const modalBodyId2 = exampleModal.querySelector('.modal-body #modalBodyId2')

        modalTitle.textContent = `Consagração de: ${recipientNome}`
        modalBodyInput.value = recipientNome
        
        modalBodyId.value = recipientId
        modalBodyId2.value = recipientId2

})

</script>

<!--Função para descer a página navegação-->
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

<!--Verificação de campos nulos-->
<script>
function verificarCampos(formId) {
  const campos = document.querySelectorAll(`#${formId} input[type="text"], #${formId} input[type="date"], #${formId} select`);
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
        alerta.remove();
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