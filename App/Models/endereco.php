<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Endereco extends Model{
		
		private $id_contrato;
		private $endereco_bairro;
		private $endereco_quarteirao;
		private $endereco_casa;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}


		public function salvar(){
				try{

				$query="insert into endereco (id_contrato, endereco_bairro, endereco_quarteirao,endereco_casa)
				 values(:id_contrato, :endereco_bairro,:endereco_quarteirao, :endereco_casa)";

					$stmt= $this->db->prepare($query);
					
					$stmt->bindValue(':id_contrato', $this->__get('id_contrato'));
					$stmt->bindValue(':endereco_bairro', $this->__get('endereco_bairro'));
					$stmt->bindValue(':endereco_quarteirao', $this->__get('endereco_quarteirao'));
					$stmt->bindValue(':endereco_casa', $this->__get('endereco_casa'));
					
					$stmt-> execute();

				}catch(Exception $e){
					return false;
				}
				
					return true;
		}
		


	}
?>
