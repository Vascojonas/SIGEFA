<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Agente extends Model{

		private $agente_cod; 
		private $cod_admin;
		private $agente_nome;
		private $agente_apelido;
		private $agente_cidade; 
		private $agente_bairro; 
		private $agente_quarteirao;
		private $agente_casa;
		private $agente_nacionalidade; 
		private $agente_sexo;
		private $agente_nuit;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function getDadosById(){
			
			$query="select * from agente where agente_cod= :id_usuario";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':id_usuario',$_SESSION['id_usuario']);
			$stmt->execute();

			$agente = $stmt->fetch(\PDO::FETCH_ASSOC);

			if($agente){
				$this->__set('agente_cod', $agente['agente_cod'] );
				$this->__set('cod_admin', $agente['cod_admin'] );
				$this->__set('agente_nome', $agente['agente_nome'] );
				$this->__set('agente_apelido', $agente['agente_apelido'] );
				$this->__set('agente_cidade', $agente['agente_cidade'] );
				$this->__set('agente_bairro', $agente['agente_bairro'] );
				$this->__set('agente_quarteirao', $agente['agente_quarteirao'] );
				$this->__set('agente_casa', $agente['agente_casa'] );
				$this->__set('agente_nacionalidade', $agente['agente_nacionalidade'] );
				$this->__set('agente_sexo', $agente['agente_sexo'] );
				$this->__set('agente_nuit', $agente['agente_nuit'] );
			}	
			return $this;
		}

	}

?>