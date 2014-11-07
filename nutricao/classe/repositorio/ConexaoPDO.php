<?php

require_once __DIR__ .'/Conexao.php';

class ConexaoPDO implements Conexao {

	private $conexao;
	
/*	function __construct($conexao) {
		$this->conexao = $conexao;
	}
*/	
	function __construct() {
		//pgsql:host=localhost dbname=nome_do_banco user=jvideos10 password=password
		try {
			$user="postgres";
			$pass="postgres";
			$this->conexao = new PDO('pgsql:host=localhost;dbname=nutricao', $user, $pass);
			
//			$sql = "SELECT * FROM teste";
//			$st = $this->conexao->query($sql)->fetchAll();
			
			if (!is_null($this->conexao->errorCode())) {
				//echo('Erro: '. gettype($this->conexao->errorCode()) .' '. $this->conexao->errorCode());
				throw new Exception($this->conexao->errorInfo()[2]);
			}

//			echo $st[0]['nome'];
//			echo $this->conexao->errorInfo()[2];
		} catch (Exception $e){
			//echo 'Erro: '. $e->getMessage();
			throw new Exception($e->getMessage());
		}
		
	}
	
	public function getConexao() {
		return $this->conexao;
	}
}

?>