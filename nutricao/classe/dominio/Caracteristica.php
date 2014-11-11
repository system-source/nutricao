<?php

	require_once __DIR__ .'/Dominio.php';

	class Caracteristica extends Dominio {
		
		public $id;
		public $nome;
		public $sigla;
		public $caracteristicaTipo;
		
		public function __construct($nome, $sigla, $caracteristicaTipo) {
			parent::__construct();
			
			$this->nome = $nome;
			$this->sigla = $sigla;
			$this->caracteristicaTipo = $caracteristicaTipo;
		}
		
		public function listarCararcteristica() {
			try {
				$consulta = "SELECT * FROM caracteristica";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function buscarCaracteristica($nome) {
			try {
				$consulta = "SELECT * FROM caracteristica WHERE nome = '$nome'";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
		public function inserir() {
			
			try {
				$campos = array("nome","sigla","caracteristica_tipo_id");
				$valores = array("'". $this->nome ."'", "'". $this->sigla ."'", $this->caracteristicaTipo->id);
			} catch (Exception $e) {
			}
			
			if (is_null($this->sigla) && !is_null($this->caracteristicaTipo)) {
				$campos = array("nome","caracteristica_tipo_id");
				$valores = array("'". $this->nome ."'", $this->caracteristicaTipo->id);
			}
			
			if (is_null($this->sigla) && is_null($this->caracteristicaTipo)) {
				$campos = array("nome");
				$valores = array("'". $this->nome ."'");
			}
			
			try {
				$caracteristicas  = $this->buscarCaracteristica($this->nome);
				if (count($caracteristicas) == 0) {
					$inseriu = $this->repositorio->inserir("caracteristica", $campos, $valores);
					//caso ocorra algum problema, uma exceção estoura e essa parte não é executada
					$this->id = $this->buscarCaracteristica($this->nome)[0]["caracteristica_id"];
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