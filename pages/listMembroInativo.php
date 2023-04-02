<?php
session_start();
if(isset($_SESSION['id'])){

$_SESSION['sessaoMenu'] = 'membros';

//Puxar a classe de conexão
include '../Connection/classeConexao.php';
//Puxar a função de conexão
$conexao = getConnection();

if(isset($_GET['nome'])){
    $nome = $_GET['nome'];
}else{$nome = "";}
if(isset($_GET['sexo'])){
    $sexo = $_GET['sexo'];
}else{$sexo = "sem";}
if(isset($_GET['cargo'])){
    $cargo = $_GET['cargo'];
}else{$cargo = "sem";}

//Por algum motivo, na pag 2 em diante as variáveis tinham um espaço em branco no final
$sexo = str_replace(' ', '', $sexo);
$cargo = str_replace(' ', '', $cargo);
$nome = str_replace(' ', '', $nome);

//Se recebeu parametro 'página' via GET, então vai armazenar, se não tá na primeira pag
$pagina = 1;
if(isset($_GET['pagina'])){
    $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT); //Arredondar pra cima
}
if(!$pagina){//Se não existir página, volta a receber pag 1
    $pagina = 1;
}

//Limite de páginas
$limite = 7;
$inicio = ($pagina * $limite) - $limite;



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include'./header.php';?>
    <title>Membros Inativos</title>
    <style>
        /*Botão listagem na tabela*/
        .btn-custom { width: 120px; }
        .imgPerfil{ width: 10vw; }

            @media(max-width: 425px){
                .btn-custom{
                    height: 30px;
                    padding: 0px; margin: 0px;}
                
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

            <div class="row mt-3">
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

            <main class="p-3">
            <div class="row">
                <div class="col-xl-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Listagem de membros desativados</h5>
                        </div>
                        <form method="GET" action="listMembroInativo.php" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-2"><p class="mb-0">Nome</p></div>
                                <div class="col-xl-4"><input type="text" class="form-control" name="nome" id="nome"></div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2"><p class="mb-0">Cargo</p></div>
                                <div class="col-xl-4 col-8">
                                    <select class="form-select m-0" aria-label="Default select example" name="cargo" id="cargo">
                                        <option value="sem"> </option>
                                        <option value="Bispo">Bispo (a)</option>
                                        <option value="Pastor">Pastor (a)</option>
                                        <option value="Presbítero">Presbítero</option>
                                        <option value="Diácono">Diácono/Diaconisa</option>
                                        <option value="Evangelista">Evangelista</option>
                                        <option value="Missionário">Missionário (a)</option>
                                        <option value="Ministro de Louvor">Ministro (a) de Louvor</option>
                                        <option value="Obreiro">Obreiro (a)</option>
                                        <option value="Membro">Membro</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2"><p class="mb-0">Sexo</p></div>
                                <div class="col-xl-4 col-8">
                                    <select class="form-select m-0" aria-label="Default select example" name="sexo" id="sexo">
                                        <option value="sem"> </option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Feminino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-2">
                                	<button type="submit" class="mt-2 btn btn-outline-primary" value="Pesquisar">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-4 px-4">
                    <div class="row">
                        <div class="card px-0">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Outras funções</h5>
                            </div>
                            <div class="card-body">
                                <div class="row ms-4">
                                    <div class="row mb-2">
                                        <div class="col">
                                            <a href= "../pdf/pdf_geral.php" class="btn btn-outline-primary col-12">Imprimir relatório geral</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <a href= "./listMembro2.php" class="btn btn-outline-success col-12">Listar membros ativos</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Membros Desativados</h5>
                        </div>
                        <div class="card-body">
                        <table class="table table-hover" name="table" id="table">
                            <thead>
                                <tr>
                                    <td></td>
                                    <td><strong>Informações pessoais</strong></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $comando = "SELECT * FROM usuario WHERE situacao = 'inativo'";
                                    //If de pesquisa só com nome
                                if(!empty($nome) && $sexo == "sem" && $cargo == "sem"){
                                    $comando .= " AND nome LIKE '%".$_GET['nome']."%' ";}
                                //IF de pesquisa com nome e sexo
                                else if(!empty($nome) && $sexo != "sem" && $cargo == "sem"){
                                    $comando .= " AND nome LIKE '%".$_GET['nome']."%' AND sexo LIKE '%".$_GET['sexo']."%' ";}
                                //IF de pesquisa com nome , sexo e cargo
                                else if(!empty($nome) && $sexo != "sem" && $cargo != "sem"){
                                    $comando .= " AND nome LIKE '%".$_GET['nome']."%' AND sexo LIKE '%".$_GET['sexo']."%' AND cargo = '".$_GET['cargo']."' ";}
                                //If de pesquisa só com sexo
                                else if(empty($nome) && $sexo != "sem" && $cargo == "sem"){
                                    $comando .= " AND sexo LIKE '%".$_GET['sexo']."%' ";}
                                //If de pesquisa SEXO E CARGo
                                else if(empty($nome) && $sexo != "sem" && $cargo != "sem"){
                                    $comando .= " AND sexo LIKE '%".$_GET['sexo']."%' AND cargo LIKE '%".$_GET['cargo']."%'";}
                                //If de pesquisa só com cargo
                                else if(empty($nome) && $sexo =="sem" && $cargo != "sem"){
                                    $comando .= " AND cargo LIKE '%".$_GET['cargo']."%' ";}
                                //If de pesquisa com cargo e nome
                                else if(!empty($nome) && $sexo == "sem" && $cargo != "sem"){
                                    $comando .= " AND cargo LIKE '%".$_GET['cargo']."%' AND nome LIKE '%".$_GET['nome']."%' ";} 
                                    
                                //Substituindo a variavel de pesquisa para usar na variável de ultima página
                                $paginacao =  str_replace('SELECT * FROM usuario','SELECT COUNT(*) count FROM usuario ', $comando);
                                //Concatenando a variavel de pesquisa aos filtros acima
                                $comando .= "ORDER BY id DESC LIMIT $inicio, $limite";

                                //Para pegar o ultimo registro
                                $registros = $conexao->query($paginacao)->fetch()["count"];
                                $paginas = ceil($registros / $limite); //ceil(arredondamento pra cima)
                                
                                //Abrindo a conexão e executando o comando sql
                                $sql = $conexao->query($comando);
                                
                                //A cada linha que a pesquisa encontrar vai atribuir o valor dela em $row
                                foreach($sql as $dadosBanco){
                                    if(empty($dadosBanco['foto'])){
                                        $fotoUsuario = "../upload/fotoSemfoto.png";
                                    }else{ $fotoUsuario = $dadosBanco['foto'];}
                                    ?>
                                <tr>
                                    <td class="">
                                        <a href="updateMembro.php?id=<?=$dadosBanco['id']?>">
                                        <img src="../upload/<?php echo $fotoUsuario?>" class="rounded-4 imgPerfil"></a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <p><?php echo $dadosBanco['nome']."<br>".$dadosBanco['telefone']."<br><strong>".$dadosBanco['cargo']."</strong>"?></p>
                                    </td>
                                    <td>
                                        <!--Botão para REATIVAR-->
                                        <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                                        data-bs-whateverId="<?php echo $dadosBanco['id'] ?>" data-bs-whateverNome="<?php echo $dadosBanco['nome']?>">Reativar Membro</button>
                                    </td>        
                                </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>



                <div class="row">
                    <nav aria-label="Navegação de página exemplo">
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="?pagina=1">Primeira</a></li>
                                <?php if($pagina > 1):?>
                                    <li class="page-item"><a class="page-link" href="?pagina=<?=$pagina-1?>
                                &nome=<?=$nome?>
                                &cargo=<?=$cargo?>
                                &sexo=<?=$sexo?>"><<</a></li>
                                <?php endif; ?>
                            <li class="page-item"><a class="page-link" href="#"><?=$pagina?></a></li>
                                <?php if($pagina < $paginas):?>
                                    <li class="page-item"><a class="page-link" href="?pagina=<?=$pagina+1?>
                                &nome=<?=$nome?>
                                &cargo=<?=$cargo?>
                                &sexo=<?=$sexo?>">>></a></li>
                                <?php endif; ?>
                            <li class="page-item"><a class="page-link" href="?pagina=<?=$paginas?>">Ultima</a></li>
                        </ul>
                    </nav>
                </div>

            </main>



            

            <footer class="footer">
                    <?php include 'footer.php' ?>
            </footer>
        </div>
    </div>

    <script src="../js/app.js"></script>

<script>
    $(function(){
        $('#valorInserir').maskMoney({
            prefix:'R$ ',
            allowNegative: true,
            thousands:'.', decimal:',',
            affixesStay: true});
    })
</script>



<!--Modal de Reativar Membro-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel"> </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="ativarMembro.php" enctype="multipart/form-data">
                
                <!--Aqui tô enviando o ID do usuario pra outra página-->
                <input type="hidden" class="form-control" id="id" name="id">
                
                <div class="row">
                    <div class="col">
                        <label class="col-form-label">Situação</label>
                        <select class="form-select m-0" aria-label="Default select example" name="situacao" id="situacao">
                            <option value="sem"> </option>
                            <option value="Ativo">Ativar</option>
                        </select>
                    </div>
                    <div class="col">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                    </div>
                </div>
                </div>
                

                <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-outline-primary">Ativar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    //Modal  normal
    const exampleModal = document.getElementById('exampleModal')
        exampleModal.addEventListener('show.bs.modal', event => {
        // Button that triggered the modal
        const button = event.relatedTarget
        // Extract info from data-bs-* attributes
        const recipientId = button.getAttribute('data-bs-whateverId')
        const recipientNome = button.getAttribute('data-bs-whateverNome')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.
        //
        // Update the modal's content.
        const modalTitle = exampleModal.querySelector('.modal-title')
        const modalBodyInput = exampleModal.querySelector('.modal-body input')
        const modalBodyId = exampleModal.querySelector('.modal-body #id')

        modalTitle.textContent = `Deseja reativar ${recipientNome}?`
        modalBodyId.value = recipientId

})

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