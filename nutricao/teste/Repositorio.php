<?php 

	require_once '../classe/repositorio/RepositorioPDO.php';
	
	$repositorio = new RepositorioPDO();
	
	//teste de buscar_arr
	$sql = "select * from teste ";
	try {
		$arr = $repositorio->buscar_arr($sql);
		
		echo $arr[0]['nome'];
	} catch (Exception $e) {
		echo 'Erro t_: '. $e->getMessage();
	}
	
	
	//teste de buscar_stm
	$sql = "select * from teste ";
	try {
		$arr = $repositorio->buscar_stm($sql);
	
		echo $arr['nome'];
	} catch (Exception $e) {
		echo 'Erro t_: '. $e->getMessage();
	}


?>