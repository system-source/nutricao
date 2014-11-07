<?php

require_once '../dominio/AlimentoTipo.php';

$handle = fopen("../../taco_geral", "r");
if ($handle) {
	while (!feof($handle)) {
		$linha = fgets($handle);
		//echo $linha;
		$campos = explode("\t", $linha);
		
		if (is_numeric($campos[0])) {
			echo 'alimento: '. $campos[0] .' - '. $campos[1] ."\n";
		} else if ($campos[0] != "" && $campos[2] == "") {
			echo 'alimento_tipo: '. $campos[0] ."\n";
			$at = new AlimentoTipo(-1, $campos[0]);
			$at->inserir();
		} else if ($campos[1] == "" && $campos[2] != "") {
			print_r($campos) ."\n";
		}
		
		//echo "\n";
		
	}
	fclose($handle);
}
?>