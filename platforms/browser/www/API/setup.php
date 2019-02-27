<?php 

@include_once ('connect_db.php');

if (isset($_GET['load_default_data'])) load_default_data();
if (isset($_GET['set_table'])) set_table();
if (isset($_GET['drop_database'])) drop_database();

//********************************** Setup New User's Data  ******************************************************
function run_query($query, $msg_ok) {
	$status = "";
	if ($query_run = mysql_query($query)) {
		if ($msg_ok!='') $status = "<br>$msg_ok<br>";
	} else {
		$status = "<br>Error Processing Query! !!!<br>".'Error: '.mysql_error().'<br>';
	};	
	echo $status;
}

function set_table() {
	echo '<h4>User database Setup</h4>';
	
	$DBX = DATABASE;
	$sql = "CREATE DATABASE IF NOT EXISTS `$DBX`";
	
	autenticate();
	run_query($sql,'Database Created Successfully!!!');

	$sql = "CREATE TABLE IF NOT EXISTS `alunos` (
			id INT(11) AUTO_INCREMENT PRIMARY KEY,
			cpf VARCHAR(20) NOT NULL,
			nome_aluno VARCHAR(50) NOT NULL,
			endereco VARCHAR(50) NOT NULL,
			estado VARCHAR(2) NOT NULL,
			municipio VARCHAR(20) NOT NULL,
			telefone VARCHAR(20) NOT NULL,
			email VARCHAR(30) NOT NULL,
			senha VARCHAR(8) NOT NULL
			)";
	connect();
	run_query($sql,'Table `alunos` created!!!');

}

function load_default_data() {
	$sql = "INSERT INTO `alunos` (id, cpf, nome_aluno, endereco, estado, municipio, telefone, email, senha) VALUES 
			('1', '111.222.333-01', 'Joao da Silva Oliveira', 'Av. Amazonas, 100 - Centro', 'MG', 'Belo Horizonte', '(31)4444-3322', 'joao@gmail.com', 'j1234'), 
			('2', '111.222.333-02', 'Maria Lucia dos Santos', 'Av. Gutierrez, 120 - Centro', 'MG', 'Belo Horizonte', '(31)5444-3322', 'maria@gmail.com', 'm1234'), 
			('3', '111.222.333-03', 'Paulo Roberto Junior', 'Av. Rio Mantiqueira, 200 - Riacho', 'MG', 'Contagem', '(31)6444-3322', 'paulo@yahoo.com.br', 'p1234'), 
			('4', '111.222.333-04', 'Rita Nascimento Oliveira', 'Rua Rio Gangez, 600 - Riacho', 'MG', 'Contagem', '(31)7444-3322', 'rita@gmail.com', 'r1234')
		";	

	clear_table('alunos');
	connect();
	run_query($sql,'Files list created successfully!!!');
}

function clear_table($table) {
	connect();
	run_query("TRUNCATE `$table`","Table '$table' Reset!");
}
function drop_database() {
	$DB = DATABASE;
	autenticate();
	run_query("DROP DATABASE `$DB`","Database '$DB' droped!");
}


?>

<h4>Advanced Setup </h4>

<form action="setup.php" method="GET">
<input class="btn btn-primary" type="submit"  name="set_table" value="Criar BD e tabela 'Alunos'"/>
<input class="btn btn-primary" type="submit"  name="load_default_data" value="Cadastrar lista de alunos"/>
<input class="btn btn-primary" type="submit"  name="drop_database" value="Apagar Banco de Dados"/>
</form>



