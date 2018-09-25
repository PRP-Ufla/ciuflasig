var script = document.createElement('script');
script.src = 'js/bibliotecaAjax.js';
script.type = 'text/javascript';
script.defer = true;
script.id = 'scriptID';
// Insert the created object to the html head element
var head = document.getElementsByTagName('head').item(0);
head.appendChild(script);

var last;

window.onload = function() {
	last = "m1";
	menu();
}

function menu(){
	var url;
	try {
		url = "php/menu.php?eid="+
			document.getElementById("eid").value+
			"&uid="+document.getElementById("uid").value;
	} catch (err) {
		alert("Nao foi possivel obter EID e UID!");
	}
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
}
function refreshContents(novo) {
	try {
		document.getElementById(last).style.backgroundColor = "";
		document.getElementById(novo).style.backgroundColor = "#ddd";
		last = novo;
	} catch (err) {
		alert(err.description);
	}
}

function resumo() {
	var url;
	try {
		url = "php/list_resumos.php?eid="+
			document.getElementById("eid").value+
			"&uid="+document.getElementById("uid").value;
	} catch (err) {
		alert("Nao foi possivel obter EID e UID!");
	}
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m1");
}

function resumos_recusados() {
	var url;
	try {
		url = "php/list_resumos_recusados_usuario.php?eid="+
			document.getElementById("eid").value+
			"&uid="+document.getElementById("uid").value;
	} catch (err) {
		alert("Nao foi possivel obter EID e UID!");
	}
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m6");
}


function submit() {
	var url = "static/form_submit_resumo.php";
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m2");
}

function details() {
	try {
		document.getElementById("contentbar").innerHTML =
			"<i>N&atilde;o dispon&iacute;vel ainda.</i>";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	refreshContents("m3");
}

function alterarSenha() {
	var url = "static/form_alterar_senha.php?eid="+
			document.getElementById("eid").value+
			"&uid="+document.getElementById("uid").value;
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m5");
}

function openResumo(id) {
	var url = "php/details_resumo.php?id="+id;
	requisicaoHTTP( "GET", url, true );
}

function openResumoRecusado(id) {
	var url = "php/details_resumo_recusado.php?id="+id;
	requisicaoHTTP( "GET", url, true );
}

function editResumo(id) {
	var url = "php/form_edit_resumo.php?id="+id;
	requisicaoHTTP( "GET", url, true );
}

function deleteResumo(id) {
	if (confirm("Tem certeza de que deseja deletar o resumo?")) {
		var url = "php/delete_resumo.php?id="+id;
		requisicaoHTTP( "GET", url, true );
	}
}

function trataDados(){
	var data = ajax.responseText;
	if (data.substr(0,7) == "<alert>") {	
		alert(data.replace("<alert>", ""));
		return;
	} else if (data.substr(0,9) == "<deleted>") {
		resumo();
		return;
	} else {
		try {
			document.getElementById("contentbar").innerHTML = data;
		} catch (err) {
			alert("Falha em obter container \"contentbar\"!"+
				err.description);
		}
		tinyMCE.init({
	    	selector: "textarea#resumo-detail",
        	theme : "modern",
        	language: "pt_BR",
        	toolbar: false,
        	menubar: false
    	});
		/*tinyMCE.init({
	    	selector: "textarea#resumo",
        	theme : "modern",
        	language: "pt_BR",
        	toolbar: "insertfile undo redo | bold italic underline | alignjustify",
        	plugins : "paste",
			paste_auto_cleanup_on_paste: true,
			paste_convert_headers_to_strong: true,
			paste_remove_styles: true,
			paste_text_linebreaktype: true,
			paste_strip_class_attributes: "all",
			paste_retain_style_properties: "all",
			menubar: false
    	});*/
	}
}

function checkChars() {
	try {
		var txt = document.getElementById("resumo").value;
		document.getElementById("nChars").innerHTML = txt.length+
			" Caracteres";
	} catch (err) {
		alert("Impossivel obter elementos para checar caracteres.");
	}
}

function checkFields() {
	var msg = "";
	//var body = tinymce.get("resumo").getBody(), 
	//resumo = tinymce.trim(body.innerText || body.textContent);
	//alert("Came here...");
	try {
		if (document.getElementById("titulo").value == "") {
			msg = msg + "* T�tulo\n";
		}
		if (document.getElementById("pal1").value == "") {
			msg = msg + "* 1� Palavra-Chave\n";
		}
		if (document.getElementById("pal2").value == "") {
			msg = msg + "* 2� Palavra-Chave\n";
		}
		if (document.getElementById("pal3").value == "") {
			msg = msg + "* 3� Palavra-Chave\n";
		}
		if (document.getElementById("area").value == "0") {
			msg = msg + "* �rea do Resumo\n";
		}
		if (document.getElementById("dpto").value == "0") {
			msg = msg + "* Departamento\n";
		}
		if (document.getElementById("resumo").value == "") {
			msg = msg + "* Resumo\n";
		}
		if (! $("input[type='radio'][name='autor_orientador']").is(':checked')){
			msg = msg + "* Selecione um orientador\n";
		}
		if (document.getElementById("infoautor1").value == "") {
			msg = msg + "* Informa��es do 1� Autor\n";
		}
		if (document.getElementById("resumo").value.length < 100 || document.getElementById("resumo").value.length > 2500) {
			msg = msg + "\n Resumo deve conter de 100 a 2500 caracteres. O seu resumo possui " + 
					document.getElementById("resumo").value.length + " caractere(s). \n"
		}
	} catch (err) {
		msg = msg+"Nao foi possivel realizar a validacao dos campos!";
	}
	
	if (msg != "") {
		alert("Os seguintes campos s�o obrigat�rios:\n"+msg);
		return false;
	} else {
		return true;
	}
}


function SelecionaSessao(){
	var url;
	try {
		url = "php/list_selecionar_sessao.php?eid="+
			document.getElementById("eid").value+
			"&uid="+document.getElementById("uid").value;
	} catch (err) {
		alert("Nao foi possivel obter EID e UID!");
	}
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m4");
}

function CheckSelecionaSessao(){
	var msg = "";
	var k = 0;
	var resumo = document.getElementById("resumos").value.split("/");
	var nResumo = (resumo.length) - 1;
	for(i=0; i<nResumo ; i++){
		var sessao = document.getElementById("sessoes_" + resumo[i]).value;
		var status = document.getElementById("status_" + resumo[i]).value;
		try{
			if(sessao == 0 && status == 0){
				msg = "* Selecione uma sess�o para o " + (i+1) + "� resumo.\n" + msg;
				k = 1;
			}
		}
		catch(err){}
	}
	if(k == 1){
		alert( msg );
		return false;
	}
	else{
		alert("Ap�s indica��o da sess�o, a opera��o n�o poder� ser modificada.");
		var decisao = confirm("Confirma indica��o da sess�o?");
		if(decisao) {
			return true;
		} else {	
			return false;
		}
	}
}

/*function EscondeSelecionados(){
	var k = 0;
	var resumo = document.getElementById("resumos").value.split("/");
	var nResumo = (resumo.length) - 1;
	for(i=0; i<nResumo ; i++){
		var sessao = document.getElementById("sec_" + resumo[i]).value;
		try{
			if(sessao != 0){
				k +=1;
				document.getElementById("res" + i).style.display = "none";
				if(k == nResumo){
					document.getElementById("Enviar").style.display = "none";
					document.getElementById("esconde").style.display = "block";
				}
			}
		}
		catch(err){}
	}
}*/

/*
 * Requisi��o POST para alterar a senha do usu�rio.
 * Por: S�rgio A. Rodrigues(8) - 37/07/2013
*/
function alterarSenhaSubmit() {
	
	if($("#senha_atual").val() != "" && $("#nova_senha").val() != "" && $("#nova_senha").val() == $("#confirmar_nova_senha").val()) {
		$.post('php/alterar_senha.php', { eid: $("#evento").val(), uid: $("#usuario").val(),
			senha_atual: $("#senha_atual").val(), nova_senha: $("#nova_senha").val() },
		       function(data) {
			$("#alterar_senha_msg").html(data);	
		});	
	} else if($("#	senha_atual").val() != "") {
		alert("O campo nova senha n�o foi preenchido.");
	} else if($("#nova_senha").val() != "") {
		alert("O campo senha atual n�o foi preenchido.");
	} else if($("#nova_senha").val() != $("#confirmar_nova_senha").val()) {
		alert("Os campos Nova Senha e Confirmar Nova Senha est�o com entradas diferentes.");
	} else {
		alert("Os campos senha atual e nova senha n�o foram preenchidos.");
	}
	
}


