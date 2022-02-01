<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Telefone extends Model{
		private $cod_cliente;
		private $telefone1;
		private $telefone2;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function salvar(){
			$query= "insert into telefone(cod_cliente, telefone1, telefone2) values(:cod_cliente, :telefone1,:telefone2)";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':cod_cliente', $this->__get('cod_cliente'));
			$stmt->bindValue(':telefone1', $this->__get('telefone1'));
			$stmt->bindValue(':telefone2', $this->__get('telefone2'));
			$stmt->execute();
		}

	}

?>