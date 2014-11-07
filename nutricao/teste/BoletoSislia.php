<?php

	require_once '../classe/dominio/BoletoSislia.php';

	$boleto = new BoletoSislia();
	$arr = $boleto->buscarBoleto();
	echo $arr[0]['boleto_sislia_id'];

?>