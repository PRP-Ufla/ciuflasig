<?php

	class DataBaseConfig {

		// private $host = "forro.ufla.br";
		// private $dataBase = "bd_ciufla2011";	
		// //private $user = "admin_ciufla2011";
		// //private $password = "BdGdr424";
		// private $user = "sistemasprp";
		// private $password = "JjJnAPw7YYjAbRAT";

		private $host = "localhost";
		private $dataBase = "bd_ciufla2011_teste";
		private $user = "root";
		private $password = "";

		public function getHost() {
			return $this->host;
		}

		public function getDataBase() {
			return $this->dataBase;
		}

		public function getUser() {
			return $this->user;
		}

		public function getPassword() {
			return $this->password;
		}

	}

?>