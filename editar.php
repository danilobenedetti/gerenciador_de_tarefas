<?php

//	session_start();

	require "config.php";
	require "banco.php";
	require "ajudante.php";
	require "classes/Tarefa.php";
	require "classes/Anexo.php";
	require "classes/RepositorioTarefas.php";

	$repositorio_tarefas = new RepositorioTarefas($conexao);
	$tarefa = $repositorio_tarefas->buscar($_GET['id']);

	$exibir_tabela = false;
	$tem_erros = false;
	$erros_validacao = [];

	if(tem_post()){
		//$tarefa = [];

		//$tarefa['id'] = $_POST['id'];

		if(isset($_POST['nome']) && strlen($_POST['nome']) > 0) {
			$tarefa->setNome($_POST['nome']);
		} else {
			$tem_erros = true;
			$erros_validacao['nome'] = 
				'O nome da tarefa é obrigatório!';
		}

		if (isset($_POST['descricao'])) {
			$tarefa->setDescricao($_POST['descricao']);
		} else {
			$tarefa['descricao'] = '';
		}

		if (isset($_POST['prazo']) && strlen($_POST['prazo']) > 0) {
			if(validar_data($_POST['prazo'])) {
				$tarefa->setPrazo(traduz_data_br_para_objeto($_POST['prazo']));	
			} else {
				$tem_erros = true;
				$erros_validacao['prazo'] =
					'O prazo não é uma data válida';
			}	
		} else {
			$tarefa->setPrazo('');
		}

		$tarefa->setPrioridade($_POST['prioridade']);

		if (isset($_POST['concluida'])) {
			$tarefa->setConcluida(1);
		} else {
			$tarefa->setConcluida(0);
		}

		if (! $tem_erros) {
			$repositorio_tarefas->atualizar($tarefa);

			if (isset($_POST['lembrete']) && $_POST['lembrete'] == '1'){
				enviar_email($tarefa);
			}
			
			header('Location: tarefas.php');
			die();
		}

	}

	//$tarefa = buscar_tarefa($conexao, $_GET['id']);

	//$tarefa['nome'] = (array_key_exists('nome', $_POST)) ? $_POST['nome'] : $tarefa['nome'];
	//$tarefa['descricao'] = (array_key_exists('descricao', $_POST)) ? $_POST['descricao'] : $tarefa['descricao'];
	//$tarefa['prazo'] = (array_key_exists('prazo', $_POST)) ? $_POST['prazo'] : $tarefa['prazo'];
	//$tarefa['prioridade'] = (array_key_exists('prioridade', $_POST)) ? $_POST['prioridade'] : $tarefa['prioridade'];
	//$tarefa['concluida'] = (array_key_exists('concluida', $_POST)) ? $_POST['concluida'] : $tarefa['concluida'];

	include "template.php";