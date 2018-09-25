// Encoding: ISO-8859-1
var script = document.createElement('script');
script.src = 'js/bibliotecaAjax.js';
script.type = 'text/javascript';
script.defer = true;
script.id = 'scriptID';
// Insert the created object to the html head element
var head = document.getElementsByTagName('head').item(0);
head.appendChild(script);

var last;
var autorBuscado = "";
var idEvento = "";

window.onload = function() {
	last = "m1";
	evento(document.getElementById("eid").value);
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

function evento(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/info_event.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m1");
}

function edit(eid) {
	var url = "php/form_editevent.php?id="+eid;
	//alert("Aki entrou!\n"+url);
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	requisicaoHTTP( "GET", url, true );
	refreshContents("m2");
}

function inscritos(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/list_subscribed.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m3");
}

function removerrecusados(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/form_remover_resumos_recusados.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m11");
}

function listarrecusados(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/list_resumos_recusados.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m12");
}
function mngsessoes(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/form_sessions.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m4");
}

function admSelecionarSessoes(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/form_admSelecionarSessoes.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m7");
}

function mngsessoesmanual(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/form_sessionsmanual.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m6");
}

function sessoes(eid) {
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/list_sessions.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m5");
}

function alterarApresentador(eid){

	idEvento = eid;

	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/alterarApresentador.php?id="+eid;

	requisicaoHTTP( "GET", url, true );
	refreshContents("m13");
}

function alterarApresentadorBusca(resumoAutor){

	autorBuscado = resumoAutor;

	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/alterarApresentador.php?resumoAutor="+resumoAutor+"&id="+idEvento;

	requisicaoHTTP( "GET", url, true );
	refreshContents("m13");
}

// Atualiza a tela e exibe mensagem de sucesso após a alteração do Apresentador
// no banco
function refreshNovoApresentador(){

	// Como são feitas requisições assíncronas,
	// aguarda até cada requisição terminar para chamar a próxima
	$.when(alterarApresentadorBusca(autorBuscado))
	.then(setTimeout(function() { $('#alerta').show(); }, 500))
	.then(window.setTimeout(function() { $(".alert").fadeTo(100, 0).slideUp(500, function(){$(this).remove();});}, 5000));
	
}

// Popula a modal com os dados do resumo
function setaDadosModal(autor1, autor2, autor3, autor4, autor5, autor6, apr, id) {

	var autores = [];
	var apresentador;
	var idResumo;

	if (autor1)
		autores.push(autor1)
	if (autor2)
		autores.push(autor2)
	if (autor3)
		autores.push(autor3)
	if (autor4)
		autores.push(autor4)
	if (autor5)
		autores.push(autor5)
	if (autor6)
		autores.push(autor6)
	if (apr)
		apresentador = apr;
	if (id)
		idResumo = id;
	
	// Ajusta os textos dos autores e apresentador
	apresentador = apresentador.replace(/\_/g,' ').trim();
	for (var key in autores){
		autores[key] = autores[key].replace(/\_/g,' ').trim();
	}

	for (var key in autores){
		if (autores[key] == apresentador){
			posicaoApresentador = key;
			break;
		} else {
			posicaoApresentador = 0;
		}
	}

	// Cria e injeta uma div com o nome do apresentador atual
	var divApresentador = document.getElementById('div-apresentador');
	divApresentador.innerHTML += "Atual: " + "<b>" + apresentador + "</br>";

	// Caso haja mais de um autor, cria uma div para cada um deles
	if (autores.length > 1){

		// Cria e injeta o botão Confirmar no footer(Ele só existirá caso haja mais de um autor)
		var footer = document.getElementById('footer');		
		var button = document.createElement('button');
		button.type = "button";
		button.innerHTML = "Confirmar";
		button.id = "botaoConfirmar";
		button.className = "btn btn-primary";
		button.setAttribute("data-dismiss","modal");
		button.setAttribute("onClick","submitRadio()");
		footer.insertAdjacentElement('afterbegin', button)

		divApresentador.insertAdjacentHTML('afterend', '<div class="modal-subtitle" id="subtitulo">Selecione o novo apresentador: </div>');

		var checked = true;

		// Criando as Divs que serão inseridas no corpo da modal com os dados do resumo
		for (var key in autores){

				if (key != posicaoApresentador){

					var div = document.createElement('div');
					div.className = 'form-check';
					autorPosicao = parseInt(key)+1;
					
					if (checked){

						div.innerHTML =
						'<label class="form-check-label" id="autor' + autorPosicao + '">\
						<input class="form-check-input" type="radio" name="radio" id="'+ idResumo +'" value="'+ autores[key] +'" checked>\
						'+ autores[key] +' \
						</label>';

						checked = false;

					} else {

						div.innerHTML =
						'<label class="form-check-label" id="autor' + autorPosicao + '">\
						<input class="form-check-input" type="radio" name="radio" id="'+ idResumo +'" value="'+ autores[key] +'">\
						'+ autores[key] +' \
						</label>';

					}

					document.getElementById('modal-body').appendChild(div);
				}
			}

	} else {

		// Caso não haja outros autores, cria apenas uma div para alertar o usuário
		var div = document.createElement('div');
		var texto = "Não existem outros autores nesse resumo.";
		texto = texto.italics();
		div.innerHTML = texto;
		document.getElementById('modal-body').appendChild(div);
	}
}

// Limpa a modal
$(document).on('hidden.bs.modal','#myModal', function () {
	
	// Remov as divs contendo os autores
	var myNode = document.getElementById("modal-body");
	while (myNode.firstChild) {
		myNode.removeChild(myNode.firstChild);
	}

	// Limpa o campo do apresentador
	document.getElementById("div-apresentador").innerHTML = "";

	// Remove o subtitulo caso haja
	var subtitulo = document.getElementById("subtitulo");
	if (subtitulo != null)
		subtitulo.parentNode.removeChild(subtitulo);

	// Remove o botao de confirmar caso haja
	var botao = document.getElementById("botaoConfirmar");
	if (botao != null)
		botao.parentNode.removeChild(botao);
})


// Altera o apresentador do resumo para a pessoa selecionada no radio button
function submitRadio(){

	// Pega o valor do radiobutton caso ele exista (se não tiver outros autores não existirá)
	if (document.querySelector('input[name="radio"]:checked') != null)
		var novoApresentadorAutor = document.querySelector('input[name="radio"]:checked').parentElement.getAttribute('id');
	
	// Pega o valor do id do resumo
	if (document.getElementsByName('radio')[0] != null)
		var idResumo = document.getElementsByName('radio')[0].id;

	if (novoApresentadorAutor != null){

		// Faz requisição para alteração do apresentador no banco
		$.ajax({
			url: 'php/alterarApresentadorBanco.php',
			type: 'get',
			data: { "novoApresentador": novoApresentadorAutor,
					"idResumo": idResumo			
				},
			success: function(response) {
				refreshNovoApresentador();
				},
			error: function(result) { alert("error!");}
		});
	}
}

function gerarCertificados(eid){
	try {
		document.getElementById("contentbar").innerHTML = "";
	} catch (err) {
		alert("Falha em obter container \"contentbar\"!"+
			err.description);
	}
	var url = "php/gerarCertificados.php?id="+eid;
	//alert("Aki entrou!\nID: "+eid+"\n"+url);
	requisicaoHTTP( "GET", url, true );
	refreshContents("m8");
}

function trataDados(){
	var data = ajax.responseText;
	if (data.substr(0,7) == "<alert>") {	
		alert(data.replace("<alert>", ""));
		return;
	} else {
		try {
			document.getElementById("contentbar").innerHTML = data;
		} catch (err) {
			alert("Falha em obter container \"contentbar\"!"+
				err.description);
		}
	}
}

function secshow() {
	try {
		document.getElementById("sshow").style.display = "none";
		document.getElementById("shide").style.display = "inline";
		document.getElementById("resumos_aprovados_area").style.display = "block";
	} catch (err) {
		alert("Erro ao obter elementos.");
	}
}

function sechide() {
	try {
		document.getElementById("sshow").style.display = "inline";
		document.getElementById("shide").style.display = "none";
		document.getElementById("resumos_aprovados_area").style.display = "none";
	} catch (err) {
		alert("Erro ao obter elementos.");
	}
}

function secshow2() {
	try {
		document.getElementById("sshow2").style.display = "none";
		document.getElementById("shide2").style.display = "inline";
		document.getElementById("resumos_recusados_area").style.display = "block";
	} catch (err) {
		alert("Erro ao obter elementos.");
	}
}

function sechide2() {
	try {
		document.getElementById("sshow2").style.display = "inline";
		document.getElementById("shide2").style.display = "none";
		document.getElementById("resumos_recusados_area").style.display = "none";
	} catch (err) {
		alert("Erro ao obter elementos.");
	}
}

function sshide(sid1,sid2,hid) {
	try {
		document.getElementById(sid1).style.display = "inline-block";
		document.getElementById(sid2).style.display = "inline-block";
		document.getElementById(hid).style.display = "none";
	} catch (err) {
		alert("Erro ao obter elementos.");
	}
}

function hhshow(hid1,hid2,sid) {
	try {
		document.getElementById(hid1).style.display = "none";
		document.getElementById(hid2).style.display = "none";
		document.getElementById(sid).style.display = "inline-block";
	} catch (err) {
		alert("Erro ao obter elementos.");
	}
}

function checkFields(sessaoId) {
	var msg = "";
	var k = 0;
	nomecurso = new Array();
	//bt = document.getElementsByName("Enviar");
	for (var t = 1; t<= 9; t++){
		var curso = document.getElementById("cursosExistentes_" + sessaoId).value.split("/");
		//alert(curso);
		var ncurso = (curso.length) - 1;
		
		if(t == sessaoId){
			var j = 0;
			try{			
				for (var i = 0; i < ncurso; i++){
					nomecurso[i] = document.getElementById("nomecurso_" + sessaoId + "_" + curso[i]).value;
					var qntRemStr = document.getElementById("qntRem_" + sessaoId + "_" + curso[i]).value;
					var soma = document.getElementById("soma_" + sessaoId + "_" + curso[i]).value;
					var sessaoDestino = document.getElementById("sessaoDestino_" + sessaoId + "_" + curso[i]).value;
					var sessaoDestinoBic = document.getElementById("sessaoDestinoBic_" + sessaoId + "_" + curso[i]).value;
					var bicJr = document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value;
					var somaBic = document.getElementById("somaBic_" + sessaoId + "_" + curso[i]).value;
					soma = parseInt(soma);
					somaBic = parseInt(somaBic);
					qntRem = parseInt(qntRemStr);
					
					if(isNaN(qntRem) == true && qntRemStr != "" ){
						msg = "* Valor inválido inserido no campo 'Quantidade a ser remanejada' do curso de " + nomecurso[i] + " !\n\n" + msg;
						k = 1;
					}
					
					if((qntRemStr == 0 || qntRem == 0) && (sessaoDestino == 0 && sessaoDestinoBic == 0)){
						// verificando se todos os campos estao vazios
						j+= 1;
					}
					if((qntRemStr == 0 || qntRem == 0) && (sessaoDestino != 0 || sessaoDestinoBic != 0)){
						//  mostra na tela para que o administrador insira um valor no campo quantidade a ser remanejada
						msg = "* Insira um valor no campo 'Quantidade a ser remanejada' do curso de " + nomecurso[i] + " !\n\n" + msg;
						k = 1;
					}
					if((sessaoDestino == 0 && sessaoDestinoBic == 0) && (isNaN(qntRem) == false && qntRem != 0)){
						//  mostra na tela para que o administrador selecione a sessao destino dos resumos a serem remajenados
						msg = "* Selecione a sessão destino dos resumos a serem remanejados do curso de " + nomecurso[i] + " !\n\n" + msg;
						k = 1;
					}
					if(qntRem > soma){	
						if(bicJr == 0){
							//  mostra na tela para o administrador que a quantidade que ele deseja remanejar é maior que a existente na sessao atual
							msg = "* A quantidade de resumos que deseja remanejar é maior do que a existente no curso de " + nomecurso[i] + " !\n\n" + msg;
							k = 1;
						}
					}
					if(qntRem > somaBic){
						if( bicJr == 1){
							//  mostra na tela para o administrador que a quantidade que ele deseja remanejar é maior que a existente de BIC Juniors na sessao atual
							msg = "* A quantidade de resumos BIC Júnior que deseja remanejar é maior do que a existente no curso de " + nomecurso[i] +" !\n\n" + msg;
							k = 1;
						}
					}
					if(sessaoDestino == sessaoId || sessaoDestinoBic == sessaoId){
						//  mostra na tela para que o administrador selecione uma sessao destino diferente da sessao atual
						msg = "* A sessão destino selecionada para os resumos do curso de " + nomecurso[i] + " é a mesma em que eles já se encontram !\n\n" + msg;
						k = 1;
					}
				}
				if(j == ncurso){
					k = 1;
					msg = "* Nenhum campo foi preenchido para que as mudanças possam ser realizadas!\n\n" + msg;
				}
			}
			catch (err) {
			}
			if(k == 1){
				//alert("nome do curso: " + nomecurso[i] + "\nquantidade a remanejar: " + qntRem + "\nsoma: " + soma + "\nsessao destino: " + sessaoDestino);
				alert("ATENÇÃO ADMINISTRADOR!!!\n\nO(s) seguinte(s) erro(s) está(ão) ocorrendo na sessão " + sessaoId + ":\n\n" + msg );
				//bt.disabled = true;
				return false;
			}
			else{
				return true;
			}
		}
	}
}


function SelectSessoes(sessaoId){
	nomecurso = new Array();
	//bt = document.getElementsByName("Enviar");
	for (var t = 1; t<= 9; t++){
		var curso = document.getElementById("cursosExistentes_" + sessaoId).value.split("/");
		//alert(curso);
		var ncurso = (curso.length) - 1;
		
		if(t == sessaoId){		
				for (var i = 0; i < ncurso; i++){
					nomecurso[i] = document.getElementById("nomecurso_" + sessaoId + "_" + curso[i]).value;
					var valor = document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value;
					if(valor == 0){
						document.getElementById("sessaoDestino_" + sessaoId + "_" + curso[i]).style.display = "block";
						document.getElementById("sessaoDestinoBic_" + sessaoId + "_" + curso[i]).style.display = "none";
					}
					if(valor == 1){
						document.getElementById("sessaoDestino_" + sessaoId + "_" + curso[i]).style.display = "none";
						document.getElementById("sessaoDestinoBic_" + sessaoId + "_" + curso[i]).style.display = "block";
					}
				}
		}
	}
}
	

function CheckBic(sessaoId){
	var msg = "";
	var k = 0;
	nomecurso = new Array();
	for (var t = 1; t<= 9; t++){
		var curso = document.getElementById("cursosExistentes_" + sessaoId).value.split("/");
		var ncurso = (curso.length) - 1;
		
		if(t == sessaoId){			
				for (var i = 0; i < ncurso; i++){
					nomecurso[i] = document.getElementById("nomecurso_" + sessaoId + "_" + curso[i]).value;
					var bicJr = document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value;
					var somaBic = document.getElementById("somaBic_" + sessaoId + "_" + curso[i]).value;
					var soma = document.getElementById("soma_" + sessaoId + "_" + curso[i]).value;
					
					if(somaBic == 0 && bicJr == 1){
						// mostra na tela para que o administrador fique atento, pois ele selecionou que os resumos a serem remanejados sao bicjr mas nao ha resumos bicjr
						msg = "* Não há resumos BIC Júnior para o curso " + nomecurso[i] + " na sessão " + sessaoId + "!" + msg;
						document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value = 0;
						k = 1;
					}
					if(soma == somaBic && bicJr == 0){
						msg = "* Há apenas resumos BIC Júnior para o curso " + nomecurso[i] + " na sessão " + sessaoId + "!" + msg;
						document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value = 1;
						k = 1;
					}
					
				}
			if(k == 1){
				//alert("nome do curso: " + nomecurso[i] + "\nquantidade a remanejar: " + qntRem + "\nsoma: " + soma + "\nsessao destino: " + sessaoDestino);
				alert("ATENÇÃO ADMINISTRADOR!!!\n\n" + msg );
				//bt.disabled = true;
			}
		}
	}
}


function setBic(sessaoId){
	var msg = "";
	var k = 0;
	nomecurso = new Array();
	//bt = document.getElementsByName("Enviar");
	for (var t = 1; t<= 9; t++){
		var curso = document.getElementById("cursosExistentes_" + sessaoId).value.split("/");
		//alert(curso);
		var ncurso = (curso.length) - 1;
		
		if(t == sessaoId){
			
				for (var i = 0; i < ncurso; i++){
					var soma = document.getElementById("soma_" + sessaoId + "_" + curso[i]).value;
					var bicJr = document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value;
					var somaBic = document.getElementById("somaBic_" + sessaoId + "_" + curso[i]).value;
					
					if(soma == somaBic){
						// ajusta a opção remanejar bic jr para sim onde soh ha resumos bic jr
						document.getElementById("bic_jr_" + sessaoId + "_" + curso[i]).value = 1;
						document.getElementById("sessaoDestino_" + sessaoId + "_" + curso[i]).style.display = "none";
						document.getElementById("sessaoDestinoBic_" + sessaoId + "_" + curso[i]).style.display = "block";
					}
					
				}			
		}
	}
}

function confirmation() {
	var answer = confirm("Tem certeza que deseja selecionar aleatoriamente as sessões para os resumos?")
	if (answer){
		return true;
	}
	else{
		return false;
	}
}

function confirmation2() {
	var answer = confirm("Tem certeza que deseja gerar a numeração para as sessões de pôsteres?")
	if (answer){
		return true;
	}
	else{
		return false;
	}
}


function confirmation3() {
	var answer = confirm("Tem certeza que deseja transferir os resumos recusados para a tabela \"resumos_recusados\"?")
	if (answer){
		return true;
	}
	else{
		return false;
	}
}

function Check(){
	var campo = document.getElementById("idResumo").value;
	if(campo == "" ){
		alert("Preencha a caixa de texto para que o certificado possa ser gerado!");
		return false;
	}
	if(isNaN(campo) == true){
		alert("ID inválido.");
		return false;
	}
	else return true;	
}

function reseta(){
	document.getElementById("idResumo").value = "";
}