<?php

	//CONFIGURAÇÕES NECESSÁRIAS PARA O NORMAL FUNCIONAMENTO DO SISTEMA.
	
	class GeralConfig {

		//Editar este atributo, conforme o id do evento atual do CIUFLA.
		private static $eventoId = 8;

		public static function getEventoId() {
			return self::$eventoId;
		}

	}

?>