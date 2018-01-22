<?php
	//Include dos arquivos de sistema e validacao
	include("includes/valida_acesso_adm.php");
	include("../sys/api/DataManipulation.php");
	
	//Include do arquivo com o topo
	include("includes/topo_adm.php");
?>

      
<img src="img/tit_seja_bemvindo.gif" width="257" height="68" class="tit" /><br /><br />
     
<div class="home_pad">
     
<!-- primeira tabela  reconvocar novas fotos -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr>
    <td colspan="3" class="pln"><img src="img/tit_reconvocar_foto.gif" width="291" height="50" /></td>
    </tr>
  <tr bgcolor="#c3161c">
    <td width="27%" class="font_br">NOME</td>
    <td width="32%" class="font_br">NOME ARTÍSTICO</td>
    <td width="41%" class="font_br">AÇÃO</td>
  </tr>
  <tr>
    <td>Adriano Cunha Moura</td>
    <td>Adriano  Moura</td>
    <td><a href="#">Agendar nova foto</a></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td>Adriel Carlo Batista Cardoso</td>
    <td>Adriel  Cardoso</td>
    <td><a href="#">Agendar nova foto</a></td>
  </tr>
  <tr>
    <td>Alan tetsuia</td>
    <td>Alan Bique</td>
    <td><a href="#">Agendar nova foto</a></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td>Alana Teixeira Ferrigno</td>
    <td>Alana  Ferrigno</td>
    <td><a href="#">Agendar nova foto</a></td>
  </tr>
  <tr>
    <td>Alberto Fernandes Schlapfer</td>
    <td>Alberto  Schlapfer</td>
    <td><a href="#">Agendar nova foto</a></td>
  </tr>
</table>
<!-- fim primeira tabela  reconvocar novas fotos -->


<!-- segunda tabela reconvocar novo contrato  -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr>
    <td colspan="3" class="pln"><img src="img/tit_reconvocar_contrato.gif" width="291" height="50" /></td>
    </tr>
  <tr bgcolor="#c3161c">
    <td width="27%" class="font_br">NOME</td>
    <td width="32%" class="font_br">NOME ARTÍSTICO</td>
    <td width="41%" class="font_br">AÇÃO</td>
  </tr>
  <tr>
    <td>Adriano Cunha Moura</td>
    <td>Adriano  Moura</td>
    <td>Nova data de contrato: <input class="ipth"></input> <input type="submit" value="Gravar" class="ipt_gravar" ></input></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td>Adriel Carlo Batista Cardoso</td>
    <td>Adriel  Cardoso</td>
    <td>Nova data de contrato: 
      <input class="ipth" /> <input type="submit" value="Gravar" class="ipt_gravar" ></input></td>
  </tr>
  <tr>
    <td>Alan tetsuia</td>
    <td>Alan Bique</td>
    <td>Nova data de contrato: 
      <input class="ipth" /> <input type="submit" value="Gravar" class="ipt_gravar" ></input></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td>Alana Teixeira Ferrigno</td>
    <td>Alana  Ferrigno</td>
    <td>Nova data de contrato: 
      <input class="ipth" /> <input type="submit" value="Gravar" class="ipt_gravar" ></input></td>
  </tr>
  <tr>
    <td>Alberto Fernandes Schlapfer</td>
    <td>Alberto  Schlapfer</td>
    <td>Nova data de contrato: 
      <input class="ipth" /> <input type="submit" value="Gravar" class="ipt_gravar" ></input></td>
  </tr>
</table>
<!-- fim segunda tabela reconvocar novo contrato -->


<!-- terceira tabela perfis não publicados  -->
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="tab_cor">
  <tr>
    <td colspan="3" class="pln"><img src="img/tit_perfis_npublicados.gif" width="197" height="50" /></td>
    </tr>
  <tr bgcolor="#c3161c">
    <td width="27%" class="font_br">NOME</td>
    <td width="32%" class="font_br">NOME ARTÍSTICO</td>
    <td width="41%" class="font_br">AÇÃO</td>
  </tr>
  <tr>
    <td>Adriano Cunha Moura</td>
    <td>Adriano  Moura</td>
    <td><a href="#">Ver detalhe</a></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td>Adriel Carlo Batista Cardoso</td>
    <td>Adriel  Cardoso</td>
    <td><a href="#">Ver detalhe</a></td>
  </tr>
  <tr>
    <td>Alan tetsuia</td>
    <td>Alan Bique</td>
    <td><a href="#">Ver detalhe</a></td>
  </tr>
  <tr bgcolor="#f5f5f5">
    <td>Alana Teixeira Ferrigno</td>
    <td>Alana  Ferrigno</td>
    <td><a href="#">Ver detalhe</a></td>
  </tr>
  <tr>
    <td>Alberto Fernandes Schlapfer</td>
    <td>Alberto  Schlapfer</td>
    <td><a href="#">Ver detalhe</a></td>
  </tr>
</table>
<!-- fim terceira tabela perfis não publicados -->
      
</div>


 <!-- final -->
 </td>
  </tr>
	<tr>
	  <td colspan="2" bgcolor="#FFFFFF"><img src="/admin/img/menu_pe.gif" width="990" height="26"></td>
  </tr>
</table>
</body>
</html>
