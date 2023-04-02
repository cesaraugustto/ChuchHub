<?php
//Conexão com o banco
include '../Connection/classeConexao.php';
$conexao = getConnection();


//Query para fazer o select
$sql = "SELECT usuario.id AS 'usuario_id', consagracao.id AS 'consagracao_id', usuario.nome, usuario.foto, consagracao.novoCargo, consagracao.dataConsagracao, consagracao.idMembro FROM consagracao INNER JOIN usuario
ON usuario.id = consagracao.idMembro WHERE consagracao.id =".$_GET['consagracao_id'];
$resultDados = $conexao->prepare($sql);
$resultDados->execute();



//Incluir o dompdf (composer)
require '../vendor/autoload.php';



foreach($resultDados as $dadosBanco){
    extract($dadosBanco);
    //$fotoDiretorio = "/upload/".$foto;
    $dataFormatada = date('d/m/Y', strtotime ($dadosBanco['dataConsagracao']));

$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados =  "include './header.php';";
$dados .= "<meta charset='UTF-8'>";
$dados .= "<link rel='stylesheet' href='http://localhost/comunidadeBetel/pdf/css/custom.css'>";
$dados .= "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD' crossorigin='anonymous'>";
$dados .= "<title>Consagracao de $nome</title>";
$dados .= "</head>";
$dados .= "<body class='bodyConsagracao'>";




    $dados .= "<div class=''>";
    $dados .=       "<div class='tituloPrincipal'>";
    $dados .=           "<h1>Certificado de consagração a $novoCargo</h1><br>";
    $dados .=           "<img class='imgTitulo' src='http://localhost/comunidadeBetel/lgobetel2.png'>";
    $dados .=       "</div>";    
    $dados .=           "<center><img class='imgMembro' src='http://localhost/comunidadeBetel/upload/$foto' ></center>";
    $dados .=           "<center><br><h3>Certifico que</h3>";
    $dados .=           "<h2>$nome</h2>";
    $dados .=           "<br><h4>foi consagrado a $novoCargo no dia $dataFormatada";
    $dados .=           "<br>conforme chamamento do Senhor.</h4></center>";
    $dados .=           "<center><img src='http://localhost/comunidadeBetel/upload/assinatura.png' class='assinaturaConsagracao'></center>";
    $dados .= "</div>";



}


$dados .= "<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>";
$dados .= "</body>";

//referenciar o nome dompdf
use Dompdf\Dompdf;


//Instanciar e usar a classe dompdf
$dompdf = new Dompdf(['enable_remote'=> true]);

//Enviar conteúdo do HTML pro PDF
$dompdf->loadHtml($dados);

//Configurar o tamanho e orientação do papel
//Imprimir no formato paisagem (landscape) ou retrato (portrait)
$dompdf->setPaper('A4', 'landscape');

// Renderizar o HTML como PDF
$dompdf->render();

//Gerar o PDF
$dompdf->stream();




?>
