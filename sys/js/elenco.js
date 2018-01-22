// Funcoes de validacao
 $(document).ready(function(){
	
	// Validacao do formulario de contato
	$("#btnContato").click(function(){	
									
		var erro_contato = "";
		
		if($("#nome_remetente").val() == ""){
			erro_contato += "Preencha seu nome\n";
		}
		if($("#email_remetente").val() == "" || !validaEmail($("#email_remetente").val())){
			erro_contato += "Preencha um e-mail válido\n";
		}		
		if($("#telefone").val() == ""){
			erro_contato += "Preencha seu telefone\n";
		}
		if($("#empresa").val() == ""){
			erro_contato += "Preencha o nome da sua empresa\n";
		}
		if($("#assunto").val() == ""){
			erro_contato += "Preencha o assunto da mensagem\n";
		}	
		if($("#mensagem").val() == ""){
			erro_contato += "Preencha a mensagem\n";
		}		
		
		if(erro_contato == ""){
			$("#form_contato").submit();
		}
		else{
			alert(erro_contato);
		}		
	});
	
	// Validacao do formulario de magneto procura
	$("#btnProcura").click(function(){	
									
		var erro_procura = "";
		
		if($("#nome_remetente").val() == ""){
			erro_procura += "Preencha seu nome\n";
		}
		if($("#email_remetente").val() == "" || !validaEmail($("#email_remetente").val())){
			erro_procura += "Preencha um e-mail válido\n";
		}		
		if($("#telefone").val() == ""){
			erro_procura += "Preencha seu telefone\n";
		}
		if($("#empresa").val() == ""){
			erro_procura += "Preencha o nome da sua agência\n";
		}
		if($("#mensagem").val() == ""){
			erro_procura += "Preencha a mensagem\n";
		}		
		
		if(erro_procura == ""){
			$("#form_procura").submit();
		}
		else{
			alert(erro_procura);
		}		
	});
	
	// Validacao do formulario de envio de casting
	$("#btnCasting").click(function(){	
									
		var erro_casting = "";
		
		if($("#nome_remetente").val() == ""){
			erro_casting += "Preencha seu nome\n";
		}
		if($("#email_remetente").val() == "" || !validaEmail($("#email_remetente").val())){
			erro_casting += "Preencha um e-mail válido\n";
		}		
		if($("#nome_destinatario").val() == ""){
			erro_casting += "Preencha o nome do destinatário\n";
		}
		if($("#email_destinatario").val() == "" || !validaEmail($("#email_destinatario").val())){
			erro_casting += "Preencha um e-mail de destinatário válido\n";
		}		
		
		if(erro_casting == ""){
			$("#form_casting").submit();
		}
		else{
			alert(erro_casting);
		}		
	});
	
	// Validacao do formulario de pedido de orcamento
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
		if($("#midia").val() == ""){
			$("#erro_midia").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}
		if($("#periodo").val() == ""){
			$("#erro_periodo").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}
		if($("#empresa").val() == ""){
			$("#erro_empresa").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}
		if($("#praca").val() == ""){
			$("#erro_praca").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}
		if($("#exclusividade").val() == ""){
			$("#erro_exclusividade").html("Favor preencher o campo acima.");
			erro_orcamento = true;
		}		
		
		if(!erro_orcamento){
			$("#form_orcamento").submit();
		}
	
	});
	
	// Validacao do formulario de adicao de elenco no casting
	$("#btnAdicionaCasting").click(function(){			
		
		if($("#nome").val() == "" && $("#cd_casting").val() == ""){
			alert("Informe um nome para o casting.");
		}
		else{
			$("#define_casting").submit();
		}
	
	});	
 
 });

// Funcoes de mascara
function confirmaExclusao(pagina){
	var resposta = confirm("Confirma a remoção deste registro?\nEsta operação não poderá ser desfeita.");
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

function validaEmail(email){
   var re = new RegExp;
   re = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
   var arr = re.exec(email);   

   if (arr == null){
	   return false;
   }
   else{
	   return true;
   }
}

// number formatting function
// copyright Stephen Chapman 24th March 2006, 22nd August 2008
// permission to use this function is granted provided
// that this copyright notice is retained intact

function formatNumber(num,dec,thou,pnt,curr1,curr2,n1,n2) {var x = Math.round(num * Math.pow(10,dec));if (x >= 0) n1=n2='';var y = (''+Math.abs(x)).split('');var z = y.length - dec; if (z<0) z--; for(var i = z; i < 0; i++) y.unshift('0'); if (z<0) z = 1; y.splice(z, 0, pnt); if(y[0] == pnt) y.unshift('0'); while (z > 3) {z-=3; y.splice(z,0,thou);}var r = curr1+n1+y.join('')+n2+curr2;return r;}

// Funcao para calculo da idade
function calculaIdade(mm,dd,yy){
	var thedate = new Date()
	var mm2 = thedate.getMonth() + 1;
	var dd2 = thedate.getDate();
	var yy2 = thedate.getFullYear();
	
	var yourage = yy2 - yy;
	if (mm2 < mm){
		yourage = yourage - 1;
	}
	if (mm2 == mm){
		if (dd2 < dd){
			yourage = yourage - 1;
		}
	}
	return yourage;
}

// Testa a idade do usuario
function verificaIdade(){
	data_nascimento = document.getElementById('dt_nascimento');
	if(data_nascimento.value != ""){
		nome_responsavel = document.getElementById('nome_responsavel');
		label_responsavel = document.getElementById('label_responsavel');
		label_rg = document.getElementById('label_rg');
		label_cpf = document.getElementById('label_cpf');
		
		array_data = data_nascimento.value.split("/");
		idade = calculaIdade(array_data[1],array_data[0],array_data[2]);
		if(idade >= 18){
			nome_responsavel.style.display = "none";
			label_responsavel.style.display = "none";
			label_cpf.src = "img/ag_cpf.gif";
			label_rg.src = "img/ag_rg.gif";			
		}
		else{
			nome_responsavel.style.display = "inline";
			label_responsavel.style.display = "inline";
			label_cpf.src = "img/ag_cpf_responsavel.gif";
			label_rg.src = "img/ag_rg_responsavel.gif";
		}
	}
	else{
		nome_responsavel.style.display = "none";
		label_responsavel.style.display = "none";
		label_cpf.src = "img/ag_cpf.gif";
		label_rg.src = "img/ag_rg.gif";		
	}		
}