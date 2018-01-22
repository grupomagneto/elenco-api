<?php
	class Agenda{
		// Atributos
		private $id_agenda;
		public $dh_agendamento;
		public $cd_elenco;
		public $nome;
		public $nome_artistico;
		public $email;
		
		public static function inicializaAgendaPorIdCriptografado($id){
			$sql = "select a.id_agenda, a.cd_elenco, a.dh_agendamento, e.nome, e.nome_artistico, e.email
				   from tb_agenda as a, tb_elenco as e
				   where e.id_elenco = a.cd_elenco 
				   and SHA1(id_agenda) = '$id'";
			
			$rs = mysql_query($sql);
			if($row = mysql_fetch_array($rs)){
				$agendamento = new Agenda;
				$agendamento->id_agenda        = $row['id_agenda'];
				$agendamento->cd_elenco        = $row['cd_elenco'];
				$agendamento->dh_agendamento   = $row['dh_agendamento'];
				$agendamento->nome             = $row['nome'];
				$agendamento->nome_artistico   = $row['nome_artistico'];
				$agendamento->email            = $row['email'];				
				
				return $agendamento;
			}
			else{
				return false;
			}
		}
		
		public function getIdAgenda(){
			return $this->id_agenda;
		}
		
		public static function consultaAgendamentoPorHorario($horario){
			$sql = "select a.id_agenda, e.nome, e.nome_artistico, e.tl_celular, e.cd_status_elenco, a.cd_elenco, e.cadastro_pago
				   from tb_elenco as e, tb_agenda as a
				   where e.id_elenco = a.cd_elenco
				   and a.dh_agendamento = '$horario'";

			$rs = mysql_query($sql);
			if($row = mysql_fetch_array($rs)){
				$agendamento = new Agenda;
				$agendamento->id_agenda        = $row['id_agenda'];
				$agendamento->cd_elenco        = $row['cd_elenco'];
				$agendamento->nome             = $row['nome'];
				$agendamento->nome_artistico   = $row['nome_artistico'];
				$agendamento->cad_type   	   = ($row['cadastro_pago']) ? 'PAGO' : 'GRATUITO';
				//$agendamento->cad_type   	   = $row['cadastro_pago'];
				$agendamento->tl_celular       = $row['tl_celular'];
				$agendamento->cd_status_elenco = $row['cd_status_elenco'];
				
				return $agendamento;
			}
			else{
				return false;
			}
		}
		
		public static function consultaAgendamentosPorDia($dia){
			$array_agendamento = array();
			$sql = "select a.id_agenda, e.nome, e.nome_artistico, e.email, e.tl_celular, e.cd_status_elenco, a.cd_elenco
				   from tb_elenco as e, tb_agenda as a
				   where e.id_elenco = a.cd_elenco
				   and dh_agendamento between '$dia 00:00:00' and '$dia 23:59:59'";
			
			$rs = mysql_query($sql);
			while($row = mysql_fetch_array($rs)){
				$agendamento = new Agenda;
				$agendamento->id_agenda        = $row['id_agenda'];
				$agendamento->cd_elenco        = $row['cd_elenco'];
				$agendamento->nome             = $row['nome'];
				$agendamento->nome_artistico   = $row['nome_artistico'];
				$agendamento->email            = $row['email'];
				$agendamento->tl_celular       = $row['tl_celular'];
				$agendamento->cd_status_elenco = $row['cd_status_elenco'];
				$array_agendamento[] = $agendamento;
			}
			
			return $array_agendamento;
		}
		
		public static function removeAgendamentosPorDia($dia){
			return deletaDados("tb_agenda", "dh_agendamento between '$dia 00:00:00' and '$dia 23:59:59'");
		}
		
		public function removeAgendamento(){
			return deletaDados("tb_agenda", "id_agenda = $this->id_agenda");
		}
		
		public static function cancelaDia($dia, $cd_admin){
			$colunas = array("dt_agendamento", "cd_admin");
			$valores = array(toString($dia), $cd_admin);
			return insereDados("tb_cancelamento_agenda", $colunas, $valores);		
		}
		
		public static function reativaDia($dia){
			return deletaDados("tb_cancelamento_agenda", "dt_agendamento = '$dia'");	
		}				
		
		public static function proximoHorario($horario, $intervalo){
			$stamp_horario = strtotime($horario);
			$stamp_next = $stamp_horario + ($intervalo * 60);
			return date("Y-m-d H:i:s", $stamp_next);		
		}
		
		public static function verificaCancelamento($dia){
			$sql = "select id_cancelamento_agenda 
					from tb_cancelamento_agenda
					where dt_agendamento = '$dia'";
			$rs = mysql_query($sql);
			
			if(mysql_num_rows($rs) > 0) return true;
			else return false;		
		}
		
	}
?>