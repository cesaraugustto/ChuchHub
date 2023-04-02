<?php
//Conexão com o banco
include '../Connection/classeConexao.php';
$conexao = getConnection();


//Carregar o composer (emitir pdf)
require '../vendor/autoload.php';

//Query para fazer o select
$sql = "SELECT * FROM crianca WHERE id = ".$_GET['id'];
$resultDados = $conexao->prepare($sql);
$resultDados->execute();

foreach($resultDados as $dadosBanco){
    extract($dadosBanco);
    $dataFormatada= date('d/m/Y', strtotime ($dadosBanco['dataInclusao']));

$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
$dados .= "<link rel='stylesheet' href='http://localhost/comunidadeBetel/pdf/css/custom.css'>";
$dados .= "<title>Certificado de de $nome</title>";
$dados .= "</head>";
$dados .= "<body class='bodyCrianca'>";

$dados .=       "<div class='tituloPrincipal'>";
$dados .=           "<h1>Certificado de apresentação infantil</h1><br>";
$dados .=           "<img class='imgTitulo' src='http://localhost/comunidadeBetel/lgobetel2.png'>";
$dados .=       "</div>"; 

    $dados .= "<div class=''>";
    $dados .=           "<center><img class='imgMembro' src='http://localhost/comunidadeBetel/upload/$foto' ></center>";
    $dados .=           "<center><h2>Aqui certifico que $nome foi apresentado na Igreja Betel<br>";
    $dados .=           "na data de $dataFormatada.</h2></center>";
    $dados .=           "<center><h4><br>Filho de $nomeMae e $nomePai.</h4></center>";
    $dados .=           "<img src='http://localhost/comunidadeBetel/upload/assinatura.png' class='assinaturaCurso'>";
    $dados .= "</div>";



}

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