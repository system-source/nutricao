<?php

	require_once __DIR__ .'/Dominio.php';

	class Unidade extends Dominio {
		
		public $id;
		public $nome;
		public $sigla;
		
		public function __construct() {
			parent::__construct();
		}
		
		public function buscar() {
			try {
				$consulta = "select * from unidade";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function inserir() {
			
			$campos = array("nome","sigla");
			$valores = array("'". $this->nome ."'", $this->sigla);
			
			try {
				return $this->repositorio->inserir("unidade", $campos, $valores);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
	}

?>