<?php

	require_once __DIR__ .'/Dominio.php';

	class AlimentoTipo extends Dominio {
		
		public $id;
		public $nome;
		
		public function __construct($id, $nome) {
			parent::__construct();
			$this->id = $id;
			$this->nome = $nome;
		}
		
		public function listarAlimentoTipo() {
			try {
				$consulta = "select * from alimento_tipo";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function buscarAlimentoTipo($tipo) {
			try {
				$consulta = "SELECT * FROM alimento_tipo WHERE nome = '$tipo'";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
		public function inserir() {
			
			$campos = array("nome");
			$valores = array("'". $this->nome ."'");
			
			try {
				$tipos = $this->buscarAlimentoTipo($this->nome);
				if (count($tipos) == 0) {
					$inseriu = $this->repositorio->inserir("alimento_tipo", $campos, $valores);
					//caso ocorra algum problema, uma exceção estoura e essa parte não é executada
					$this->id = $this->buscarAlimentoTipo($this->nome)[0]["alimento_tipo_id"];
					return $inseriu;
				} else {
					$this->id = $tipos[0]["alimento_tipo_id"];
					throw new Exception("Banco possui registro com mesmo valor"); 
				}
			} catch (Exception $e) {
				throw $e;
			}
		}
		
	}

?>