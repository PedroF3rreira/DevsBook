<?php
namespace src\controllers;

use \core\Controller;
use \src\handles\LoginHandler;
use \src\handles\PostHandler;

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

        //pega feed da pagina home
        $feed = PostHandler::getHomeFeed($this->loggedUser->id);

        $this->render('home', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed
        ]);
    }
}