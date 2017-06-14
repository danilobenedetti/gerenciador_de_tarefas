<?php

	require "config.php";
	require "banco.php";
	require "ajudante.php";
	require "classes/Tarefa.php";
	require "classes/Anexo.php";
	require "classes/RepositorioTarefas.php";

	$repositorio_tarefas = new RepositorioTarefas($pdo);

	$tem_erros = false;
	$erros_validacao = array();

	if (tem_post()) {
		// upload dos anexos
		$tarefa_id = $_POST['tarefa_id'];

		if(! array_key_exists('anexo', $_FILES)){
			$tem_erros = true;
			$erros_validacao['anexo'] = 
				'Você deve selecionar um arquivo para anexar';
		} else {
			$dados_anexo = $_FILES['anexo'];

			if (tratar_anexo($dados_anexo)) {
				$anexo = new Anexo();

				$anexo->setTarefaId($tarefa_id);
				$anexo->setNome($dados_anexo['name']);
				$anexo->setArquivo($dados_anexo['name']);
			} else {
				$tem_erros = true;
				$erros_validacao['anexo'] =
					'Envie anexos nos formatos zip ou pdf';
			}
		}

		if (! $tem_erros) {
			$repositorio_tarefas->salvar_anexo($anexo);
		}

	}

	$tarefa = $repositorio_tarefas->buscar($_GET['id']);

	include "template_tarefa.php";
	//$tarefa = buscar_tarefa($conexao, $_GET['id']);
	//$anexos = buscar_anexos($conexao, $_GET['id']);