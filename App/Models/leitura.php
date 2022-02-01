<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Leitura extends Model{
		private $leitura_cod;
		private $numero_contador;
		private $leitura_actual;
		private $leitura_anterior;
		private $leitura_data;
		private $cod_agente;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}


		public function ultimaLeitura($contador){
			$query="select * from leitura where numero_contador =:contador
			ORDER BY leitura_cod DESC LIMIT 1";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':contador', $contador);
			$stmt->execute();

			$leitura= $stmt->fetch(\PDO::FETCH_ASSOC);
				
			return $leitura;
		}

		public function registrarLeitura($contador){

			$leitura = $this->ultimaLeitura($contador);


		
			if ($leitura) {

				$this->__set('leitura_anterior', $leitura['leitura_actual']);	

				$query="insert into leitura(numero_contador,leitura_actual,leitura_anterior,cod_agente)
					value(:contador, :leitura_actual, :leitura_anterior,:cod_agente)";
				$stmt = $this->db->prepare($query);
				$stmt->bindValue(':contador', $contador);
				$stmt->bindValue(':leitura_actual', $this->__get('leitura_actual'));
				$stmt->bindValue(':leitura_anterior', $this->__get('leitura_anterior'));
				$stmt->bindValue(':cod_agente', $this->__get('cod_agente'));
				$stmt->execute();



			}else{

				$query="insert into leitura(numero_contador,leitura_actual,leitura_anterior,cod_agente)
					value(:contador, :leitura_actual, :leitura_anterior,:cod_agente)";
				$stmt = $this->db->prepare($query);
				$stmt->bindValue(':contador', $contador);
				$stmt->bindValue(':leitura_actual', $this->__get('leitura_actual'));
				$stmt->bindValue(':leitura_anterior', 0);
				$stmt->bindValue(':cod_agente', $this->__get('cod_agente'));
				$stmt->execute();
				
			} 

		}

	}

?>