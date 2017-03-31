<?php

namespace AccountBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function __construct() 
    {
        $this->client = static::createClient();
    }

    public function testLogin() 
    {
       
        $this->client->request('GET', '/login');
        $status_code = $this->client->getResponse()->getStatusCode();       

        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('app_login', $requestAttributs->get('_route'));
        $this->assertEquals('AccountBundle\Controller\SecurityController::loginAction', $requestAttributs->get('_controller'));
    }

    public function testLogout()
    {

        $this->client->request('GET', '/logout');
        $status_code = $this->client->getResponse()->getStatusCode();       

        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('app_logout', $requestAttributs->get('_route'));
        //$this->assertEquals('AccountBundle\Controller\SecurityController::logoutAction', $requestAttributs->get('_controller'));       
    }

    public function testRegister()
    {

        $this->client->request('GET', '/register');
        $status_code = $this->client->getResponse()->getStatusCode();       

        $requestAttributs = $this->client->getRequest()->attributes;
        $this->assertEquals('app_register', $requestAttributs->get('_route'));
        $this->assertEquals('AccountBundle\Controller\SecurityController::registerAction', $requestAttributs->get('_controller'));       
    }

}