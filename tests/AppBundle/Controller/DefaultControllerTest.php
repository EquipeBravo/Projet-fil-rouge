<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{

	public function __construct() 
	{
		$this->client = static::createClient();
	}

    public function testIndex()
    {
        $this->client->request('GET', '/');
        $status_code = $this->client->getResponse()->getStatusCode();
        
        // vérifie qu'il n'y a pas une 404
        $this->assertEquals(200, $status_code);
        $requestAttributs = $this->client->getRequest()->attributes;

        // vérifie le controller
        $this->assertEquals('AppBundle\Controller\DefaultController::indexAction', $requestAttributs->get('_controller'));

        // vérifie la route
        $this->assertEquals('app_homepage', $requestAttributs->get('_route'));

        // vérifie les paramètres
		  //   ["_route_params"]=>
		  //   array(0) {
		  //   }
    }

    public function testApropos() 
    {
       
        $this->client->request('GET', '/a-propos');
        $status_code = $this->client->getResponse()->getStatusCode();   	

        $this->assertEquals(200, $status_code);
        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('AppBundle\Controller\DefaultController::aproposAction', $requestAttributs->get('_controller'));

        $this->assertEquals('app_apropos', $requestAttributs->get('_route'));
    }

    public function testContact()
    {
        $this->client->request('GET', '/contact');
        $status_code = $this->client->getResponse()->getStatusCode();   	

        $this->assertEquals(200, $status_code);
        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('AppBundle\Controller\DefaultController::contactAction', $requestAttributs->get('_controller'));

        $this->assertEquals('app_contact', $requestAttributs->get('_route'));   	
    }

    public function testInscription()
    {
        $this->client->request('GET', '/inscription');
        $status_code = $this->client->getResponse()->getStatusCode();   	

        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('AppBundle\Controller\DefaultController::inscriptionAction', $requestAttributs->get('_controller'));

        $this->assertEquals('app_inscription', $requestAttributs->get('_route'));   	
    }

    public function testSearch()
    {
        $this->client->request('POST', '/search', ["searchForm" => "test"]);
        $status_code = $this->client->getResponse()->getStatusCode();   	
        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('AppBundle\Controller\DefaultController::searchAction', $requestAttributs->get('_controller'));

        $this->assertEquals('app_search', $requestAttributs->get('_route'));   	
    }

}
