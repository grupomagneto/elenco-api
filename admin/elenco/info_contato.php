<?php
	// Include dos arquivos de sistema e validacao
	include("../includes/valida_acesso_adm.php");
	include("../../sys/api/DataManipulation.php");
	include("../../sys/api/Basic.php");
	include("../../sys/api/MagnetoElenco.php");

	// Include do arquivo com o topo
	include("../includes/topo_adm.php");

	// Chamada da funcao de conexao com o banco de dados
	$idconn = conectaBD();

	// Verifica se o formulario esta em modo de insercao ou edicao
	$id_elenco = $_GET['id_elenco'];
	if($id_elenco == ""){ // Modo de insercao
		$action_formulario = "/magnetoelenco/sys/insert/ins_elenco_info_contato.php";
	}
	else{ // Modo de edicao
		$elenco_contato = getInfoContato($id_elenco);
		$action_formulario = "/magnetoelenco/sys/update/up_elenco_info_contato.php";
	}
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#c3161c">
  <tr>
    <td style=" font-size:31px; padding:5px 0 5px 10px; color:#FFF;"><?= $elenco_contato['nome']; ?></td>
    <td align="right">
	<?php
	if($elenco_contato['publicado'] == 1){
	?>
	<a href="/magnetoelenco/sys/update/up_elenco_publicacao.php?id_elenco=<?= $id_elenco ?>&publicado=0"><img src="/magnetoelenco/admin/img/bt_despublicar.jpg" border="0" style="margin-right:5px;" /></a>
	<?php
	}
	else{
	?>
	<a href="/magnetoelenco/sys/update/up_elenco_publicacao.php?id_elenco=<?= $id_elenco ?>&publicado=1"><img src="/magnetoelenco//admin/img/bt_publicar.jpg" border="0" style="margin-right:5px;" /></a>
	<?php
	}
	?>
	</td>
  </tr>
</table>


<img src="../img/tit_informacoes_contato.gif" width="405" height="68" class="tit" />



<form name="info_contato" method="post" action="<?= $action_formulario; ?>">

<div style="width:48%; float:left; padding-left:7px;">
<table width="100%" border="0">
  <tr>
    <td colspan="3">Nome art&iacute;stico: <br />
    <input name="nome_artistico" type="text" id="nome_artistico" style="width:100%;" maxlength="60" value="<?= $elenco_contato['nome_artistico']; ?>" /></td>
    </tr>
  <tr>
    <td colspan="3" height="5"></td>
    </tr>
  <tr>
    <td colspan="3">Nome do respons&aacute;vel: (em caso de menor)<br />
    <input name="nome_responsavel" type="text" id="nome_responsavel" style="width:100%;" maxlength="60" value="<?= $elenco_contato['nome_responsavel']; ?>" /></td>
    </tr>
  <tr>
    <td colspan="3" height="5"></td>
    </tr>
  <tr>
    <td width="47%">Data de nascimento:<br />
<input name="dt_nascimento" type="text" id="dt_nascimento" style="width:100%;" maxlength="10" onkeydown="mascara(this,'##/##/####', event);" value="<? if($elenco_contato['dt_nascimento'] != "" && $elenco_contato['dt_nascimento'] != '0000-00-00') echo formataData($elenco_contato['dt_nascimento']); ?>" /></td>
    <td width="2%">&nbsp;</td>
    <td width="51%">Naturalidade:<br /><input name="naturalidade" type="text" id="naturalidade" style="width:100%;" maxlength="50" value="<?= $elenco_contato['naturalidade']; ?>" /></td>
  </tr>
  <tr>
    <td colspan="3" height="5"></td>
  </tr>
  <tr>
    <td colspan="3">Endere&ccedil;o:<br /><input name="endereco" type="text" id="endereco" style="width:100%;" maxlength="50" value="<?= $elenco_contato['endereco']; ?>" /></td>
    </tr>
  <tr>
    <td colspan="3" height="5"></td>
    </tr>
  <tr>
    <td>E-mail:<br /><input name="email" type="text" id="email" style="width:100%;" maxlength="60" value="<?= $elenco_contato['email']; ?>" /></td>
    <td>&nbsp;</td>
    <td>CEP:<br />
<input name="cep" type="text" id="cep" style="width:100%;" maxlength="10" value="<?= $elenco_contato['cep']; ?>" /></td>
  </tr>
  <tr>
    <td colspan="3" height="5"></td>
    </tr>
  <tr>
    <td>Data de assinatura do contrato:<br /><input name="dt_assinatura_contrato" type="text" id="dt_assinatura_contrato" style="width:100%;" maxlength="10" onkeydown="mascara(this,'##/##/####', event);" value="<? if($elenco_contato['dt_validade_contrato'] != "" && $elenco_contato['dt_validade_contrato'] != '0000-00-00') echo formataData($elenco_contato['dt_validade_contrato']); ?>" /></td>
    <td>&nbsp;</td>
    <td><a href="/magnetoelenco/sys/run/gera_pdf_contrato.php?id_elenco=<?= $id_elenco; ?>" onclick="linkaContrato(this); return false;"><img src="../img/bt_imprimir_contrato.gif" border="0"></a></td>
  </tr>
</table>
</div>




<div style="width:48%; float:right; padding-right:10px;">
<table width="100%" border="0">
  <tr>
    <td colspan="5">Nome completo:<br /><input name="nome" type="text" id="nome" style="width:100%;" maxlength="60" value="<?= $elenco_contato['nome']; ?>" /></td>
    </tr>
  <tr>
    <td colspan="5" height="5"></td>
    </tr>
  <tr>
    <td colspan="2">CPF: (se menor, CPF do respons&aacute;vel)<br />
<input name="cpf" type="text" id="cpf" style="width:100%;" maxlength="14" value="<?= $elenco_contato['cpf']; ?>" /></td>
    <td width="2%">&nbsp;</td>
    <td colspan="2">RG: (se menor, RG do respons&aacute;vel)<br /><input name="rg" type="text" id="rg" style="width:100%;" maxlength="20" value="<?= $elenco_contato['rg']; ?>" /></td>
  </tr>
  <tr>
    <td colspan="5" height="5"></td>
  </tr>
  <tr>
    <td width="24%">Sexo:<br /><select name="sexo" id="sexo">
      <option value="M" <?php selecionaCombo($elenco_contato['sexo'], "M"); ?>>masculino</option>
      <option value="F" <?php selecionaCombo($elenco_contato['sexo'], "F"); ?>>feminino</option>
    </select></td>
    <td width="24%">Telefone residencial:<br />
    <input name="ddd_residencial" type="text" id="ddd_residencial" style="width:10%;" maxlength="2" value="<?= getDDD($elenco_contato['tl_residencial']); ?>" />&nbsp;
		<input name="tl_residencial" type="text" id="tl_residencial" style="width:70%;" maxlength="9" onkeydown="mascara(this,'####-####', event);" value="<?= getTelefone($elenco_contato['tl_residencial']); ?>" />
 </td>
    <td>&nbsp;</td>
    <td width="26%">Telefone comercial:<br />
<input name="ddd_comercial" type="text" id="ddd_comercial" style="width:10%;" maxlength="2" value="<?= getDDD($elenco_contato['tl_comercial']); ?>" />&nbsp;
		<input name="tl_comercial" type="text" id="tl_comercial" style="width:70%;" maxlength="9" onkeydown="mascara(this,'####-####', event);" value="<?= getTelefone($elenco_contato['tl_comercial']); ?>" /></td>
    <td width="24%">Telefone celular:<br />
<input name="ddd_celular" type="text" id="ddd_celular" style="width:10%;" maxlength="2" value="<?= getDDD($elenco_contato['tl_celular']); ?>" />&nbsp;
		<input name="tl_celular" type="text" id="tl_celular" style="width:70%;" maxlength="9" onkeydown="mascara(this,'####-####', event);" value="<?= getTelefone($elenco_contato['tl_celular']); ?>" /></td>
  </tr>
  <tr>
    <td colspan="5" height="5"></td>
  </tr>
  <tr>
    <td colspan="2">Bairro:<br />
<input name="bairro" type="text" id="bairro" style="width:100%;" maxlength="50" value="<?= $elenco_contato['bairro']; ?>" /></td>
    <td>&nbsp;</td>
    <td>Cidade:<br />
<?php echo montaCampoSelect("tt_cidade", "cd_cidade", "cidade", "id_cidade", 1, false, "id_cidade", "width:100%;", $elenco_contato['cd_cidade']); ?></td>
    <td>UF:<br />
<select id="uf" name="uf" style="width:100%;">
			<option value="AC" <?php selecionaCombo($elenco_contato['uf'], "AC"); ?>>AC</option>
			<option value="AL" <?php selecionaCombo($elenco_contato['uf'], "AL"); ?>>AL</option>
			<option value="AM" <?php selecionaCombo($elenco_contato['uf'], "AM"); ?>>AM</option>
			<option value="AP" <?php selecionaCombo($elenco_contato['uf'], "AP"); ?>>AP</option>
			<option value="BA" <?php selecionaCombo($elenco_contato['uf'], "BA"); ?>>BA</option>
			<option value="CE" <?php selecionaCombo($elenco_contato['uf'], "CE"); ?>>CE</option>
			<option value="DF" <?php selecionaCombo($elenco_contato['uf'], "DF"); ?>>DF</option>
			<option value="ES" <?php selecionaCombo($elenco_contato['uf'], "ES"); ?>>ES</option>
			<option value="GO" <?php selecionaCombo($elenco_contato['uf'], "GO"); ?>>GO</option>
			<option value="MA" <?php selecionaCombo($elenco_contato['uf'], "MA"); ?>>MA</option>
			<option value="MG" <?php selecionaCombo($elenco_contato['uf'], "MG"); ?>>MG</option>
			<option value="MS" <?php selecionaCombo($elenco_contato['uf'], "MS"); ?>>MS</option>
			<option value="MT" <?php selecionaCombo($elenco_contato['uf'], "MT"); ?>>MT</option>
			<option value="PA" <?php selecionaCombo($elenco_contato['uf'], "PA"); ?>>PA</option>
			<option value="PB" <?php selecionaCombo($elenco_contato['uf'], "PB"); ?>>PB</option>
			<option value="PE" <?php selecionaCombo($elenco_contato['uf'], "PE"); ?>>PE</option>
			<option value="PI" <?php selecionaCombo($elenco_contato['uf'], "PI"); ?>>PI</option>
			<option value="PR" <?php selecionaCombo($elenco_contato['uf'], "PR"); ?>>PR</option>
			<option value="RJ" <?php selecionaCombo($elenco_contato['uf'], "RJ"); ?>>RJ</option>
			<option value="RN" <?php selecionaCombo($elenco_contato['uf'], "RN"); ?>>RN</option>
			<option value="RR" <?php selecionaCombo($elenco_contato['uf'], "RR"); ?>>RR</option>
			<option value="RO" <?php selecionaCombo($elenco_contato['uf'], "RO"); ?>>RO</option>
			<option value="RS" <?php selecionaCombo($elenco_contato['uf'], "RS"); ?>>RS</option>
			<option value="SC" <?php selecionaCombo($elenco_contato['uf'], "SC"); ?>>SC</option>
			<option value="SE" <?php selecionaCombo($elenco_contato['uf'], "SE"); ?>>SE</option>
			<option value="SP" <?php selecionaCombo($elenco_contato['uf'], "SP"); ?>>SP</option>
			<option value="TO" <?php selecionaCombo($elenco_contato['uf'], "TO"); ?>>TO</option>
		</select>	</td>
  </tr>
  <tr>
    <td colspan="5" height="5"></td>
    </tr>
  <tr>
    <td colspan="5">
    <table border="0" width="100%" cellpadding="4" bgcolor="#990000">
		  <tr>
		    <td width="30%" class="fbr">ELENCO VIAJANDO?</td>
			<td width="5%"><input name="viajando" id="viajando" type="radio" value="1" <?php selecionaRadio($elenco_contato['viajando'], 1); ?> /></td>
			<td width="9%" class="fbr">sim</td>
			<td width="5%"><input name="viajando" id="viajando" type="radio" value="0" <?php selecionaRadio($elenco_contato['viajando'], 0); ?> /></td>
			<td width="10%" class="fbr">n&atilde;o</td>
			<td width="6%" class="fbr">de:</td>
			<td width="14%"><input name="dt_viagem_inicio" id="dt_viagem_inicio" type="text" style="width:60px;" maxlength="10" onkeydown="mascara(this,'##/##/####', event);" value="<? if($elenco_contato['dt_viagem_inicio'] != "" && $elenco_contato['dt_viagem_inicio'] != '0000-00-00') echo formataData($elenco_contato['dt_viagem_inicio']); ?>" /></td>
			<td width="6%" class="fbr">até:</td>
			<td width="15%"><input name="dt_viagem_fim" id="dt_viagem_fim" type="text" style="width:60px;" maxlength="10" onkeydown="mascara(this,'##/##/####', event);" value="<? if($elenco_contato['dt_viagem_fim'] != "" && $elenco_contato['dt_viagem_fim'] != '0000-00-00') echo formataData($elenco_contato['dt_viagem_fim']); ?>" /></td>
		  </tr>
		</table>

    </td>
    </tr>
</table>
</div>

<div style="clear:both"></div>
<p>&nbsp;</p>

<table width="98%" border="0" cellpadding="4" cellspacing="0" class="tit">
  <tr>
    <td width="45%"><img src="../img/tit_questionario.gif" width="236" height="68" /></td>
    <td width="55%">&nbsp;</td>
  </tr>
  <tr>
    <td class="tdc">Deseja ser agenciado exclusivamente pela Magneto Elenco?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="exclusivo" type="radio" value="1" <?php selecionaRadio($elenco_contato['exclusivo'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="exclusivo" type="radio" value="0" <?php selecionaRadio($elenco_contato['exclusivo'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>J&aacute; faz parte do casting de outra ag&ecirc;ncia?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="outra_agencia" type="radio" value="1" <?php selecionaRadio($elenco_contato['outra_agencia'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="outra_agencia" type="radio" value="0" <?php selecionaRadio($elenco_contato['outra_agencia'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>qual:</td>
        <td><input name="outra_agencia_nome" type="text" id="outra_agencia_nome" maxlength="40" value="<?= $elenco_contato['outra_agencia_nome']; ?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Você é ator/atriz?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="ator" type="radio" value="1" <?php selecionaRadio($elenco_contato['ator'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="ator" type="radio" value="0" <?php selecionaRadio($elenco_contato['ator'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Fashion</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="fashion" type="radio" value="1" <?php selecionaRadio($elenco_contato['fashion'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="fashion" type="radio" value="0" <?php selecionaRadio($elenco_contato['fashion'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Possui DRT?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="drt" type="radio" value="1" <?php selecionaRadio($elenco_contato['drt'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="drt" type="radio" value="0" <?php selecionaRadio($elenco_contato['drt'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>tipo:</td>
        <td><input name="drt_tipo" type="text" id="drt_tipo" maxlength="40" value="<?= $elenco_contato['drt_tipo']; ?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Deseja trabalhar com recep&ccedil;&atilde;o de eventos?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="eventos" type="radio" value="1" <?php selecionaRadio($elenco_contato['eventos'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="eventos" type="radio" value="0" <?php selecionaRadio($elenco_contato['eventos'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Deseja ser chamado para trabahos de figura&ccedil;&atilde;o?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="figuracao" type="radio" value="1" <?php selecionaRadio($elenco_contato['figuracao'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="figuracao" type="radio" value="0" <?php selecionaRadio($elenco_contato['figuracao'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Deseja fazer parte do Casting m&atilde;os e p&eacute;s: </td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="casting_maospes" type="radio" value="1" <?php selecionaRadio($elenco_contato['casting_maospes'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="casting_maospes" type="radio" value="0" <?php selecionaRadio($elenco_contato['casting_maospes'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Deseja fazer parte do Casting de corpo?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="casting_corpo" type="radio" value="1" <?php selecionaRadio($elenco_contato['casting_corpo'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="casting_corpo" type="radio" value="0" <?php selecionaRadio($elenco_contato['casting_corpo'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Est&aacute; apto a fazer trabalhos de nu?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="nu" type="radio" value="1" <?php selecionaRadio($elenco_contato['nu'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="nu" type="radio" value="0" <?php selecionaRadio($elenco_contato['nu'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Aceita cortar/pintar, se necess&aacute;rio, o seu cabelo para uma produ&ccedil;&atilde;o?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="producao_cabelo" type="radio" value="1" <?php selecionaRadio($elenco_contato['producao_cabelo'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="producao_cabelo" type="radio" value="0" <?php selecionaRadio($elenco_contato['producao_cabelo'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Usa aparelho nos dentes?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td width="9%"><input name="aparelho" type="radio" value="1" <?php selecionaRadio($elenco_contato['aparelho'], 1); ?> /></td>
        <td width="10%">sim</td>
        <td width="9%"><input name="aparelho" type="radio" value="0" <?php selecionaRadio($elenco_contato['aparelho'], 0); ?> /></td>
        <td width="72%">n&atilde;o</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Tem alguma fobia?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="fobia" type="radio" value="1" <?php selecionaRadio($elenco_contato['fobia'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="fobia" type="radio" value="0" <?php selecionaRadio($elenco_contato['fobia'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>qual:</td>
        <td><?php echo montaCampoSelect("tt_fobia", "cd_fobia", "fobia", "id_fobia", 1, false, "id_fobia", "width:120px;", $elenco_contato['cd_fobia']); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Tem alergia </td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="alergia" type="radio" value="1" <?php selecionaRadio($elenco_contato['alergia'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="alergia" type="radio" value="0" <?php selecionaRadio($elenco_contato['alergia'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>qual:</td>
        <td><?php echo montaCampoSelect("tt_alergia", "cd_alergia", "alergia", "id_alergia", 1, false, "id_alergia", "width:120px;", $elenco_contato['cd_alergia']); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Tem alguma restri&ccedil;&atilde;o alimentar?</td>
    <td><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="restricao_alimentar" type="radio" value="1" <?php selecionaRadio($elenco_contato['restricao_alimentar'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="restricao_alimentar" type="radio" value="0" <?php selecionaRadio($elenco_contato['restricao_alimentar'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>qual:</td>
        <td><?php echo montaCampoSelect("tt_restricao_alimentar", "cd_restricao_alimentar", "restricao_alimentar", "id_restricao_alimentar", 1, false, "id_restricao_alimentar", "width:120px;", $elenco_contato['cd_restricao_alimentar']); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="tdc">Tem alguma restri&ccedil;&atilde;o religiosa?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="restricao_religiosa" type="radio" value="1" <?php selecionaRadio($elenco_contato['restricao_religiosa'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="restricao_religiosa" type="radio" value="0" <?php selecionaRadio($elenco_contato['restricao_religiosa'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>qual:</td>
        <td><?php echo montaCampoSelect("tt_restricao_religiosa", "cd_restricao_religiosa", "restricao_religiosa", "id_restricao_religiosa", 1, false, "id_restricao_religiosa", "width:120px;", $elenco_contato['cd_restricao_religiosa']); ?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>Qualifica&ccedil;&atilde;o:</td>
    <td><?php echo montaCampoSelect("tt_qualificacao", "cd_qualificacao", "qualificacao", "id_qualificacao", 1, false, "id_qualificacao", "width:120px;", $elenco_contato['cd_qualificacao']); ?></td>
  </tr>
  <tr>
    <td class="tdc">Quais os melhores dias para participar de trabalhos?</td>
    <td class="tdc"><?php echo montaCampoSelect("tt_melhor_dia", "cd_melhor_dia", "melhor_dia", "id_melhor_dia", 1, false, "id_melhor_dia", "width:120px;", $elenco_contato['cd_melhor_dia']); ?></td>
  </tr>
  <tr>
    <td>Quais os melhores hor&aacute;rios para participar de trabalhos?</td>
    <td><?php echo montaCampoSelect("tt_melhor_horario", "cd_melhor_horario", "melhor_horario", "id_melhor_horario", 1, false, "id_melhor_horario", "width:120px;", $elenco_contato['cd_melhor_horario']); ?></td>
  </tr>
  <tr>
    <td class="tdc">Tem filhos?</td>
    <td class="tdc"><table width="100%" border="0" cellpadding="4">
      <tr>
        <td><input name="filhos" type="radio" value="1" <?php selecionaRadio($elenco_contato['filhos'], 1); ?> /></td>
        <td>sim</td>
        <td><input name="filhos" type="radio" value="0" <?php selecionaRadio($elenco_contato['filhos'], 0); ?> /></td>
        <td>n&atilde;o</td>
        <td>quantidade:</td>
        <td><input name="filhos_quantidade" type="text" id="filhos_quantidade" maxlength="40" value="<?= $elenco_contato['filhos_quantidade']; ?>" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
    <input type="hidden" name="id_elenco" id="id_elenco" value="<?= $id_elenco; ?>" />
	<input type="hidden" name="avancar" id="avancar" />
	<input name="btnGravarInfoContato" type="image"  src="../img/bt_gravar.gif" id="btnGravarInfoContato" onclick="return false;" />&nbsp;
	<input name="btnGravarInfoContato" type="image"  src="../img/bt_gravar_avancar.gif" id="btnGravarAvancar"  onclick="return false;" />
    </td>
    </tr>
</table>
</form>
<div id="mensagem_erro" style="color:#FF0000; font-weight:bold;"></div>


 <!-- final -->
 </td>
  </tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF"><img src="/magnetoelenco/admin/img/menu_pe.gif" width="990" height="26"></td>
  </tr>
</table>
</body>
</html>
<?php
	// Fecha a conexao com o banco de dados
	desconectaBD($idconn);
?>
