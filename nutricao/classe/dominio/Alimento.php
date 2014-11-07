<?php

	require_once __DIR__ .'/Dominio.php';

	class Alimento extends Dominio {
		
		public $id;
		public $nome;
		public $codigo;
		
		public function __construct() {
			parent::__construct();
		}
		
		public function buscarAlimento() {
			try {
				$consulta = "select * from alimento";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function inserir() {
			
			$campos = array("nome","codigo_taco");
			$valores = array("'". $this->nome ."'", $this->codigo);
			
			try {
				return $this->repositorio->inserir("alimento", $campos, $valores);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
	}

?>