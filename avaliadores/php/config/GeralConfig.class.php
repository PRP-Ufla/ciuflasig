<?php

	//CONFIGURAÇÕES NECESSÁRIAS PARA O NORMAL FUNCIONAMENTO DO SISTEMA.
	
	class GeralConfig {

		//Editar este atributo, conforme o id do evento atual do CIUFLA.
		//private static $eventoId = 11;

		//NOVA CONSULTA
		//Alterações para gerar atributo automaticamente
		//Busca da classe DBUtils o ID do evento
		private static function getId(){
			require_once 'db/DBUtils.class.php';
			$db = new DBUtils();

			$eid = $db -> getIdEvento();
			return $eid;
		}
		//FIM


		public static function getEventoId() {
			return self::getId();
		}

	}

?>