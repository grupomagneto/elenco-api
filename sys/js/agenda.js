// Funcoes de validacao
 $(document).ready(function(){
	
	/* Validacao do formulario de pedido de orcamento
	$("#btnOrcamento").click(function(){	
		
		var erro_orcamento = false;
		
		// Zera as mensagens de errro
		$("#erro_nome_remetente").html("&nbsp;");
		$("#erro_email_remetente").html("&nbsp;");
		$("#erro_telefone").html("&nbsp;");
		$("#erro_midia").html("&nbsp;");
		$("#erro_periodo").html("&nbsp;");
		$("#erro_empresa").html("&nbsp;");
		$("#erro_praca").html("&nbsp;");
		$("#erro_exclusividade").html("&nbsp;");
		
		if($("#nome_remetente").val() == ""){
			$("#erro_nome_remetente").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}
		if($("#email_remetente").val() == "" || !validaEmail($("#email_remetente").val())){
			$("#erro_email_remetente").html("Email inválido. Digite novamente.");
			erro_orcamento = true;
		}
		if($("#telefone").val() == ""){
			$("#erro_telefone").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}	
		
		if(!erro_orcamento){
			$("#form_orcamento").submit();
		}
	
	});
	*/
 
 });
 
 function selecionaHorario(horario){
	 var linha_horario = document.getElementById(horario);
	 var campo_horario = document.getElementById("novo_horario");
	 
	 // Verifica se ja existe horario selecionado
	 if(campo_horario.value != ""){
		 var linha_selecionada = document.getElementById(campo_horario.value);
		 linha_selecionada.className = "selecionar";
	 }
	 
	 linha_horario.className = "selecionado";
	 campo_horario.value = horario;
 }