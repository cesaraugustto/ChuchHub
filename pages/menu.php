<?php
if(isset($_SESSION['id'])){
/* Busca para versiculos aleatórios */
$idAleatorio = rand(1,8);
$versiculos = "SELECT * FROM versiculos WHERE id = ".$idAleatorio;
$sqlVersiculos = $conexao->query($versiculos);
foreach($sqlVersiculos as $dadosVersiculos){}
$_SESSION['livro'] = $dadosVersiculos['livro'];
$_SESSION['capitulo'] = $dadosVersiculos['capitulo'];
$_SESSION['versiculo'] = $dadosVersiculos['versiculo'];
$_SESSION['conteudo'] = $dadosVersiculos['conteudo'];
?>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.php">
            <span class="align-middle"><h5 CLASS="pt-2 text-white">ChurchHub 1.0</h5></span>
        </a>
<?php if($_SESSION['cargo'] == "Administrador"){
?>
        <ul class="sidebar-nav">
            <li class="sidebar-header">Menu</li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'index'){echo 'active';}?>">
                <a class="sidebar-link" href="index.php">
                    <i class="align-middle" data-feather="home"></i> <span class="align-middle">Inicio</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'financeiro'){echo 'active';}?>">
                <a class="sidebar-link" href="financeiro.php">
                    <i class="align-middle" data-feather="bar-chart"></i> <span class="align-middle">Financeiro</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'membros'){echo 'active';}?>">
                <a class="sidebar-link" href="listMembro2.php">
                    <i class="align-middle" data-feather="users"></i> <span class="align-middle">Membros</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'cadMembro'){echo 'active';}?>">
                <a class="sidebar-link" href="cadMembro.php">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Cadastrar Membros</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'batismo'){echo 'active';}?>">
                <a class="sidebar-link" href="batizarMembro.php">
                    <i class="align-middle" data-feather="sunrise"></i> <span class="align-middle">Batismo</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'crianca'){echo 'active';}?>">
                <a class="sidebar-link" href="apresentarCrianca.php">
                    <i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Crianças</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'curso'){echo 'active';}?>">
                <a class="sidebar-link" href="cursoObreiro.php">
                    <i class="align-middle" data-feather="book-open"></i> <span class="align-middle">Cursos</span>
                </a>
            </li>

            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'consagrar'){echo 'active';}?>">
                <a class="sidebar-link" href="consagrarMembro.php">
                    <i class="align-middle" data-feather="award"></i> <span class="align-middle">Consagrações</span>
                </a>
            </li>

            <li class="sidebar-header mt-3"> Configurações </li>
            
            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'galeria'){echo 'active';}?>">
                <a class="sidebar-link" href="galeria.php">
                    <i class="align-middle" data-feather="camera"></i> <span class="align-middle">Galeria</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="ui-buttons.html">
                    <i class="align-middle" data-feather="help-circle"></i> <span class="align-middle">Ajuda</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Sair</span>
                </a>
            </li>            
        </ul>
<?php } else //Se o tipo de usuário logado não for ADM será redirecionado para o painel de membros
{ ?>
            <li class="sidebar-item <?php if($_SESSION['sessaoMenu'] == 'loginMembro'){echo 'active';}?>">
                <a class="sidebar-link" href="loginMembro.php">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Perfil</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" data-bs-toggle="modal" data-bs-target="#modalSair">
                    <i class="align-middle" data-feather="log-out"></i> <span class="align-middle">Sair</span>
                </a>
            </li>


<?php }?>
    </div>
</nav>


<!--Modal de confirmação p sair-->
<div class="modal fade" id="modalSair" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel"> </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <label>Deseja mesmo sair?</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                    <a href= "sair.php" class="btn btn-danger">Sair</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } else {
            $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
            echo "<script>location.href = '../index.php'</script>" ;
}?>