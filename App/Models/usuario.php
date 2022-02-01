<?php

	namespace App\Models;

	use MF\Model\Model;

	Class Usuario extends Model{
		private $id_usuario;
		private $username;
		private $senha;
		private $nivel_acesso;


		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		public function autenticar(){

			$query="SELECT id_usuario,nivel_acesso from usuarios WHERE username=:username and senha= :senha";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':username', $this->__get('username'));
			$stmt->bindValue(':senha', $this->__get('senha'));
	
			$stmt->execute();

			$usuario = $stmt->fetch(\PDO::FETCH_ASSOC); //se nao tiver registro returna false se tiver true;
			
			if($usuario){
				$this->__set('id_usuario', $usuario['id_usuario']);
				$this->__set('nivel_acesso', $usuario['nivel_acesso']);
			}

			return $this;
		}

		public function salvar(){
			$query= "insert into usuarios(username,senha,nivel_acesso) values(:username,:senha,:nivel_acesso)";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':username', $this->__get('username'));
			$stmt->bindValue(':senha', $this->__get('senha'));
			$stmt->bindValue(':nivel_acesso', $this->__get('nivel_acesso'));
			$stmt->execute();
		}
		
		public function getUserByUsername(){
			$query="select * from usuarios where username = :username";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':username', $this->__get('username'));
			$stmt->execute();

			$usuario=$stmt->fetch(\PDO::FETCH_ASSOC);
			if($usuario){
				$this->__set('id_usuario', $usuario['id_usuario']);
				$this->__set('username', $usuario['username']);
				$this->__set('senha', $usuario['senha']);
				$this->__set('nivel_acesso', $usuario['nivel_acesso']);
			}

			return $this;
		}


		public function existe(){
			$controle =false;

			$query="select * from usuarios where username = :username";
			$stmt= $this->db->prepare($query);
			$stmt->bindValue(':username', $this->__get('username'));
			$stmt->execute();

			if($stmt->fetch(\PDO::FETCH_ASSOC)){
				$controle=true;
			}

			return $controle;
		}

	}
	
?>