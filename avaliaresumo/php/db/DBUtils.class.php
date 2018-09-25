<?php
	
	require_once 'config/DatabaseConfig.class.php';

	class DBUTils {

		private $connection;

		function __construct() {
			$dbConfig = new DatabaseConfig();
			$this->connection = mysqli_connect($dbConfig->getHost(),$dbConfig->getUser(),
				$dbConfig->getPassword(),$dbConfig->getDataBase());
		}

		public function executarConsulta($sql) {
			mysqli_query($this->connection,'SET CHARACTER SET utf8');
			$query = mysqli_query($this->connection,$sql);
			while ($aux = mysqli_fetch_array($query)) {
				$rows[] = $aux;
			}
			return @$rows;
		}

		public function executar($sql) {				
			if (mysqli_query($this->connection, $sql)) {
				return true;
			}
			else {
				return false;
			}
		}

	}

?>