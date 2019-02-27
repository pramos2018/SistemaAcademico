<?php
header('Access-Control-Allow-Origin: *');  

// *********************************************************
// *** API REST para Autenticação de Alunos 
// *** Trabalho de Conclusão de Curso       
// *** Curso: Pós Graduação em Engenharia de Software
// *** PUC Minas - Virtual
// *** Prof. Orientador: Pasteur Junior
// *** Aluno: Paulo Pinto Ramos
// *** Data: Fevereiro / 2019
// *********************************************************

include_once('connect_db.php');
//include('setup.php');

$cmd = "";
if (isset($_GET['cmd'])) $cmd = $_GET['cmd'];


function validarEmail($user)	{
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
	
	$myJSON = json_encode($myObj);
	echo $myJSON;
}


?>