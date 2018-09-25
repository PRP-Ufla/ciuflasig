var ajax;
var dadosUsuario;


// ------------- Cria o objeto e faz a requisição ----------------

function requisicaoHTTP (tipo, url, assinc){
	
	if ( window.XMLHttpRequest ) {		// Mozila, safari...
	
		ajax = new XMLHttpRequest();
	
	}
	else if ( window.ActiveXObject ) {	// Internet Explorer
		
		ajax = new ActiveXObject( "Msxml2.XMLHTTP" );
		
		if (!ajax){
			ajax = new ActiveXObject( "Microsoft.XMLHTTP" );
		}
					
	}
	
	if (ajax) {
		iniciaRequisicao (tipo, url, assinc);
	}
	else {
		alert ("Seu navegador não suporta aplicações AJAX!");
	}
	
}


// ------------- Inicializa objeto criado e envia os dados (se existirem) -------------

function iniciaRequisicao (tipo, url, bool) {
	
	ajax.onreadystatechange = trataResposta;
	ajax.open( tipo, url, bool );
	ajax.setRequestHeader( "Content-Type", "application/x-www-form-urlencoded; charset=UTF-8" );
	
	//ajax.overrideMimeType( "text/XML" );    /* usado somente no Mozilla */
	
	ajax.send( dadosUsuario );	
	
}


// ------------- Inicia requisição com envio de dados -------------

function enviaDados( url , form ){
	
	criaQueryString( form );
	requisicaoHTTP( "POST", url, true );
	
}


// ------------- Cria a string a ser enviada, formato campo1=valor1&campo2=valor2... -------------

function criaQueryString ( form ) {
	
	dadosUsuario = "";
	var frm = form;
	var numElementos = frm.elements.length;
	
	for( var i = 0; i < numElementos; i++ ){
		
		if( frm.elements[i].type == "radio" && ( !frm.elements[i].checked ) )
			continue;
		
		if( i < numElementos - 1 ){
			dadosUsuario += frm.elements[i].name + "=" + encodeURIComponent( frm.elements[i].value ) + "&"; 			
		}
		else {
			dadosUsuario += frm.elements[i].name + "=" + encodeURIComponent( frm.elements[i].value );
		}
		
	}
	
}


// ------------- Trata a resposta do servidor -------------

function trataResposta () {
	//alert("Entrou!");
	var loadBar;
	try {
		loadBar = document.getElementById("loadBar");
	} catch (err) {}
	//alert("Achou o Elemento!");
	if( ajax.readyState == 0 ){
		try {
			loadBar.innerHTML = "Carregando...<br /><div style=\"border: 1px solid #000000; "+
				"width: 100px; height: 10px;\"></div>";
		} catch (err) {}
	} else if( ajax.readyState == 1 ){
		try { loadBar.innerHTML = "Carregando...<br /><div style=\"border: 1px solid #000000; width: 100px; height: 10px;\">"+
		"<div style=\"width: 25px; height: 10px; background: #00ff00; position: relative; left: -37.5px;\">"+
		"</div></div>"; } catch (err) {}
	} else if( ajax.readyState == 2 ){
		try { loadBar.innerHTML = "Carregando...<br /><div style=\"border: 1px solid #000000; width: 100px; height: 10px;\">"+
			"<div style=\"width: 50px; height: 10px; background: #00ff00; position: relative; left: -25px;\">"+
			"</div></div>"; } catch (err) {}
	} else if( ajax.readyState == 3 ){
		try { loadBar.innerHTML = "Carregando...<br /><div style=\"border: 1px solid #000000; width: 100px; height: 10px;\">"+
			"<div style=\"width: 75px; height: 10px; background: #00ff00; position: relative; left: -12.5px;\">"+
			"</div></div>"; } catch (err) {}
	} else if( ajax.readyState == 4 ){
		try { loadBar.innerHTML = "Carregando...<br /><div style=\"border: 1px solid #000000; width: 100px; height: 10px;\">"+
			"<div style=\"width: 100px; height: 10px; background: #00ff00; position: relative; left: 0px;\">"+
			"</div></div>"; } catch (err) {}
		
		if( ajax.status == 200 ){
			//alert("Status OK.");
			trataDados(); // Criar essa função no seu programa
			//alert("Trato dos dados terminado.");
			try { loadBar.innerHTML = ""; } catch (err) {}
		} else if( ajax.status == 404 ){
			alert("Ocorreu uma falha na comunicacao com o servidor."+
				"\nO sistema pode nao funcionar corretamente!\nFavor comunicar a PRP.");
			trataDados();
		} else {
			alert( "Problema na comunicação com o servidor.\nStatus: " + ajax.status );
		}
		
	}
	
}