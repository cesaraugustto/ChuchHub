<?php
session_start();
if(isset($_SESSION['id'])){

$_SESSION['sessaoMenu'] = 'batismo';

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

if (isset($_POST['localBatismo'])) {
    $localBatismo = $_POST['localBatismo'];
} else {
    $localBatismo = null;
}

$comandoPesquisa = "SELECT usuario.id AS 'usuario_id', usuario.nome, batismo.id AS 'batismo_id', batismo.dataBatismo, 
batismo.batismoaqui FROM usuario INNER JOIN batismo ON usuario.id = batismo.idMembro";

if (isset($_POST['nome']) && !empty($_POST['nome'])) {
    $comandoPesquisa .= " WHERE nome LIKE '%" . $_POST['nome'] . "%'";
    if ($localBatismo != "") {
        $comandoPesquisa .= " AND batismoAqui = '" . $localBatismo . "'";
    }
} else if (!empty($localBatismo)) {
    $comandoPesquisa .= " WHERE batismoAqui = '" . $localBatismo . "'";
}




//<!--Paginação aqui-->

//Se recebeu parametro 'página' via GET, então vai armazenar, se não tá na primeira pag
$pagina = 1;
if (isset($_GET['pagina'])) {
    $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT); //Arredondar pra cima
}
if (!$pagina) //Se não existir página, volta a receber pag 1
    $pagina = 1;

$resultadosPorPagina = 7;
$inicio = ($pagina * $resultadosPorPagina) - $resultadosPorPagina;


//pegando o número total de registros de acordo com os filtros
$paginacao = str_replace("SELECT usuario.id AS 'usuario_id', usuario.nome, batismo.id AS 'batismo_id', batismo.dataBatismo, 
batismo.batismoaqui ", "SELECT COUNT(*) count ", $comandoPesquisa);

//Para pegar o ultimo registro
$totalResultados = $conexao->query($paginacao)->fetch()["count"];
$totalPaginas = ceil($totalResultados / $resultadosPorPagina); 


//Concatenando a variavel de pesquisa aos filtros acima
$comandoPesquisa .= " ORDER BY batismo.id DESC LIMIT $inicio, $resultadosPorPagina";





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Batismo</title>
    <?php include './header.php'; ?>
</head>

<body>
    <div class="wrapper">
        <?php include './menu.php'; ?>
        <div class="main">
            <?php include 'topo.php'; ?>

            <!--Aqui começa o body-->
            <div class="row mt-2 mb-3">
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
                    }?>
                </div>
                <div class="col-xl-1"></div>
            </div>

            <div class="row mx-4">
                <div class="card p-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Batizados recentes</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="batizarMembro.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="row">
                                    <div class="col-xl-4 col-12">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome">
                                    </div>
                                    <div class="col-xl-3 col-10">
                                        <label>Local</label>
                                        <select class="form-select m-0" aria-label="Default select example" name="localBatismo" id="sexo">
                                            <option value=""> </option>
                                            <option value="aqui">Betel</option>
                                            <option value="fora">Fora</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3"></div>
                                    <div class="col-xl">
                                        <button type="submit" class="mt-4 btn btn-outline-primary" value="Pesquisar">Pesquisar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--Fim da primeira linha, referente aos filtros de pesquisa-->


            <div class="row mx-4"><!--Inicio da segunda linha, referente a tabela-->
                <div class="card p-0">
                    <div class="card-header">
                            <h5 class="card-title mb-0">Ultimos batizados</h5>
                    </div>
                    <table class="table table-hover" name="table" id="table">
                        <thead class="table-light">
                            <tr>
                                <td class=""><strong>Informações</strong></td>
                                <td class=""><strong>Funções</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           // echo $comandoPesquisa;
                                $sql = $conexao->query($comandoPesquisa);
                                foreach ($sql as $dadosBanco) { ?>
                                    <tr>
                                    <?php 
                                        if($dadosBanco['batismoaqui'] == "Aqui"){
                                            $local = 'Betel';
                                        }    else{ $local = 'Fora';}?>  
                                    <td>
                                        <?php echo $dadosBanco['nome'].'<br><strong>Data: </strong>'.date('d/m/Y', strtotime($dadosBanco['dataBatismo'])).'<br><strong>Local: </strong>'.$local?>
                                    </td>
                                    <td>
                                        <?php if($dadosBanco['batismoaqui'] == "Aqui"){?>
                                            <a href="../pdf/pdf_batismo.php?usuario_id=<?php echo $dadosBanco['usuario_id'] ?>" class="mt-1 btn btn-outline-primary">Certificado</a>
                                        <?php }?>
                                        <a href="./updateBatismo.php?batismo_id=<?php echo $dadosBanco['batismo_id'];?>" class="mt-1 btn btn-outline-primary">Editar</a>
                                    </td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            <?php } ?>  
                        </tbody>
                    </table>
                </div>
            </div>

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
                </div>
            </div>

            <footer class="footer">
                <?php include 'footer.php' ?>
            </footer>
        </div>
    </div>


    <!--Liga o menu-->
    <script src="../js/app.js"></script>

    <!--Função que faz o alert sumir sozinho-->
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 3000);
</script>


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
</body>
</html>


<?php } else{
        $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
        echo "<script>location.href = '../index.php'</script>" ;
}?>