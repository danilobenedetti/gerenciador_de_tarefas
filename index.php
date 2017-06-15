<?php

	// Incluir as configurações, ajudantes e classes
	require "config.php";
	require "helpers/banco.php";
	require "helpers/ajudantes.php";
	require "models/Tarefa.php";
	require "models/Anexo.php";
	require "models/RepositorioTarefas.php";

	// Criar um objeto da classe RepositorioTarefas
	$repositorio_tarefas = new RepositorioTarefas($pdo);

	// Verificar qual arquivo (rota) deve ser usado para tratar as requisições
	$rota = "tarefas"; //rota padrão

	if (array_key_exists("rota", $_GET)) {
		$rota = (string) $_GET["rota"];
	}

	// Incluir arquivo que vai tratar a requisição
	if (is_file("controllers/{$rota}.php")) {
		require "controllers/{$rota}.php";
	} else {
		echo "Rota não encontrada";
	}
