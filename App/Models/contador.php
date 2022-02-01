<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Contador extends Model{
		
		private $contador_numero;
		private $cod_cliente;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}


		public function salvar(){

			try{

				$query="insert into contador (contador_numero) values(:contador_numero)";

				$stmt= $this->db->prepare($query);
				$stmt->bindValue(':contador_numero', $this->__get('contador_numero'));
				$stmt-> execute();
			}catch(Exception $e){
				return false;
			}
			
			return true;
		}

		public function validarRegistro(){

			$controle=true;

			if(strlen($this->__get('contador_numero'))<3){
				$controle=false;
			}

			return $controle;
		}

		public function recuperar(){
			$query = "select * from contador where contador_numero=:numero";

			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':numero', $this->__get('contador_numero'));	
			$stmt->execute();
			
			$contador=$stmt->fetch(\PDO::FETCH_ASSOC);

		

			return $contador;
		}

		public function valido($numero){
			
			$controle = true;
			$query = "select contador_numero from contador where contador_numero= :numero";

			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':numero', $numero);	
			$stmt->execute();
			if($stmt->fetch(\PDO::FETCH_ASSOC)){
				$controle=false;

			}

			return $controle;
		}

	}

?>