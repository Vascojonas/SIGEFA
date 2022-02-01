<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Contrato extends Model{

		private $numero_contador;
		private $cod_cliente;
		private $contrato_tipo;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function salvar(){

			try{

				$query="insert into contrato (numero_contador, cod_cliente, contrato_tipo) values(:numero_contador, :cod_cliente, :contrato_tipo)";

				$stmt= $this->db->prepare($query);
				$stmt->bindValue(':numero_contador', $this->__get('numero_contador'));
				$stmt->bindValue(':cod_cliente', $this->__get('cod_cliente'));
				$stmt->bindValue(':contrato_tipo', $this->__get('contrato_tipo'));
				$stmt-> execute();
			}catch(Exception $e){
				return false;
			}
			
			return true;
		}

		public function recuperar(){
			$query = "select * from contrato where numero_contador= :numero_contador";
			$stmt= $this->db->prepare($query);
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':numero_contador', $this->__get('numero_contador'));
			
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}


		public function getClienteByContador($contador){
			$query = "select 
					numero_contador, cliente_nome, cliente_apelido, cliente_bairro, 
					cliente_quarteirao, cliente_casa
					from contrato as c  left join cliente as cl  on (c.cod_cliente=cl.cliente_cod)
					where numero_contador = :numero_contador;";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':numero_contador', $contador);
			$stmt->execute();

			$cliente= $stmt->fetch(\PDO::FETCH_ASSOC);;

			return $cliente;
		}
	}
?>