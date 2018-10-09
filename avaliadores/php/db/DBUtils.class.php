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

		//Alteração necessária para retornar apenas o valor do ID do evento;
		//a consulta acima retornava o valor dentro de um vetor porém vinha dados 
		//além dos esperados. Remover essa função é uma opção, porém alterar
		//a função de cima é algo muito arriscado
		public function getIdEvento() {
			$sql = 'SELECT eventos.id AS id
					FROM eventos
					WHERE CURDATE() > eventos.termino_submissao AND 
					CURDATE() < eventos.termino;';

			mysqli_query($this->connection,'SET CHARACTER SET utf8');
			$query = mysqli_query($this->connection,$sql);
			$aux = mysqli_fetch_array($query);
			return @$aux[id];
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