<?php

	require 'Slim/Slim.php';
	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	// CONEXÃO COM O BD
	function getConn() {

		return new PDO('mysql:host=127.0.0.1;dbname=teste', 'root', 'root',
				array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}

	// TESTAR WEBSERVICE
	$app->get('/:usuario&:senha', function($usuario, $senha)
	{
		$conn = getConn();
		$sql = "SELECT * FROM usuario WHERE usuario = '$usuario' and senha = '$senha'";
		$stmt = $conn->prepare($sql);
		$stmt->execute();

		$nome = $stmt->fetch()['nome'];
		if($nome == "")
		{
			echo json_encode( array('msg' => "[ERRO] falha na autenticacao! ", 'nome' => $nome ));
		} else {
			echo json_encode( array('msg' => "[OK] autenticado com Sucesso! ", 'nome' => $nome ));
		}
	});

	// POST - Inserir
	$app->post('/', function() use ($app) {

		$dadoJson = json_decode( $app->request()->getBody() );

		$nome=$dadoJson->nome;
		$usuario=$dadoJson->usuario;
		$senha=$dadoJson->senha;

		$sql = "INSERT INTO usuario (nome, usuario, senha) values('$nome', '$usuario', '$senha')";
		$conn = getConn();
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$id = $conn->lastInsertId();

		echo json_encode( array('msg' => "[OK] Usuario ($id) Cadastro com Sucesso!") );
	});

	// TESTAR WEBSERVICE
	$app->get('/:cpf', function($cpf)
	{
		$tam = 0;
		$sum1 = 0;
		$sum2 = 0;
		for($i = 0; $i < (strlen($cpf)); $i++)
		{
			if(is_numeric($cpf[$i]))
			{
				$n[$tam] = $cpf[$i];
				$tam++;
			}
		}

		if($tam != 11)
		{
			echo json_encode( array('msg' => '[ERRO] O CPF Digitado e invalido! ') );
		} else {

			if($cpf[0] == $cpf[1] && $cpf[1] == $cpf[2] && $cpf[2] == $cpf[3] && $cpf[3] == $cpf[4] && $cpf[4] == $cpf[5] &&
				$cpf[5] == $cpf[6] && $cpf[6] == $cpf[7] && $cpf[7] == $cpf[8] && $cpf[8] == $cpf[9] && $cpf[9] == $cpf[10])
			{
				$verification = "CPF inválido";
			} else {
				$j = 10;
				for($i = 0; $i < 9; $i++)
				{
					$sum1 += $cpf[$i]*$j;
					$j--;
				}

				$rs1 = ($sum1*10)%11;

				if ($rs1 == 10)
				{
					$rs1 = 0;
				}

				$j = 2;
				for($i = 9; $i >= 0; $i--)
				{
					$sum2 += $cpf[$i]*$j;
					$j++;
				}

				$rs2 = ($sum2*10)%11;

				if ($rs2 == 10)
				{
					$rs2 = 0;
				}

				if($rs1 == $cpf[9] && $rs2 == $cpf[10])
				{
					echo json_encode( array('msg' => '[OK] O CPF e valido!') );
				} else {
					echo json_encode( array('msg' => '[ERRO] O CPF Digitado e invalido!') );
				}
			}
		}
	});

	$app->run();
?>
