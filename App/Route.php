<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {
		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);
		

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$routes['buscar_contador'] = array(
			'route' => '/buscar_contador',
			'controller' => 'AppController',
			'action' => 'buscarContador'
		);

		$routes['registrar_leitura'] = array(
			'route' => '/registrar_leitura',
			'controller' => 'AppController',
			'action' => 'registrarLeitura'
		);

		$routes['inserir_leitura'] = array(
			'route' => '/inserir_leitura',
			'controller' => 'AppController',
			'action' => 'inserirLeitura'
		);
		


		$routes['efectuar_pagamento'] = array(
			'route' => '/efectuar_pagamento',
			'controller' => 'AppController',
			'action' => 'efectuarPagamento'
		);

		$routes['abrir_contrato'] = array(
			'route' => '/abrir_contrato',
			'controller' => 'AppController',
			'action' => 'abrirContrato'
		);
		$routes['registrar_contrato'] = array(
			'route' => '/registrar_contrato',
			'controller' => 'AppController',
			'action' => 'registrarContrato'
		);
		
		$routes['pesquisar_cliente'] = array(
			'route' => '/pesquisar_cliente',
			'controller' => 'AppController',
			'action' => 'pesquisarCliente'
		);

		$routes['pesquisar_clienteal'] = array(
			'route' => '/pesquisar_clienteal',
			'controller' => 'AppController',
			'action' => 'pesquisarCliente2'
		);

		$routes['registrar_contador'] = array(
			'route' => '/registrar_contador',
			'controller' => 'AppController',
			'action' => 'registrarContador'
		);

		

		$routes['abrir_contrato'] = array(
			'route' => '/abrir_contrato',
			'controller' => 'AppController',
			'action' => 'abrirContrato'
		);


		$routes['cadastrar_cliente'] = array(
			'route' => '/cadastrar_cliente',
			'controller' => 'AppController',
			'action' => 'cadastrarCliente'
		);

		$routes['inserir_cliente'] = array(
			'route' => '/inserir_cliente',
			'controller' => 'AppController',
			'action' => 'inserirCliente'
		);

		$routes['actualizar_dados'] = array(
			'route' => '/actualizar_dados',
			'controller' => 'AppController',
			'action' => 'actualizarDados'
		);

		$routes['buscar_cliente'] = array(
			'route' => '/buscar_cliente',
			'controller' => 'AppController',
			'action' => 'buscarCliente'
		);


		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);

		$this->setRoutes($routes);
	}

}

?>