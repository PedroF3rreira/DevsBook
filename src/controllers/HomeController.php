<?php
namespace src\controllers;

use \core\Controller;
use \src\handles\LoginHandler;

class HomeController extends Controller {

    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = LoginHandler::checkLogin();
        
        if(!$this->loggedUser){
            $this->redirect('/login');
        }
    }

    public function index() {
        $this->render('home', ['loggedUser' => $this->loggedUser]);
    }
}