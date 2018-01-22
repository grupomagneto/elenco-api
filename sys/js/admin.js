// Funcoes de validacao
 $(document).ready(function(){
	// Validacao do formulario de Informacoes de Contato
	$("#btnGravarInfoContato").click(function(){
		$("#mensagem_erro").hide();
		
		var erro = "";
		if($("#nome").val() == ""){
			erro += "# O nome deve ser informado<br />";
		}
		
		if($("#cpf").val() == ""){
			erro += "# O CPF deve ser informado<br />";
		}	

		if($("#rg").val() == ""){
			erro += "# O RG deve ser informado<br />";
		}
		
		if(erro != ""){ // Erro de preenchimento no formulario
			$("#mensagem_erro").html(erro);
			$("#mensagem_erro").show("fast");
		}
		else{
			$("#avancar").val("nao");
			$("form").submit();
		}
	});
	
	$("#btnGravarAvancar").click(function(){
		$("#mensagem_erro").hide();
		
		var erro = "";
		if($("#nome").val() == ""){
			erro += "# O nome deve ser informado<br />";
		}
		
		if($("#cpf").val() == ""){
			erro += "# O CPF deve ser informado<br />";
		}	

		if($("#rg").val() == ""){
			erro += "# O RG deve ser informado<br />";
		}
		
		if(erro != ""){ // Erro de preenchimento no formulario
			$("#mensagem_erro").html(erro);
			$("#mensagem_erro").show("fast");
		}
		else{
			$("#avancar").val("sim");
			$("form").submit();
		}
	});	
 
 });

// Funcoes de mascara
function confirmaExclusao(pagina){
	var resposta = confirm("Confirma a remoção deste registro?\nEsta operação não poderá ser desfeita.");
	if(resposta) window.location = pagina;
}

function confirmaCancelamentoDia(pagina){
	var resposta = confirm("Confirma o cancelamento deste dia?\nEsta operação não removerá os agendamentos cadastrados.");
	if(resposta) window.location = pagina;
}

function confirmaReativamentoDia(pagina){
	var resposta = confirm("Confirma o reativamento deste dia?");
	if(resposta) window.location = pagina;
}

function mascara(src, mascara, event) {
	if(event.keyCode != 8){
		var campo = src.value.length;
		var saida = mascara.substring(0,1);
		var texto = mascara.substring(campo);
		
		if(texto.substring(0,1) != saida) {
			src.value += texto.substring(0,1);
		}
	}
}

function linkaContrato(elemento){
	dt_impressao = document.getElementById('dt_assinatura_contrato');
	link_contrato = elemento.href + '&dt_impressao=' + dt_impressao.value;
	window.location = link_contrato;
}
