<?php
//Conexão com o banco de dados
include '../Connection/classeConexao.php';
$conexao = getConnection();

//Carregar o composer 
require '../vendor/autoload.php';

$dataAtual = date("d/m/Y");

//Query para buscar registros
$sql = "SELECT usuario.id AS 'usuario_id', usuario.foto, usuario.nome, usuario.cargo, usuario.dataCadastro,
usuario.cpf, usuario.dataNascimento, usuario.estadoCivil, batismo.id AS 'batismo_id', batismo.dataBatismo 
FROM usuario INNER JOIN batismo ON usuario.id = batismo.idMembro 
WHERE usuario.situacao = 'Ativo' ORDER BY usuario.id DESC";


$dados = "<!DOCTYPE html>";
$dados .= "<html lang='pt-br'>";
$dados .= "<head>";
$dados .= "<meta charset='UTF-8'>";
$dados .= "<link rel='stylesheet' href='http://localhost/comunidadeBetel/pdf/css/custom.css'>";
$dados .= "<title>Listagem de Membros</title>";
$dados .= "</head>";
$dados .= "<body>";

$resultDados = $conexao->prepare($sql);
$resultDados->execute();


foreach($resultDados as $dadosBanco){
    extract($dadosBanco);
    $databatismoFormatada = date('d/m/Y', strtotime ($dataBatismo));
    $datanascimentoFormatada = date('d/m/Y', strtotime ($dataNascimento));
    $datacadFormatada = date('d/m/Y', strtotime ($dataCadastro));
    $cpfFormatado = substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9, 2);


    
    $dados .= "<div class = 'linhaRegistroGeral'>";
    $dados .=           "<div class='nomeCarteirinha'><label>$nome</label></div>";
    $dados .=           "<div class='dataBatismoCarteirinha'><label>$databatismoFormatada</label></div>";
    $dados .=           "<div class='cargoCarteirinha'><label>$cargo</label></div>";
    $dados .=           "<div class='imgCarteirinha'><img class='imgMembroCarteirinha' src='http://localhost/comunidadeBetel/upload/$foto' ></div>";
    $dados .=           "<div class='assinaturaGeral'><img class='imgAssinaturaGeral' src='http://localhost/comunidadeBetel/upload/assinatura.png' ></div>";
    $dados .=           "<div class='emissaoCarteirinha'><label>$dataAtual</label></div>";
    $dados .=           "<div class='dataCadastroCarteirinha'><label>$datacadFormatada</label></div>";
    $dados .=           "<div class='cpfCarteirinha'><label>$cpfFormatado</label></div>";
    $dados .=           "<div class='nascimentoCarteirinha'><label>$datanascimentoFormatada</label></div>";
    $dados .=           "<div class='estadocivilCarteirinha'><label>$estadoCivil</label></div>";
    $dados .= "</div>";
    
}


$dados .= "</body>";
$dados .= "";


// referenciar o nomespace dompdf
use Dompdf\Dompdf;

// Instanciar e usar a classe Dompdf
$dompdf = new Dompdf(['enable_remote'=> true]);

//Instanciar o método loadhtml e enviar o conteudo do PDF
$dompdf->loadhtml($dados);

//Configurar o tamanho e orientação do papel
//Imprimir no formato paisagem (landscape) ou retrato (portrait)
$dompdf->setPaper('A4', 'landscape');

// Renderizar o HTML como PDF
$dompdf->render();

//Gerar o PDF
$dompdf->stream();



?>