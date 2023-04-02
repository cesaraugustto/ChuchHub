<?php
session_start();
if(isset($_SESSION['id'])){

$_SESSION['sessaoMenu'] = 'curso';

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();




if(isset($_GET['nome'])){
    $nome = $_GET['nome'];
} else { $nome = ""; }


//Select no banco de dados com duas tabelas
$sql = "SELECT usuario.id AS 'usuario_id', usuario.nome, cursoobreiro.id AS 'curso_id', cursoobreiro.dataInicio, cursoobreiro.dataFim, cursoobreiro.nomeProfessor, cursoobreiro.nomeCurso FROM cursoobreiro INNER JOIN usuario ON usuario.id = cursoobreiro.idAluno";

if(!empty($nome) && $_GET['tipo'] == 'aluno'){
    $sql .= " WHERE usuario.nome LIKE '%".$nome."%'";}
else if(!empty($nome) && $_GET['tipo'] == 'professor'){
    $sql .= " WHERE cursoobreiro.nomeProfessor LIKE '%".$nome."%'";}
$sql .= " ORDER BY cursoobreiro.id DESC";


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
$paginacao = str_replace("SELECT usuario.id AS 'usuario_id', usuario.nome, cursoobreiro.id AS 'curso_id', cursoobreiro.dataInicio, cursoobreiro.dataFim, cursoobreiro.nomeProfessor, cursoobreiro.nomeCurso ","SELECT COUNT(*) count ",$sql);



//Para pegar o ultimo registro
$totalResultados = $conexao->query($paginacao)->fetch()["count"];
$totalPaginas = ceil($totalResultados / $resultadosPorPagina);
//echo 'As páginas: '.$totalPaginas.', Total de resultados: '.$totalResultados;    


//Concatenando a variavel de pesquisa aos filtros acima
$sql .= " LIMIT $inicio, $resultadosPorPagina";


?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cursos</title>
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
    
            <div class="row mx-4"><!--Inicio da linha pesquisa-->
                    <div class="card p-0">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Filtros</h5>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="cursoObreiro.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <label>Nome</label>
                                        <input type="text" class="form-control" name="nome" id="nome">
                                    </div>
                                    <div class="col-xl-1"></div>
                                    <div class="col-xl-3">
                                        <label>Tipo</label><br>
                                            <select class="form-select m-0" aria-label="Default select example" name="tipo" id="tipo">
                                                <option value="aluno">Aluno</option>
                                                <option value="professor">Professor</option>
                                            </select>
                                    </div>
                                    <div class="col-xl-3 mt-2">
                                        <button type="submit" class="mt-3 btn btn-outline-primary" value="Pesquisar">Pesquisar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
            </div><!--Fim da linha pesquisa-->
            <div class="row mx-4"><!--Inicio da tabela-->
                <div class="card p-0">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Cursos efetuados recentemente</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover" name="table" id="table">
                            <thead class="table-light">
                                <td><strong>Informações</strong></td>
                                <td class="d-none d-sm-table-cell"></td>
                                <td><strong>Funções</strong></td>
                                <td class="d-none d-sm-table-cell"></td>
                            </thead>
                            <tbody>
                                <?php
                                    //Pesquisa dos cursos
                                    $sqlCurso = $conexao->query($sql);
                                    foreach($sqlCurso as $dadosBanco){?>
                                    <tr  href="./alterarCurso.php">
                                        <td><?php echo '<strong>Matéria: </strong>'.$dadosBanco['nomeCurso'].'<br><strong>Aluno:</strong> '.$dadosBanco['nome'].'<br><strong>Professor:</strong> '.$dadosBanco['nomeProfessor']?></td>
                                        <td class="d-none d-sm-table-cell"><?php echo '<br><strong>Inicio:</strong> '.date('d/m/Y', strtotime ($dadosBanco['dataInicio'])).'<br> <strong>Fim:</strong> '.date('d/m/Y', strtotime ($dadosBanco['dataFim']))?></td>
                                        <td>
                                            <a href= "../pdf/pdf_cursoADM.php?curso_id=<?php echo $dadosBanco['curso_id']?>" class="btn btn-custom btn-outline-primary mt-1">Certificado</a>
                                            <a href= "./alterarCurso.php?id=<?php echo $dadosBanco['curso_id']?>" class="btn btn-custom btn-outline-primary mt-1">Editar</a>
                                        </td>
                                    </tr>
                                    <?php }?>
                            </tbody>
                        </table>
                    </div>
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
            

            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
    </div>





<script src="../js/app.js"></script>

<!--Função responsável pela rolagem da tela na navegação-->
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