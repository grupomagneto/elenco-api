<!-- busca -->
<form name="busca_elenco" method="post" action="/magnetoelenco/admin/elenco/resultado_busca.php">
<table width="490" border="0" cellpadding="0">
	<tr>
	<td width="33%">Buscar somente:<br />
		<select name="condicao" id="condicao">
			<option value="0">---</option>
			<option value="5" <?php if($pesquisa_condicao == 5) echo "selected"; ?>>Publicados</option>
			<option value="1" <?php if($pesquisa_condicao == 1) echo "selected"; ?>>Não publicados</option>
			<option value="2" <?php if($pesquisa_condicao == 2) echo "selected"; ?>>Aptos a fazer trabalhos de nu</option>
			<option value="3" <?php if($pesquisa_condicao == 3) echo "selected"; ?>>Casting de corpo</option>
			<option value="4" <?php if($pesquisa_condicao == 4) echo "selected"; ?>>Casting de mãoes e pés</option>
		</select>
	</td>
	<td width="1%">&nbsp;</td>
	<td width="44%">Buscar por nome:<br />
		<input name="nome_busca" type="text" id="nome_busca" value="<?= $pesquisa_nome; ?>" style="width:95%;" maxlength="14" />
	</td>
	<td width="1%">&nbsp;</td>
	<td width="21%" align="right" valign="bottom" style="padding-right:10px;">
		<input name="buscar_povo" type="image"  src="../img/bt_ok.gif" id="busca_povo"/>
	</td>
	</tr>
</table>
</form>
<!-- busca fim -->
