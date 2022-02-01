<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Factura extends Model{
		private $fact_cod;
		private $factura_valor;
		private $factura_multa;
		private $factura_valor_liquidado;
		private $facura_valor_debito;
		private $cod_leitura ;
		private $cod_pagamento ;



		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function salvar(){
			$query ="select * from leitura as l
				left join contrato as c on(c.numero_contador=l.numero_contador)
				where leitura_cod=:cod_leitura
			";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':cod_leitura', $this->__get('cod_leitura'));
			$stmt->execute();

			$leitura= $stmt->fetch(\PDO::FETCH_ASSOC);
			

			if($leitura['contrato_tipo']=='domestico'){
				
			
				$pagamento = ($leitura['leitura_actual'] - $leitura['leitura_anterior'])*54;

				$this->__set('factura_valor',$pagamento);


			}else{
				$pagamento = ($leitura_actual-$leitura_anterior)*74;							
				$this->__set('factura_valor', $pagamento);
				
			}
			
			$query="insert into factura(factura_valor, cod_leitura)
			values(:factura_valor, :cod_leitura)";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':cod_leitura', $this->__get('cod_leitura'));
			$stmt->bindValue(':factura_valor', $this->__get('factura_valor'));
			$stmt->execute();

		}


		public function facturasNaoPagas($contador){
			$query="Select * from leitura as l
				 join factura as f on(l.leitura_cod=f.cod_leitura)
				 where (numero_contador='$contador')";

			$stmt = $this->db->prepare($query);
			$stmt->execute();

			$facturas=$stmt->fetchAll(\PDO::FETCH_ASSOC);

			return $facturas;
		

		}

	}
?>