<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Cliente extends Model{

		private $cliente_cod; 
		private $cod_agente;
		private $cliente_nome;
		private $cliente_apelido;
		private $cliente_cidade; 
		private $cliente_bairro; 
		private $cliente_quarteirao;
		private $cliente_casa;
		private $cliente_nacionalidade; 
		private $cliente_sexo;
		private $cliente_nuit;
		private $cliente_estado;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}



		public function dadosValidos(){
			$controle=true;

			if(strlen($this->__get('cliente_nome'))<3){
				$controle=false;
			}
			if(strlen($this->__get('cliente_apelido'))<3){
				$controle=false;
			}
			if(strlen($this->__get('cliente_cidade'))<3){
				$controle=false;
			}
			if(strlen($this->__get('cliente_bairro'))<3){
				$controle=false;
			}
			if($this->__get('cliente_quarteirao')==0){
				$controle=false;
			}

			if($this->__get('cliente_casa')==0){
				$controle=false;
			}
			if(strlen($this->__get('cliente_nacionalidade'))<3){
				echo'nacionalidade';
				$controle=false;
			}
			if(strlen($this->__get('cliente_sexo'))<1){
	
				$controle=false;
			}
			if (strlen($this->__get('cliente_nuit'))<3) {
				$controle =false;
			}
			
		
			return $controle;

		}

		public function salvar(){
			$query ="insert into cliente(cliente_cod,cod_agente,cliente_nome,cliente_apelido, cliente_cidade,cliente_bairro,cliente_quarteirao,cliente_casa,cliente_nacionalidade,cliente_sexo,cliente_nuit)

			 VALUES(:cliente_cod,:cod_agente,:cliente_nome,:cliente_apelido,:cliente_cidade,:cliente_bairro,:cliente_quarteirao,:cliente_casa,:cliente_nacionalidade,:cliente_sexo,:cliente_nuit)";

			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':cliente_cod',$this->__get('cliente_cod'));
			$stmt->bindValue(':cod_agente',$this->__get('cod_agente'));
			$stmt->bindValue(':cliente_nome',$this->__get('cliente_nome'));
			$stmt->bindValue(':cliente_apelido',$this->__get('cliente_apelido'));
			$stmt->bindValue(':cliente_cidade',$this->__get('cliente_cidade'));
			$stmt->bindValue(':cliente_bairro',$this->__get('cliente_bairro'));
			$stmt->bindValue(':cliente_quarteirao',$this->__get('cliente_quarteirao'));
			$stmt->bindValue(':cliente_casa',$this->__get('cliente_casa'));
			$stmt->bindValue(':cliente_nacionalidade',$this->__get('cliente_nacionalidade'));
			$stmt->bindValue(':cliente_sexo',$this->__get('cliente_sexo'));
			$stmt->bindValue(':cliente_nuit',$this->__get('cliente_nuit'));
			$stmt->execute();
		}


		public function getAllClientes($parametro){
			$query="SELECT * from cliente WHERE cliente_nome like '%$parametro%' 
			or cliente_apelido like '%$parametro%' or cliente_nuit like '%$parametro%'";

			$stmt= $this->db->prepare($query);
			//$stmt->bindValue(':parametro',$parametro);
			$stmt->execute();
			

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}


		
		public function recuperarAllClientes($parametro){
			$query="SELECT * from cliente as cl
				join contrato c on (cl.cliente_cod = c.cod_cliente)
			WHERE cliente_nome like '%$parametro%' 
			or cliente_apelido like '%$parametro%'
				or cliente_cod = '$parametro' or numero_contador='$parametro'
				limit 1
				";

			$stmt= $this->db->prepare($query);
			//$stmt->bindValue(':parametro',$parametro);
			$stmt->execute();
			

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}


		public function actualizarDados(){

		}
	}
?>