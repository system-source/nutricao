<?php

	require_once __DIR__ .'/../repositorio/RepositorioPDO.php';

	class Dominio {
		
		protected $repositorio;
		
		public function __construct() {
			try {
				$this->repositorio = new RepositorioPDO();
			} catch (Exception $e) {
				throw $e;
			}
		}
		
		

		
	}

?>