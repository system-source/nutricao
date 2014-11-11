<?php

	require_once __DIR__ .'/Dominio.php';

	class Unidade extends Dominio {
		
		public $id;
		public $nome;
		public $sigla;
		
		public function __construct($nome, $sigla) {
			parent::__construct();
			
			$this->nome = $nome;
			$this->sigla = $sigla;
		}
		
		public function listarUnidade() {
			try {
				$consulta = "SELECT * FROM unidade";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function buscarUnidade($sigla) {
			try {
				$consulta = "SELECT * FROM unidade WHERE sigla = '$sigla'";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
		public function inserir() {
			
			$campos = array("nome","sigla");
			$valores = array("'". $this->nome ."'", "'". $this->sigla ."'");
			
			if (is_null($this->nome)) {
				$campos = array("sigla");
				$valores = array("'". $this->sigla ."'");
			}
			
			try {
				$unidades  = $this->buscarUnidade($this->sigla);
				if (count($unidades) == 0) {
					$inseriu = $this->repositorio->inserir("unidade", $campos, $valores);
					//caso ocorra algum problema, uma exceção estoura e essa parte não é executada
					$this->id = $this->buscarUnidade($this->sigla)[0]["unidade_id"];
					return $inseriu;
				} else {
					throw new Exception("Banco possui registro com mesmo valor");
				}
			} catch (Exception $e) {
				throw $e;
			}
		}
		
	}

?>