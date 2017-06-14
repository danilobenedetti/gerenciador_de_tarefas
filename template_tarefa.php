<html>
	<head>
		<meta charset="utf-8">
		<title>Gerenciados de Tarefas</title>
		<link rel="stylesheet" type="text/css" href="tarefas.css">
	</head>
	<body>
		<div="bloco_principal">
			<h1>Tarefa: <?php echo htmlentities($tarefa->getNome()); ?></h1>
			<p>
				<a href="tarefas.php">
					Voltar para a lista de tarefas
				</a>
			</p>

			<p>
				<strong>Concluída:</strong>
				<?php echo traduz_concluida($tarefa->getConcluida()); ?>
			</p>
			<p>
				<strong>Descrição:</strong>
				<?php echo nl2br(htmlentities($tarefa->getDescricao())); ?>
			</p>
			<p>
				<strong>Prazo:</strong>
				<?php echo traduz_data_para_exibir($tarefa->getPrazo()); ?>
			</p>
			<p>
				<strong>Prioridade:</strong>
				<?php echo traduz_prioridade($tarefa->getPrioridade()); ?>
			</p>

			<h2>Anexos</h2>

			<?php if (count($tarefa->getAnexos()) > 0) : ?>
				<table>
					<tr>
						<th>Arquivo</th>
						<th>Opcoes</th>
					</tr>
					<?php foreach ($tarefa->getAnexos() as $anexo) : ?>
						<tr>
							<td><?php echo $anexo->getNome(); ?></td>
							<td>
								<a href="anexos/<?php echo $anexo->getArquivo(); ?>">
									Download
								</a>
								<a href="remover_anexo.php?id=<?php echo $anexo->getId(); ?>">
									Remover
								</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</table>
			<?php else : ?>
				<p>Nao ha anexos para esta tarefa.</p>
			<?php endif; ?>

			<h2>Novo Anexo</h2>

			<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend>Novo anexo</legend>
					<input type="hidden" name="tarefa_id" value="<?php echo $tarefa->getId(); ?>">
					<label>
						<?php if ($tem_erros && array_key_exists('anexo', $erros_validacao)) : ?>
							<span class="erro">
								<?php echo $erros_validacao['anexo']; ?>
							</span>
						<?php endif; ?>
						<input type="file" name="anexo">
					</label>
					<input type="submit" value="Cadastrar">
				</fieldset>				
			</form>

		</div>
	</body>
</html>