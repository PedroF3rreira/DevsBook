<?php
namespace src\controllers;

use \core\Controller;
use \src\handles\UserHandler;
use \src\handles\PostHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = UserHandler::checkLogin();
        
        if(!$this->loggedUser){
            $this->redirect('/login');
        }
    }

    public function index($args = []) {

        $id = $this->loggedUser->id;

        if(!empty($args)){
            $id = $args['id'];
        }
        
        $page = intVal(filter_input(INPUT_GET, 'page'));
        //pega feed da pagina home
        $feed = PostHandler::getHomeFeed($this->loggedUser->id, $page);

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'feed' => $feed
        ]);
    }
}