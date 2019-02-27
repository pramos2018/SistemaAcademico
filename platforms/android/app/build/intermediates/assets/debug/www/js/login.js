function getWelcomeMsg(myObj) {
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
	var email = document.getElementById('txt_user').value;
	var pass = document.getElementById('txt_pwd').value;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
		  var myObj = JSON.parse(this.responseText);
		  if (myObj.msg_code==1) {
			 document.getElementById("div_body").innerHTML = getWelcomeMsg(myObj);
		  } else {
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
