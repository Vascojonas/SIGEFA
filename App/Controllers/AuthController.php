<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

Class AuthController extends Action {

	public function autenticar(){

		$usuario = Container::getModel('Usuario');

		$usuario-> __set('username', $_POST['username']);
		$usuario-> __set('senha', $_POST['senha']);

		$usuario->autenticar();

		if($usuario->__get('id_usuario')!=''&& $usuario->__get('nivel_acesso')!=''){
			
			session_start();
			$_SESSION['id_usuario']= $usuario->__get('id_usuario');
			$_SESSION['nivel_acesso']=$usuario->__get('nivel_acesso');

			if($usuario->__get('nivel_acesso')=='2'){

				$agente =Container::getModel('Agente');

				
			
				//$_SESSION['nome']= $usuario->__get('agente_nome').' '.$usuario->__get('agente_apelido');

				//echo $nome;
				$agente->getDadosById();
				$_SESSION['nome']= $agente->__get('agente_nome').' '.$agente->__get('agente_apelido');

				header("location:/registrar_leitura");
			}

		}else{
			header("location:/?login=erro");
		}

	}

	public function sair(){
		session_start();
		session_destroy();

		header("Location:/");

	}
}

?>