<?php

	require_once __DIR__ .'/Dominio.php';

	class Alimento extends Dominio {
		
		public $id;
		public $nome;
		public $codigo;
		public $alimentoTipo;
		
		public function __construct($nome, $codigo, $alimentoTipo) {
			parent::__construct();
			
			$this->nome = $nome;
			$this->codigo = $codigo;
			$this->alimentoTipo = $alimentoTipo;
		}
		
		public function listarAlimento() {
			try {
				$consulta = "select * from alimento";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function buscarAlimento($nome) {
			try {
				$consulta = "SELECT * FROM alimento WHERE nome = '$nome'";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
		public function inserir() {
			
			$campos = array("nome","codigo_taco","alimento_tipo_id");
			$valores = array("'". $this->nome ."'", $this->codigo, $this->alimentoTipo->id);
			
			try {
				$alimentos = $this->buscarAlimento($this->nome);
				if (count($alimentos) == 0) {
					$inseriu = $this->repositorio->inserir("alimento", $campos, $valores);
					//caso ocorra algum problema, uma exceção estoura e essa parte não é executada
					$this->id = $this->buscarAlimento($this->nome)[0]["alimento_id"];
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