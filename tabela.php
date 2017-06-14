		<table>
			<tr>
				<th>Tarefas</th>
				<th>Descrição</th>
				<th>Prazo</th>
				<th>Prioridade</th>
				<th>Concluído</th>
				<th>Opções</th><!-- A nova coluna Opções -->
			</tr>
			<?php foreach ($tarefas as $tarefa) : ?>
				<tr>
					<td>
						<a href="tarefa.php?id=<?php echo $tarefa->getId(); ?>">
							<?php echo htmlentities($tarefa->getNome()); ?>
						</a>
					</td>
					<td>
						<?php echo htmlentities($tarefa->getDescricao()); ?>
					</td>
					<td>
						<?php echo traduz_data_para_exibir($tarefa->getPrazo()); ?>
					</td>
					<td>
						<?php echo traduz_prioridade($tarefa->getPrioridade()); ?>
					</td>
					<td>
						<?php echo traduz_concluida($tarefa->getConcluida()); ?>
					</td>
					<td>
						<!-- O campo com os links para editar e remover -->
						<a href="editar.php?id=<?php echo $tarefa->getId(); ?>">
							Editar
						</a>
						<a href="remover.php?id=<?php echo $tarefa->getId(); ?>">
							Remover
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
