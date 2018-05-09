<?php

	function getConn() {

		return new PDO('mysql:host=127.0.0.1;dbname=teste', 'root', 'root',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	function GET() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['login'] == "" || $_POST['password'] == "") {
		 	return json_encode( array('msg' => '[ERRO] Preencha os Campo de Entrada!') );
		}

		// INICIALIZA/CONFIGURA CURL
		$link = "http://localhost/FrameworkSlim/slim/autenticar/rest.php/".$_POST['login'] ."&" . $_POST['password'];
		$curl = curl_init($link);
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
		return "";
	}

	function GETCPF($cpf)
	{
		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['cpf'] == "") {
		 	return json_encode( array('msg' => '[ERRO] Preencha os Campo de Entrada!') );
		}

		// INICIALIZA/CONFIGURA CURL
		$link = "http://localhost/FrameworkSlim/slim/autenticar/rest.php/".$_POST['cpf'];
		$curl = curl_init($link);
		// // CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}

	function POST() {

		// DADO DE ENTRADA VAZIO - ERRO
		if($_POST['nome'] == "" || $_POST['usuario'] == "" || $_POST['senha'] == "") {
		 	return json_encode( array('msg' => '[ERRO] Preencha os Campo de Cadastro!') );
		}

		// MONTA ARRAY DE DADOS
		$dados = array('nome' => mb_strtoupper($_POST['nome'], 'UTF-8'), 'usuario' => $_POST['usuario'], 'senha' => $_POST['senha']);

		// INICIALIZA/CONFIGURA CURL
		$curl = curl_init("http://localhost/FrameworkSlim/slim/autenticar/rest.php/");
		// CONFIGURA AS OPÇÕES (parâmetros)
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, 'POST');
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($dados));
		// INVOCA A URL DO WEBSERVICE
		$curl_resposta = curl_exec($curl);
		curl_close($curl);

		return $curl_resposta;
	}
?>
