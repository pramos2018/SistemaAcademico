/*
*****************************************************************************************
** Classe Controladora do Front-end do Sistema Simplificado de Gestão de Cursos - Usando Javascript
** Trabalho de Conclusão de Curso - Pós Gradução em Engenharia de Software - PUC Minas
** Professor Orientador: Pasteur Ottoni de Miranda Junior
** Aluno: Paulo Pinto Ramos
** Data: Fev / 2019
*****************************************************************************************
*/

function getWelcomeMsg(myObj) {
	// Mensagem de Boas Vindas com o nome completo do aluno, caso ele seja autenticado com sucesso
	var welcome_msg = '<h4> Usuario Logado com Sucesso! </h4>'
				+ '<h4>Bem Vindo(a) ao Sistema Academico </h4>'
				+ '<h4>'+ myObj.name+ ', agora voce pode: </h4>'
				+ '<br><input class="btn" type ="button" value="Fazer Matricula" onclick=""/>'
				+ '<br><br><input class="btn" type ="button" value="Listar Avaliacoes" onclick=""/>'
				+ '<br><br><input class="btn" type ="button" value="Consultar Notas" onclick=""/>'
				+ '<br><br><input class="btn" type ="button" value="Consultar Boletim" onclick="""/>'
				+ '<br><br><br><a href="index.html"><input class="btn" type ="button" value="Sair" onclick=""/></a>';
	return welcome_msg;
}


function autenticarAluno() {
	// Se conecta a API REST utilizando AJAX
	var email = document.getElementById('txt_user').value;
	var pass = document.getElementById('txt_pwd').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		  var myObj = JSON.parse(this.responseText);
		// Se o codigo da mensagem (msg_code) é 1. Exibe uma mensagem de boas vindas ao aluno
		  if (myObj.msg_code==1) {
			 document.getElementById("div_body").innerHTML = getWelcomeMsg(myObj);
		  } else {
			// Se o dodigo da mensagem (msg_code) é diferente de 1, exibe a mensagem de erro recebida da API de autenticação.
			 document.getElementById("status_message").innerHTML = myObj.message; 
		  }
		  
		}
	};
	//*** Endereço Local ***
	//xhttp.open("POST", "http://localhost/dashboard/Ajax/Projects/puc/API/index.php?cmd=autenticar", true);
	//*** Endereço Remoto ***
	xhttp.open("POST", "http://www.genericplanning.com/site/PUC/API/index.php?cmd=autenticar", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("user_name="+email+"&user_pwd="+pass);
	
}
