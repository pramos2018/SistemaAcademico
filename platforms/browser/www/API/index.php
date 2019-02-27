<?php
header('Access-Control-Allow-Origin: *');  
/*
*****************************************************************************************
** Back-End (API REST) Sistema Simplificado de Gestão de Cursos - Usando PHP
** Trabalho de Conclusão de Curso - Pós Gradução em Engenharia de Software - PUC Minas
** Professor Orientador: Pasteur Ottoni de Miranda Junior
** Aluno: Paulo Pinto Ramos
** Data: Fev / 2019
** Obs.: API Rest hospedada em Servidor Web (wwww.genericplanning.com/site/PUC/API/)
*****************************************************************************************
*/

@include_once('connect_db.php');// conexão com o banco de dados MySQL

$cmd = "";
if (isset($_GET['cmd'])) $cmd = $_GET['cmd'];


function validarEmail($user) {
	// Verifica no banco de dados se o e-mail é válido
	connect();
	$query = "SELECT * FROM `alunos` WHERE `email`='$user'";
	if ($query_run = mysql_query($query)) {
		if (mysql_num_rows($query_run)>0) {
			return true;
		}
	}
	return false;
}
function validarSenha($user, $pwd) {
	// Verifica via SQL se o e-mail e senha são válidos e retorna o id do aluno, e no nome do aluno
	// além do codigo 0 para falso e 1 para verdadeiro.
	connect();
	$query = "SELECT * FROM `alunos` WHERE `email`='$user' AND `senha`='$pwd'";
	if ($query_run = mysql_query($query)) {
		if (mysql_num_rows($query_run)>0) {
			$ct = mysql_result($query_run,0, 'id');
			$name = mysql_result($query_run,0, 'nome_aluno');
			return array(1, $ct, $name);
		}
	}
	return array(0, 0);
}
if ($cmd == 'autenticar') {
	// Autenticar Alunos:
	// 1 - Checa se o e-mail é válido, senão retorna a mensagem de Erro 'Usuario não localizado'
	// 2 - O Email sendo válida, check se a senha está correta, senão retorna a mensagem de erro 'Senha Invalida'
	// 3 - Se email e senha são válidos retorna a mensagem 'Usuario Logado com sucesso!'
	
	$user = ""; $pwd = ""; $nome_aluno = "teste";
	if (isset($_POST['user_name'])) $user = $_POST['user_name'];
	if (isset($_POST['user_pwd'])) $pwd = $_POST['user_pwd'] ;
	
	$code = 0; $user_id = 0;
	
	if (validarEmail($user)) {
		$vl = validarSenha($user, $pwd);
		if ($vl[0]==1) {
			$msg = "Logado com Sucesso!";
			$code = 1; $user_id = $vl[1]; $nome_aluno = $vl[2];
		} else {
			$msg =  "Senha Invalida";
			$code = 3; $user_id = 0;
		}
	} else {
		$msg = "Usuario nao localizado";
		$code = 2; $user_id = 0;
	}
	
	@$myObj->msg_code = $code;
	@$myObj->message = $msg;
	@$myObj->user_id = $user_id;
	@$myObj->name = $nome_aluno;
	
	//retorna um objeto JSON contendo:  codigo de erro, mensagem, id do aluno, nome do aluno;
	
	$myJSON = json_encode($myObj);
	echo $myJSON;
}


?>