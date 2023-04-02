<?php
$buscaAniversario = "SELECT id,nome,foto, DATE_FORMAT(dataNascimento, '%d/%m') AS aniversario FROM usuario WHERE DATE_FORMAT(dataNascimento, '%m-%d')
>= DATE_FORMAT(NOW(), '%m-%d') ORDER BY DATE_FORMAT(dataNascimento, '%m-%d') LIMIT 4;";
?>
<main class="p-3">
	<div class="row mt-3">
		<div class="col-xl-1"></div>
		<div class="col">
			<?php
			if (isset($_SESSION['msg'])) {
				echo $_SESSION['msg'];
				unset($_SESSION['msg']);
			} ?>
		</div>
		<div class="col-xl-1"></div>
	</div>

	<div class="container-fluid p-0 m-0">
		<div class="row mb-2">
			<h5>Bem vindo, <?php echo $_SESSION['nome'] ?></h5>
		</div>
		<div class="row d-flex mb-4">
			<div class="col-xl-4 col pt-3">
				<div class="card h-100">
					<div class="card-header">
						<h5 class="card-title mb-0">Incluir movimentação</h5>
					</div>
					<div class="card-body">
						<form method="POST" action="financeiro_ok.php" onsubmit="return verificarValor()">
							<div class="row">
								<div class="row">
									<div class="col-xl-4 col-4">
										<p class="pt-1">Valor</p>
									</div>
									<div class="col-xl-8 col">
										<div class="input-group">
											<input type="text" class="form-control" name="valorInserir" id="valorInserir">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-4 col-4">
										<p class="pt-1">Tipo</p>
									</div>
									<div class="col-xl-8 col">
										<select class="form-select m-0" aria-label="Default select example" name="tipo" id="tipo">
											<option value="Entrada">Entrada</option>
											<option value="Saída">Saída</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-11">
									<div class="form-floating pb-3">
										<textarea class="form-control w-100" placeholder="Deixe um comentário sobre a movimentação" id="obs" name="obs" style="height: 80px"></textarea>
									</div>
								</div>
								<div class="col"></div>
							</div>
							<div class="col-xl-2 align-self-end">
								<button type="submit" class="btn btn-outline-primary" value="Cadastrar">Cadastrar</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col align-items-stretch pt-3">
				<div class="card h-100">
					<div class="card-header">
						<h5 class="card-title mb-0">Calendário</h5>
					</div>
					<div class="card-body  pb-0">
						<table class="table table-hover">
							<?php
							$sqlAniversario = $conexao->query($buscaAniversario);
							foreach ($sqlAniversario as $dadosAniversario) {
								if (empty($dadosAniversario['foto'])) {
									$fotoAniversario = "../upload/fotoSemfoto.png";
								} else {
									$fotoAniversario = $dadosAniversario['foto'];
								} ?>
								<tr>
									<td><a href="updateMembro.php?id=<?php echo $dadosAniversario['id'] ?>">
											<img src="../upload/<?php echo $fotoAniversario ?>" class="avatar img-responsive rounded" alt="FotoUsuario" />
										</a></td>
									<td><?php echo $dadosAniversario['nome'] ?></td>
									<td><?php echo $dadosAniversario['aniversario'] ?></td>
								</tr> <?php } ?>
						</table>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-12 col-xl">
				<div class="card pb-3">
					<div class="card-header">
						<h5 class="card-title mb-0">Ultimas movimentações</h5>
					</div>
					<div class="card-body">
						<table class="table table-hover">
							<?php
							//Abrindo a conexão e executando o comando SQL
							$sqlFinanceiro = $conexao->query("SELECT * FROM financeiro ORDER BY id DESC LIMIT 7");
							foreach ($sqlFinanceiro as $dadosFinanceiro) { ?>
								<tr>
									<td>
										<span class="<?php if ($dadosFinanceiro['tipo'] == "Entrada") {
															echo 'badge bg-success';
														} else {
															echo 'badge bg-danger';
														} ?>"><?php echo $dadosFinanceiro['tipo'] ?>
										</span>
									</td>
									<td class="d-xl-table-cell">R$ <?php echo str_replace(".", ",", $dadosFinanceiro['valor']) ?>
									</td>
									<td class="d-none d-xl-table-cell"><?php echo date('d/m/Y', strtotime($dadosFinanceiro['dataMovimentacao'])); ?>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>


			<div class="col-12 col-xl">
				<div class="row">
					<div class="card flex-fill mb-3 px-0 mx-2">
						<div class="card-header">
							<h5 class="card-title mb-0">Ultimas consagrações</h5>
						</div>
						<div class="card-body pb-1">
							<table class="table table-hover">
								<tbody>
									<?php
									//Abrindo a conexão e executando o comando SQL
									$sqlConsagracao = $conexao->query("SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, consagracao.novoCargo, consagracao.id AS 'consagracao_id' FROM consagracao INNER JOIN usuario
									ON usuario.id = consagracao.idMembro ORDER BY consagracao.id DESC LIMIT 2");
									//A cada linha que a pesquisa encontrar vai atribuir o valor dela em $row
									foreach ($sqlConsagracao as $dadosConsagracao) {
										if (empty($dadosConsagracao['foto'])) {
											$fotoConsagracao = "../upload/fotoSemfoto.png";
										} else {
											$fotoConsagracao = $dadosConsagracao['foto'];
										}
									?>
										<tr>
											<td class="d-xl-table-cell"> 
												<a href="updateMembro.php?id=<?= $dadosConsagracao['usuario_id'] ?>">
													<img src="../upload/<?php echo $fotoConsagracao ?>" class="avatar img-responsive rounded" alt="FotoUsuario">
												</a>
											</td>
											<td class="d-xl-table-cell"><?php echo $dadosConsagracao['nome'] ?></td>
											<td class="d-xl-table-cell"><?php echo $dadosConsagracao['novoCargo'] ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="card flex-fill px-0 mx-2">
						<div class="card-header">
							<h5 class="card-title mb-0">Ultimos cursos</h5>
						</div>
						<div class="card-body pb-1">
							<table class="table table-hover">
								<tbody>
									<?php
									//Abrindo a conexão e executando o comando SQL
									$sqlCurso = $conexao->query("SELECT usuario.id AS 'usuario_id', usuario.nome, usuario.foto, 
									cursoobreiro.id AS 'curso_id', cursoobreiro.nomeCurso FROM cursoobreiro INNER JOIN usuario ON 
									usuario.id = cursoobreiro.idAluno ORDER BY cursoobreiro.id DESC LIMIT 2");
									foreach ($sqlCurso as $dadosCurso) {
										if (empty($dadosCurso['foto'])) {
											$fotoCurso = "../upload/fotoSemfoto.png";
										} else {
											$fotoCurso = $dadosCurso['foto'];
										}
									?>
										<tr>
											<td class="d-xl-table-cell"> 
												<a href="updateMembro.php?id=<?= $dadosCurso['usuario_id'] ?>">
													<img src="../upload/<?php echo $fotoCurso ?>" class="avatar img-responsive rounded" alt="FotoUsuario">
												</a>
											</td>
											<td class="d-xl-table-cell"><?php echo $dadosCurso['nome'] ?></td>
											<td class="d-xl-table-cell"><?php echo $dadosCurso['nomeCurso'] ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>