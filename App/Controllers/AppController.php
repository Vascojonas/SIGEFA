<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

Class AppController extends Action {

	public function registrarLeitura(){
		session_start();

		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
			$this->view->numeroContador='';
			$this->render('registrar_leitura');
		}else{
			header("Location:/?login=erro");
		}
	}

	public function inserirLeitura(){
		session_start();

		$leitura = Container::getModel('Leitura');
		$factura = Container::getModel('Factura');

		$leitura->__set('numero_contador', $_POST['contador']);
		$leitura->__set('leitura_actual', $_POST['leitura']);
		$leitura->__set('cod_agente', $_SESSION['id_usuario']);

		$leitura->registrarLeitura($_POST['contador']);
		$this->view->leituraInserida=true;

		$resultado=$leitura->ultimaLeitura($_POST['contador']);

		$factura->__set('cod_leitura',$resultado['leitura_cod']);
		$factura->salvar();

		$this->render('sucesso_registro');


	}


	public function efectuarPagamento(){
		session_start();

		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
			$this->render('efectuar_pagamento');
		}else{
			header("Location:/?login=erro");
		}
	}

	public function abrirContrato(){

		session_start();

		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {

			$this->view->contadorInvalido=false;
			$this->view->pesquisa="";
			$this->render('abrir_contrato');
		}else{
			header("Location:/?login=erro");
		}

	}

	public function registar(){
		echo 'Chegamos aqui';
	}


	public function registrarContrato(){

		session_start();
		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {

			$contrato = Container::getModel('Contrato');

			
			$contrato->__set('numero_contador', $_POST['numero_contador']);
			$contrato->__set('cod_cliente', $_POST['cliente']);
			$contrato->__set('contrato_tipo', $_POST['contrato_tipo']);

			$contrato->salvar();
			$c = $contrato->recuperar();
			
			$endereco = Container::getModel('endereco');
			

			$endereco->__set('id_contrato',$c['contrato_cod']);
			$endereco->__set('endereco_bairro',$_POST['bairro']);
			$endereco->__set('endereco_quarteirao',$_POST['quarteirao']);
			$endereco->__set('endereco_casa',$_POST['casa']);
			

			$endereco->salvar();
		
			$this->view->contadorInvalido=false;
			$this->view->pesquisa="";
			$this->view->sucesso=true;
			$this->render('abrir_contrato');
		}else{
			header("Location:/?login=erro");
		}
	}

	public function pesquisarCliente(){
		session_start();
		if ($_SESSION['id_usuario']!='' && $_SESSION['nivel_acesso']!='') {
			$cliente =Container::getModel('Cliente');

			if(isset($_POST['pesquisar'])){

				$clientes=$cliente->getAllClientes($_POST['pesquisar']); 
				$this->view->clientes=$clientes;
				
				$this->view->pesquisa= $_POST['pesquisar'];
				$this->view->showcont=true;


				$this->render('abrir_contrato');	
			}
			
		}else{
			header("Location:/?login=erro");
		}

	}

	public function pesquisarCliente2(){
		session_start();
		if ($_SESSION['id_usuario']!='' && $_SESSION['nivel_acesso']!='') {
			$cliente =Container::getModel('Cliente');

			if(isset($_POST['pesquisar'])){

				$clientes=$cliente->getAllClientes($_POST['pesquisar']); 
				$this->view->clientes=$clientes;
				
				$this->view->pesquisa= $_POST['pesquisar'];
				$this->view->showcont=true;

				$this->render('actualizar_dados');	
			}
			
		}else{
			header("Location:/?login=erro");
		}

	}

	public function registrarContador(){
		session_start();
		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
			
			$contador = Container::getModel('Contador');


			if ($contador->valido($_POST['contador'])) {
				if (isset($_POST['contador'])) {
				$contador->__set('contador_numero', $_POST['contador']);

				if ($contador->validarRegistro()) {
					$contador->salvar();

					$this->view->registroSucesso=true;
					$this->view->contadorInvalido=false;
					$this->view->contador =$_POST['contador'];
					$this->view->showcont=true;

					$this->view->contrato = array(
						'numero_contador'=> $_POST['contador']
					);

					$this->view->pesquisa="";
					$this->render('abrir_contrato');
				}else{

					$this->view->contadorInvalido=true;
					$this->view->registroSucesso=false;
					$this->view->contador=$_POST['contador'];
					$this->view->pesquisa="";
					$this->render('abrir_contrato');
				}
		
				
			}
			}else{
				

				$this->view->registroSucesso=false;
				$this->view->contador=$_POST['contador'];
				$this->view->pesquisa="";
				
				if($_POST['pesquisar']!=''){
					if ($_SESSION['id_usuario']!='' && $_SESSION['nivel_acesso']!='') {
					$cliente =Container::getModel('Cliente');


					$clientes=$cliente->getAllClientes($_POST['pesquisar']); 
					$this->view->clientes=$clientes;
				
							$this->view->pesquisa= $_POST['pesquisar'];
						$this->view->showcont=true;


						$this->render('abrir_contrato');	
					}
				}

				$this->render('abrir_contrato');


			}

			

			
		}else{
			header("Location:/?login=erro");
		}

		
	}


	public function buscarContador(){

		session_start();

		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {

			$contador = Container::getModel('Contador');
			$contrato= Container::getModel('Contrato');

			$contador->__set('contador_numero',$_POST['numero']);

		

			if ($c=$contador->recuperar()) {

				$cliente= $contrato->getClienteByContador($_POST['numero']);
				


				$this->view->dados= $cliente;
			
				$this->view->contadorExiste=true;
				$this->view->numeroContador=$_POST['numero'];
	
			}else{
				$this->view->contadorExiste=false;
				$this->view->numeroContador=$_POST['numero'];
			}

			$this->render('registrar_leitura');
		}else{
			header("Location:/?login=erro");
		}

	}

	

	public function cadastrarCliente(){
		session_start();
		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
			
			$this->view->userExist=false;
			$this->view->dadosInvalidos=false;
			$this->view->cliente =array(
			    'nome' => '',
				'apelido' =>'' ,
				'cidade' =>'' ,
				'bairro' =>'' ,
				'quarteirao' =>'', 
			    'casa' => '' ,
				'nacionalidade' =>'', 
				'nuit' =>'' ,
				'username' =>'' ,
				'senha' => '' ,
				'tel1' => '' ,
				'tel2' =>'' ,
				'sexo' =>'' 
			);

			$this->render('cadastrar_cliente');
		}else{
			header("Location:/?login=erro");
		}
	}

	public function	inserirCliente(){
		session_start();
		$usuario = Container::getModel('Usuario');
		$cliente =Container::getModel('Cliente');
		$telefone=Container::getModel('Telefone');

		//inserir usuario
		$usuario->__set('username', $_POST['username']);
		$usuario->__set('senha', $_POST['senha']);
		$usuario->__set('nivel_acesso','1');

			$cliente->__set('cod_agente',$_SESSION['id_usuario']);
			$cliente->__set('cliente_nome',$_POST['nome']);
			$cliente->__set('cliente_apelido',$_POST['apelido']);
			$cliente->__set('cliente_cidade',$_POST['cidade']);
			$cliente->__set('cliente_bairro',$_POST['bairro']);
			$cliente->__set('cliente_quarteirao',$_POST['quarteirao']);
			$cliente->__set('cliente_casa',$_POST['casa']);
			$cliente->__set('cliente_nacionalidade',$_POST['nacionalidade']);
			


			$cliente->__set('cliente_sexo',$_POST['sexo']);
			$cliente->__set('cliente_nuit',$_POST['nuit']);

			$telefone->__set('telefone1', $_POST['tel1']);
			$telefone->__set('telefone2', $_POST['tel2']);
		
		if($usuario->existe()){
				$this->view->userExist=true;
				$this->view->cliente =array(
				    'nome' => $_POST['nome'],
					'apelido' =>$_POST['apelido'] ,
					'cidade' =>$_POST['cidade'] ,
					'bairro' =>$_POST['bairro'] ,
					'quarteirao' =>$_POST['quarteirao'], 
				    'casa' => $_POST['casa'],
					'nacionalidade' =>$_POST['nacionalidade'], 
					'nuit' =>$_POST['nuit'] ,
					'username' =>$_POST['username'] ,
					'senha' => $_POST['senha'] ,
					'tel1' => $_POST['tel1'] ,
					'tel2' => $_POST['tel2'] ,
					 'sexo' =>$_POST['sexo'] 
				);

			
				if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
				
				   $this->render('cadastrar_cliente');
				}

			} else {
					if (!$cliente->dadosValidos()){
						$this->view->dadosInvalidos=true;
						
						$this->view->cliente =array(
						    'nome' => $_POST['nome'],
						'apelido' =>$_POST['apelido'] ,
						'cidade' =>$_POST['cidade'] ,
						'bairro' =>$_POST['bairro'] ,
						'quarteirao' =>$_POST['quarteirao'], 
					    'casa' => $_POST['casa'],
						'nacionalidade' =>$_POST['nacionalidade'], 
						'nuit' =>$_POST['nuit'] ,
						'username' =>$_POST['username'] ,
						'senha' => $_POST['senha'] ,
						'tel1' => $_POST['tel1'] ,
						'tel2' => $_POST['tel2'] ,
						'sexo' =>$_POST['sexo'] 
							);

						if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
					
							$this->render('cadastrar_cliente');
						}

					} else{
					$usuario->salvar();
					$usuario->getUserByUsername();
					$cliente->__set('cliente_cod',$usuario->__get('id_usuario'));

					$cliente->salvar();

					$telefone->__set('cod_cliente', $cliente->__get('cliente_cod'));

					$telefone->salvar();
					
					$this->view->sucessoCadastro=true;
					$this->view->cliente =array(
							    'nome' => '',
								'apelido' =>'' ,
								'cidade' =>'' ,
								'bairro' =>'' ,
								'quarteirao' =>'', 
							    'casa' => '' ,
								'nacionalidade' =>'', 
								'nuit' =>'' ,
								'username' =>'' ,
								'senha' => '' ,
								'tel1' => '' ,
								'tel2' =>'' ,
								 'sexo' =>'--Selecionar--' 
							);

					$this->render('cadastrar_cliente');

			}
		}
	}
		

	
	public function buscarCliente(){

		$clientes= Container::getModel('Cliente');
		$factura= Container::getModel('Factura');

		$resultado= $clientes->recuperarAllClientes($_POST['pesquisa']);

		$f=$factura->facturasNaoPagas($resultado['0']['numero_contador']);

		$this->view->resultado=$resultado;
		$this->view->facturas=$f;

		$this->render('efectuar_pagamento');

	}



	public function actualizarDados(){
		session_start();

		if ($_SESSION['id_usuario']!=''&& $_SESSION['nivel_acesso']!='') {
			$this->render('actualizar_dados');
		}else{
			header("Location:/?login=erro");
		}
	}

}
?>