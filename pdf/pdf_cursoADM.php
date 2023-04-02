<?php


//Conexão com o banco
include '../Connection/classeConexao.php';
$conexao = getConnection();

//Incluir o dompdf (composer)
require '../vendor/autoload.php';

//Query para fazer o select
$sql = "SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, cursoobreiro.dataInicio, cursoobreiro.dataFim, cursoobreiro.nomeProfessor, cursoobreiro.nomeCurso FROM cursoobreiro INNER JOIN usuario
ON usuario.id = cursoobreiro.idAluno WHERE cursoobreiro.id =".$_GET['curso_id'];
$resultDados = $conexao->prepare($sql);
$resultDados->execute();

foreach($resultDados as $dadosBanco){
    extract($dadosBanco);
    $dataInicioFormatada = date('d/m/Y', strtotime ($dadosBanco['dataInicio']));
    $dataFimFormatada = date('d/m/Y', strtotime ($dadosBanco['dataFim']));

$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
$dados .= "<link rel='stylesheet' href='http://localhost/comunidadeBetel/pdf/css/custom.css'>";
$dados .= "<title>Certificado de $nome</title>";
$dados .= "</head>";
$dados .= "<body class='bodyCurso'>";

$dados .=       "<div class='tituloPrincipal'>";
$dados .=           "<h1>Certificado de curso $nomeCurso</h1><br>";
$dados .=           "<img class='imgTitulo' src='http://localhost/comunidadeBetel/lgobetel2.png'>";
$dados .=       "</div>"; 

    $dados .= "<div class=''>";
    $dados .=           "<center><img class='imgMembro' src='http://localhost/comunidadeBetel/upload/$foto' ></center>";
    $dados .=           "<center><h3>Aqui certifico que</h3><br><p>$nome</p><label class='subTitle'> concluiu o curso de $nomeCurso</label></center>";
    $dados .=           "<br><center><p>No periodo de $dataInicioFormatada até $dataFimFormatada";
    $dados .=           "<br>conforme chamamento do Senhor.</h4></center>";
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