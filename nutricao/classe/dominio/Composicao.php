<?php

	require_once __DIR__ .'/Dominio.php';

	class Composicao extends Dominio {
		
		const TR = -1;
		const NA = -2;
		const AST = -3;
		
		public $alimento;
		public $caracteristica;
		public $unidade;
		public $valor;
		
		public function __construct($alimento, $caracteristica, $unidade, $valor) {
			parent::__construct();
			
			$this->alimento = $alimento;
			$this->caracteristica = $caracteristica;
			$this->unidade = $unidade;
			
			$valor = str_replace(",", ".", $valor);
			$valor = str_replace("\n", "", $valor);
			$valor = str_replace(" ", "", $valor);
			
			if ($valor == "") {
				$this->valor = 0;
			} else if (is_string($valor)) {
				if (strtolower($valor) == "tr") {
					$this->valor = self::TR;
				} else if(strtolower($valor) == "na") {
					$this->valor = self::NA;
				} else if(strtolower($valor) == "*") {
						$this->valor = self::AST;
				} else {
					$this->valor = $valor;
				}
			}
			
			//echo "\n\n\n valor=[". $this->valor ."]\n\n";

		}
		
		public function listarComposicaoAlimento($alimento) {
			try {
				$consulta = "SELECT * FROM composicao WHERE alimento_id = $alimento->id";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e; 
			}
		}
		
		public function buscarComposicao($alimento, $caracteristica, $unidade) {
			try {
				$consulta = "
					SELECT * 
					FROM composicao 
					WHERE alimento_id = $alimento->id
						AND caracteristica_id = $caracteristica->id
						AND unidade_id = $unidade->id
				";
				return $this->repositorio->buscar_arr($consulta);
			} catch (Exception $e) {
				throw $e;
			}
		}
		
		public function inserir() {
			
			$campos = array("alimento_id","caracteristica_id","unidade_id", "valor");
			$valores = array($this->alimento->id, $this->caracteristica->id, $this->unidade->id, $this->valor);
			
			try {
				$composicoes = $this->buscarComposicao($this->alimento, $this->caracteristica, $this->unidade);
				if (count($composicoes) == 0) {
					$inseriu = $this->repositorio->inserir("composicao", $campos, $valores);
					//caso ocorra algum problema, uma exceção estoura e essa parte não é executada
					$this->valor = $this->buscarComposicao($this->alimento, $this->caracteristica, $this->unidade)[0]["valor"];
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