<?php

	//session_start();

	require "config.php";
	require "banco.php";
	require "ajudante.php";
	require "classes/Tarefa.php";
	require "classes/Anexo.php";
	require "classes/RepositorioTarefas.php";

	$repositorio_tarefas = new RepositorioTarefas($pdo);

	$exibir_tabela = true;

	$tem_erros = false;
	$erros_validacao = [];

	$tarefa = new Tarefa();
	$tarefa->setPrioridade(1);

	if (tem_post()) {
		//$tarefa = [];

		//$tarefa['nome'] = $_POST['nome'];
		if (array_key_exists('nome', $_POST) 
			&& strlen($_POST['nome']) > 0) {
			$tarefa->setNome($_POST['nome']);
		} else {
			$tem_erros = true;
			$erros_validacao['nome'] = 
				'O nome da tarefa é obrigatório!';
		}

		if (array_key_exists('descricao', $_POST)) {
			$tarefa->setDescricao($_POST['descricao']);
		} else {
			$tarefa['descricao'] = '';
		}

		if (array_key_exists('prazo', $_POST) 
			&& strlen($_POST['prazo']) > 0) {
			if (validar_data($_POST['prazo'])) {
				$tarefa->setPrazo(traduz_data_br_para_objeto($_POST['prazo']));
			} else {
				$tem_erros = true;
				$erros_validacao['prazo'] =
					'O prazo não é uma data válida!';
			}
		}

		$tarefa->setPrioridade($_POST['prioridade']);

		if (array_key_exists('concluida', $_POST)) {
			$tarefa->setConcluida(1);
		} else {
			$tarefa->setConcluida(0);
		}

		if (!$tem_erros) {
			$repositorio_tarefas->salvar($tarefa);
			
			if (isset($_POST['lembrete']) 
				&& $_POST['lembrete'] == '1') {
				enviar_email($tarefa);
			}
			
			header('Location: tarefas.php');
			die();
		}

	}

	$tarefas = $repositorio_tarefas->buscar();

	require "template.php";