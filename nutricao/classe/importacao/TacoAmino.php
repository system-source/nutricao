<?php

require_once '../dominio/AlimentoTipo.php';
require_once '../dominio/Alimento.php';
require_once '../dominio/Caracteristica.php';
require_once '../dominio/Unidade.php';
require_once '../dominio/Composicao.php';

$handle = fopen("../../taco_amino", "r");
if ($handle) {
	
	$f_unidade = false;
	$f_caracteristica = false;
	$camposAnterior;
	
	$unidades = array();
	$caracteristicas = array();
	
	while (!feof($handle)) {
		$linha = fgets($handle);
		//echo $linha;
		$campos = explode("\t", $linha);
		
		//alimento
		if (is_numeric($campos[0])) {
			echo 'alimento: '. $campos[0] .' - '. $campos[1] ."\n";
			$a = new Alimento($campos[1], $campos[0], $at);
			try {
				$a->inserir();
			} catch (Exception $e) {
				$a->id = $a->buscarAlimento($a->nome)[0]["alimento_id"];
				//echo "\n". $e->getMessage() ."\t id=$at->id \n";
			}
			
			//adicionando valores as caracteristicas do alimento (composicao)*			
			for ($i = 2; $i < count($campos); $i++) {
				if ($i != 9) {
					
					$indiceC = $i;
					
					echo "\n\n\indice[$i]\tindiceC[$indiceC]\tvalor[". $campos[$i] ."]\n\n";
					
					$c = new Composicao($a, $caracteristicas[$indiceC], $unidades[$i], $campos[$i]);
					
					try {
						$c->inserir();
					} catch (Exception $e) {
						$c->valor = $c->buscarComposicao($a, $caracteristicas[$indiceC], $unidades[$i])[0]["valor"];
						echo $e->getMessage() ."\t valor=$c->valor \n\n";
					}
				}
			}

		}
		//tipo de alimento
		else if ($campos[0] != "" && $campos[2] == "") {
			echo 'alimento_tipo: '. $campos[0] ."\n";
			$at = new AlimentoTipo(-1, $campos[0]);
			try {
				$at->inserir();
			} catch (Exception $e) {
				$at->id = $at->buscarAlimentoTipo($at->nome)[0]["alimento_tipo_id"];
				//echo $e->getMessage() ."\t id=$at->id \n\n";
			}
		}
		//carcateristica
		else if ($campos[0] != "" && $campos[1] == "" && $campos[2] != "" && !$f_caracteristica) {
			for ($i = 2; $i < count($campos); $i++) {
				if ($campos[$i] != "" && $i != 9) {
					$caracteristica = new Caracteristica($camposAnterior[$i] . $campos[$i], null, null);
					
					try {
						$caracteristica->inserir();
					} catch (Exception $e) {
						$caracteristica->id = $caracteristica->buscarCaracteristica($caracteristica->nome)[0]["caracteristica_id"];
						echo $e->getMessage() ."\t caracteristica_id=$caracteristica->id \n\n";
					}
					$caracteristicas[$i] = $caracteristica;
					echo $camposAnterior[$i] . $campos[$i] ."\t";
				}
			}
			$f_caracteristica = true;
			echo "\n";
		}
		//unidade
		else if ($campos[0] != "" && $campos[1] != "" && $campos[2] != "" && !$f_unidade) {
			for ($i = 2; $i < count($campos); $i++) {
				if ($campos[$i] != "" && $i != 9) {
					$campos[$i] = str_replace(")", "", str_replace("(", "", $campos[$i]));
					$campos[$i] = str_replace("\n", "", $campos[$i]);
					
					$unidade = new Unidade(null, $campos[$i]);

					try {
						$unidade->inserir();
					} catch (Exception $e) {
						$unidade->id = $unidade->buscarUnidade($unidade->sigla)[0]["unidade_id"];
						echo $e->getMessage() ."\t id=$unidade->id \n\n";
					}
					$unidades[$i] = $unidade;
					echo $campos[$i] ."\t";
				}
			}
			$f_unidade = true;
			echo "\n";
		}
		else if ($campos[1] == "" && $campos[2] != "") {
			print_r($campos) ."\n";
		}
		
		//echo "\n";
		$camposAnterior = $campos;
		
	}
	fclose($handle);
}
?>