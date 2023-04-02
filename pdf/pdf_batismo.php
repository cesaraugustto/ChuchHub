<?php
//Conexão com o banco
include '../Connection/classeConexao.php';
$conexao = getConnection();


//Carregar o composer (emitir pdf)
require '../vendor/autoload.php';

//Query para fazer o select
$sql = "SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, batismo.id, batismo.dataBatismo, batismo.batismoaqui FROM batismo INNER JOIN usuario
ON usuario.id = batismo.idMembro WHERE usuario.id = ".$_GET['usuario_id'];
$resultDados = $conexao->prepare($sql);
$resultDados->execute();


foreach($resultDados as $dadosBanco){
    extract($dadosBanco);
    $dataFormatada= date('d/m/Y', strtotime ($dadosBanco['dataBatismo']));

$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
$dados .= "<link rel='stylesheet' href='http://localhost/comunidadeBetel/pdf/css/custom.css'>";
$dados .= "<title>Batismo de $nome</title>";
$dados .= "</head>";
$dados .= "<body class='bodyBatismo'>";

$dados .=       "<div class='tituloPrincipalBatismo'>";
$dados .=           "<h1>Certificado de Batismo</h1><br>";
$dados .=           "<img class='imgTitulo' src='http://localhost/comunidadeBetel/lgobetel2.png'>";
$dados .=       "</div>"; 

    $dados .= "<div class=''>";
    $dados .=           "<center><img class='imgMembro' src='http://localhost/comunidadeBetel/upload/$foto' ></center>";
    $dados .=           "<center><h2>Aqui certifico que o membro $nome foi batizado <br>";
    $dados .=           "na Comunidade Betel, na data de $dataFormatada.</h2></center>";
    $dados .=           "<center><h4><br>Em nome do Pai, do filho e do Espírito Santo,";
    $dados .=           " estando desta forma, <br>em plena comunhão com o Corpo de Cristo.</h4></center>";
    $dados .=           "<img src='http://localhost/comunidadeBetel/upload/assinatura.png' class='assinaturaBatismo'>";
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