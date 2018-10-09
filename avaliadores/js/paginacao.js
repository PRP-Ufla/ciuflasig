$(function(){

	/*
	 *
	 * Script para mudança de página conforme o usuário clica no menu.
	 * Por: Sérgio Augusto Rodrigues
	 *
	 */
	
	var carregarMenuInicio = function() {
		$("#principal #cabecalho").load("html/menu_inicio.html");
	};

	carregarMenuInicio();

	var carregarPagina = function(caminho) {
		$("#principal #conteudo").load(caminho);
	};

	var logout = function() {
		$.post("php/logout.php", function() {
			$("#principal #cabecalho").load("html/menu_inicio.html");
			$("#principal #conteudo").load("html/login.html");
		});
	};
 
	carregarPagina("html/login.html");
	
	$("#principal #conteudo").off("click","#page-cadastrar");
	
	$("#principal #conteudo").on("click","#page-cadastrar", function() {
		carregarPagina("html/cadastrar.html");
	});
	
	$("#principal").on("click", "#cabecalho a", function(){
		if(this.id === "page-inicio") {
			carregarPagina("html/login.html");
		} else if(this.id === "page-cadastrar") {
			carregarPagina("html/cadastrar.html");
		} else if(this.id === "page-contato") {
			carregarPagina("html/contato.html");
		} else if(this.id === "page-sobre") {
			carregarPagina("html/sobre.html");
		} else if(this.id === "page-escolher-sessoes") {
			carregarPagina("html/principal.html");
		} else if(this.id === "page-minhas-avaliacoes") {
			carregarPagina("html/listar_avaliacoes.html");
		} else if(this.id === "page-todas-avaliacoes") {
			carregarPagina("html/listar_todas_avaliacoes.html");
		} else if(this.id === "page-alterar-senha") {
			carregarPagina("html/alterar_senha.html");
		} else if(this.id === "page-alterar-senha-admin") {
			carregarPagina("html/alterar_senha_admin.html");
		} else if(this.id === "page-inserir-vaga") {
			carregarPagina("html/inserir_vaga.html");
		} else if(this.id === "page-listar-vagas") {
			carregarPagina("html/listar_vagas.html");
		} else if(this.id === "criar-vagas") {
			carregarPagina("html/criar_vagas.html");	
		} else if(this.id === "page-listar-resumos") {
			carregarPagina("html/listar_resumo.html");
		} else if(this.id === "distribui-resumos") {
			carregarPagina("html/distribuir_resumos.html");
		} else if(this.id === "gerar-certificado") {
			carregarPagina("html/certificado_avaliador.html");
		} else if(this.id === "page-senha") { 
			carregarPagina("html/recuperasenha.html");
		
		} else if(this.id === "page-sair") {
			logout();
		}
	});

});