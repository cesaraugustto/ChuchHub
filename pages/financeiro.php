<?php
session_start();
if (isset($_SESSION['id'])) {
    $_SESSION['sessaoMenu'] = 'financeiro';

    //Puxar a classe de conexão
    include '../Connection/classeConexao.php';
    $conexao = getConnection();

    //Verificações para saber o filtro da pesquisa de movimentações
    if (isset($_GET['dataInicio'])) {
        $dataInicio = $_GET['dataInicio'];
    } else {
        $dataInicio = date('Y-m-d', strtotime('-10 days'));}
    if (isset($_GET['dataFim'])) {
        $dataFim = $_GET['dataFim'];
    } else {
        $dataFim = date('Y-m-d');}

    //Pesquisa geral, pra depois concatenar
    $sql = "SELECT * FROM financeiro WHERE dataMovimentacao BETWEEN '" . $dataInicio . "' AND '" . $dataFim . "'";

    //Variáveis para soma do gráfico
    $entrada = 0;
    $saida = 0;


    //Abrindo a conexão e executando o comando SQL
    //Atribuindo somatório de valores
    $buscaBanco = $conexao->query($sql);
    foreach ($buscaBanco as $dadosFinanceiro) {
        if ($dadosFinanceiro['tipo'] == 'Entrada') {
            $entrada += $dadosFinanceiro['valor'];
        } else {
            $saida += $dadosFinanceiro['valor'];
        }
    }

    //<!--Paginação aqui-->
    //Se recebeu parametro 'página' via GET, então vai armazenar, se não tá na primeira pag
    $pagina = 1;
    if (isset($_GET['pagina'])) {
        $pagina = filter_input(INPUT_GET, "pagina", FILTER_VALIDATE_INT); //Arredondar pra cima
    }
    if (!$pagina) //Se não existir página, volta a receber pag 1
        $pagina = 1;
    $resultadosPorPagina = 10;
    $inicio = ($pagina * $resultadosPorPagina) - $resultadosPorPagina;
    //pegando o número total de registros de acordo com os filtros
    $paginacao = str_replace("SELECT * FROM financeiro", "SELECT COUNT(*) count FROM financeiro", $sql);
    //Concatenando a variavel de pesquisa aos filtros acima
    $sql .= " ORDER BY id DESC LIMIT $inicio, $resultadosPorPagina";
    //Para pegar o ultimo registro
    $totalResultados = $conexao->query($paginacao)->fetch()["count"];
    $totalPaginas = ceil($totalResultados / $resultadosPorPagina);
    //echo 'As páginas: '.$totalPaginas.', Total de resultados: '.$totalResultados;                
?>
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <?php include './header.php'; ?>
        <!--Máscara de valor, tive que tirar do header pois entrava em conflito com a máscara de cpf-->
        <script src="https://plentz.github.io/jquery-maskmoney/javascripts/jquery.maskMoney.min.js" type="text/javascript"></script>
        <title>Financeiro</title>
        <style>
            @media(max-width: 2000px) {
                .textarea1 {
                    width: 100%;
                    height: 100px;
                }
            }
        </style>
    </head>
    <body>
        <div class="wrapper">
            <?php include './menu.php'; ?>

            <div class="main">
                <?php include 'topo.php'; ?>
                <!--Aqui começa o body-->
                <div class="row mt-2">
                    <div class="col-12">
                        <figure>
                            <div class="text-center">
                                <blockquote class="blockquote">
                                    <p style="font-size:14px; ">
                                        <?php if (isset($_SESSION['conteudo'])) {
                                            echo $_SESSION['conteudo'];
                                        ?>
                                    </p>
                                </blockquote>
                                <figcaption class="blockquote-footer">
                                    <cite title="Source Title">
                                        <?php echo $_SESSION['livro'] ?>
                                    </cite>
                                <?php echo ' ' . $_SESSION['capitulo'] . ':' . $_SESSION['versiculo'];
                                            unset($_SESSION['conteudo']);
                                            unset($_SESSION['livro']);
                                            unset($_SESSION['capitulo']);
                                            unset($_SESSION['versiculo']);
                                        } ?>
                                </figcaption>
                            </div>
                        </figure>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-xl-1"></div>
                    <div class="col">
                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        ?>
                    </div>
                    <div class="col-xl-1"></div>
                </div>
                <div class="row px-3">
                    <div class="col-xl-6 col-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Deseja incluir algo?</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="financeiro_ok.php" onsubmit="return verificarValor()">
                                    <div class="row">
                                        <div class="row">
                                            <div class="col-xl-4 col-4">
                                                <p class="pt-1">Valor</p>
                                            </div>
                                            <div class="col-xl-4 col">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="valorInserir" id="valorInserir" placeholder="Insira o valor">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-4">
                                                <p class="pt-1">Tipo</p>
                                            </div>
                                            <div class="col-xl-4 col-8">
                                                <select class="form-select m-0" name="tipo" id="tipo">
                                                    <option value="Entrada">Entrada</option>
                                                    <option value="Saída">Saída</option>
                                                </select>
                                            </div>
                                            <div class="col-xl col"></div>
                                            <div class="col-4"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-8 col-12">
                                                <textarea class="textarea1 form-control" id="obs" name="obs" placeholder="Informe as observações..."></textarea>
                                            </div>
                                            <div class="col-xl-1"></div>
                                            <div class="col-xl-3 mt-2">
                                                <button type="submit" class="btn btn-outline-primary" value="Cadastrar" id="botaoEnviar">Cadastrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card pb-3 border-success">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Entradas</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="dollar-sign"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="mt-1 mb-3 text-success">R$ <?php echo number_format($entrada, 2, ',', ' '); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="card pb-3 border-danger">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col mt-0">
                                                <h5 class="card-title">Saídas</h5>
                                            </div>
                                            <div class="col-auto">
                                                <div class="stat text-primary">
                                                    <i class="align-middle" data-feather="alert-circle"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h3 class="mt-1 mb-3 text-danger">R$ <?php echo number_format($saida, 2, ',', ' '); ?></h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Filtros de pesquisa</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="text-secondary">Periodo: <?php echo date('d/m/Y', strtotime($dataInicio)); ?> até <?php echo date('d/m/Y', strtotime($dataFim)); ?></h5>
                                        <?php
                                        if (strtotime($dataFim) < strtotime($dataInicio)) {
                                            echo "<h4>Conflito entre datas!</h4>";
                                            echo "<label class='text-danger'>Pesquise novamente com os filtros corretos.</label>";
                                        } else {
                                            if ($entrada > $saida) { ?>
                                                <h5 class="text-success">Receitas maiores que despeitas</h5>
                                            <?php } else if ($entrada == $saida) { ?>
                                                <h5 class="text-secondary">Despesas iguais as receitas</h5>
                                            <?php } else if ($entrada < $saida) { ?>
                                                <h5 class="text-danger">Despesas maiores que receitas</h5>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-6 col-xxl-6 mt-2">
                        <div class="card flex-fill h-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Movimentações Recentes</h5>
                            </div>
                            <div class="row ps-3">
                                <form method="GET" action="financeiro.php" onsubmit="return verificarData()" name="verificaData" id="verificaData">
                                    <div class="row mt-1">
                                        <div class="col-xl-4 col-7">
                                            <label class="">Inicio</label>
                                            <input type="date" class="form-control" name="dataInicio" id="dataInicio" value="<?php echo $dataInicio; ?>">
                                        </div>
                                        <div class="col-xl-4 col-7">
                                            <label class="">Fim</label>
                                            <input type="date" class="form-control" name="dataFim" id="dataFim" value="<?= $dataFim ?>">
                                        </div>
                                        <div class="col-xl-4 col-7 mt-4 mb-5">
                                            <button type="submit" class="btn btn-outline-primary" value="Pesquisar">Pesquisar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <canvas id="myChart" style="height: 70%; min-height: 220px;"></canvas><!--Gráfico aqui-->
                        </div>
                    </div>
                </div>
                <div class="row m-2">
                    <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                        <div class="card flex-fill" name="table" id="table">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Ultimas movimentações</h5>
                            </div>
                            <table class="table table-hover my-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Valor</th>
                                        <th class="d-none d-xl-table-cell">Data</th>
                                        <th class="d-none d-md-table-cell">Observações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //Abrindo conexão e efetuando a query
                                    $sqlFinanceiro = $conexao->query($sql);
                                    foreach ($sqlFinanceiro as $dadosFinanceiro) {
                                    ?>
                                        <tr>
                                            <td><span class="<?php if ($dadosFinanceiro['tipo'] == "Entrada") {
                                                                    echo 'badge bg-success';
                                                                } else {
                                                                    echo 'badge bg-danger';
                                                                } ?>"><?php echo $dadosFinanceiro['tipo'] ?></span></td>
                                            <td class="d-xl-table-cell">R$ <?php echo str_replace(".", ",", $dadosFinanceiro['valor']) ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo date('d/m/Y', strtotime($dadosFinanceiro['dataMovimentacao'])); ?></td>
                                            <td class="d-none d-xl-table-cell"><?php echo $dadosFinanceiro['observacoes']; ?></td>
                                            <td>
                                                <!--Botão para Alterar-->
                                                <a href="./updateFinanceiro.php?id=<?php echo $dadosFinanceiro['id']; ?>">
                                                <button type="button" class="btn btn-outline-<?php if ($dadosFinanceiro['tipo'] == 'Entrada') {
                                                    echo 'success'; } else { echo 'danger'; } ?> col-xl-8">Editar</button></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <!--Paginação aqui-->
                        <div class="col">
                            <nav aria-label="Navegação de página exemplo">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="?pagina=1&dataInicio=<?= $dataInicio ?>&dataFim=<?= $dataFim ?>" id="scroll-to-table">Primeira</a>
                                    </li>
                                    <?php if ($pagina > 1) : ?>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina - 1 ?>&dataInicio=<?= $dataInicio ?>&dataFim=<?= $dataFim ?>">
                                                <<< /a>
                                        </li>
                                    <?php endif; ?>
                                    <li class="page-item"><a class="page-link" href="#"><?= $pagina ?></a></li>
                                    <?php if ($pagina < $totalPaginas) : ?>
                                        <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina + 1 ?>&dataInicio=<?= $dataInicio ?>&dataFim=<?= $dataFim ?>">>></a></li>
                                    <?php endif; ?>
                                    <li class="page-item"><a class="page-link" href="?pagina=<?= $totalPaginas ?>&dataInicio=<?= $dataInicio ?>&dataFim=<?= $dataFim ?>">Ultima</a></li>
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

        <!--Menu-->
        <script src="../js/app.js"></script>

        <!--Máscara valor-->
        <script type="text/javascript">
            $(function() {
                $('#valorInserir').maskMoney({
                    prefix: 'R$ ',
                    allowNegative: true,
                    thousands: '.',
                    decimal: ',',
                    affixesStay: true
                });
            })
        </script>

        <!--CDN do gráfico chart.js-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.2.1/chart.min.js"></script>
        <script>
            var data = {
                labels: ["Entrada", "Saída"],
                datasets: [{
                    label: "Total",
                    data: [<?php echo $entrada ?>, <?php echo $saida ?>],
                    backgroundColor: ["rgba(0, 125, 0, 0.84)", "rgba(237, 16, 0, 0.79)"],
                    barThickness: 75, // defina um valor numérico menor para barras mais magras
                    borderColor: ["rgba(0, 70, 0, 1)", "rgba(111, 0, 0, 1)"],
                    borderWidth: 1, //Tamanho da borda
                    borderSkipped: "bottom",
                    hoverBackgroundColor: ["rgba(0, 70, 0, 1)", "rgba(153, 0, 0, 1)"],
                    maxBarThickness: 75
                }, ],
            };

            var maxValue = Math.max.apply(null, data.datasets[0].data) * 1.1; //Deixando altura do gráfico sempre um pouco maior
            var options = {
                title: {
                    display: true,
                    text: 'Movimentações entre <?php echo date('d/m/Y', strtotime($dataInicio)); ?> e <?php echo date('d/m/Y', strtotime($dataFim)); ?>'
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontSize: 8,
                            beginAtZero: true,
                            suggestedMax: maxValue,
                        },
                    }, ],
                },
                legend: {
                    display: false,
                },
            };
            var myBarChart = new Chart(document.getElementById("myChart"), {
                type: "bar",
                data: data,
                options: options,
            });
            // Adicionando legenda
            var legendItems = document.getElementById("legendItems");
            data.labels.forEach((label, index) => {
                var listItem = document.createElement("li");
                listItem.innerHTML = `<div class="legend-color" style="background-color: ${data.datasets[0].backgroundColor[index]}"></div>${label}`;
                legendItems.appendChild(listItem);
            });
        </script>


        <!--Function para rolagem da tela até a tabela-->
        <script>
            $(document).ready(function() {
                $(".page-link").click(function(event) {
                    event.preventDefault();
                    var params = $(this).attr('href').split('?')[1];
                    window.location.href = '?' + params + '#table';
                });
            });
            window.onload = function() {
                var hash = window.location.hash;
                if (hash === '#table') {
                    $(window).scrollTop($('#table').offset().top);
                }
            }
        </script>

        <!--Verificação de campos form-->
        <script>
            function verificarValor() {
                const campos = document.querySelectorAll('input[type="text"], input[type="date"], select');
                for (let i = 0; i < campos.length; i++) {
                    const campo = campos[i];
                    const valor = campo.value.trim();

                    if (valor === "") {
                        const alerta = document.createElement("div");
                        alerta.classList.add("alert", "alert-danger");
                        alerta.textContent = `O campo ${campo.name} está vazio!`;

                        const formulario = document.querySelector("form");
                        formulario.insertBefore(alerta, formulario.firstChild);

                        setTimeout(() => {
                            alerta.classList.add("show");
                            alerta.classList.remove("fade");
                            setTimeout(() => {
                                alerta.remove();
                            }, 3000);
                        }, 100);
                        return false; // Cancela o envio do formulário
                    }
                }
                return true; // Permite o envio do formulário
            }
        </script>

        <!--Verificação de campos gráfico-->
        <script>
            function verificarData() {
                const campos = document.querySelectorAll('input[type="date"]');
                for (let i = 0; i < campos.length; i++) {
                    const campo = campos[i];
                    const valor = campo.value.trim();

                    if (valor === "") {
                        const alerta = document.createElement("div");
                        alerta.classList.add("alert", "alert-danger");
                        alerta.textContent = `O campo ${campo.name} está vazio!`;
                        const formulario = document.querySelector("#verificaData");
                        formulario.insertBefore(alerta, formulario.firstChild);
                        setTimeout(() => {
                            alerta.classList.add("show");
                            alerta.classList.remove("fade");
                            setTimeout(() => {
                                alerta.remove();
                            }, 3000);
                        }, 100);
                        return false; // Cancela o envio do formulário
                    }
                }
                return true; // Permite o envio do formulário
            }
        </script>


        <!--Função que faz o alert sumir sozinho-->
        <script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 3000);
        </script>
    </body>
</html>

<?php } else {
    $_SESSION['msgLogin'] = "<div class='alert alert-danger mb-0'>Necessário fazer login</div>";
    echo "<script>location.href = '../index.php'</script>";
} ?>