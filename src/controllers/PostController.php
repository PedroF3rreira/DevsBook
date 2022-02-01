<?php
namespace src\controllers;

use \core\Controller;
use \src\handles\UserHandler;
use \src\handles\PostHandler;

class PostController extends Controller {

    private $loggedUser;

    public function __construct()
    {
        $this->loggedUser = UserHandler::checkLogin();
        
        if(!$this->loggedUser){
            $this->redirect('/login');
        }
    }

    public function new() {
        $body = filter_input(INPUT_POST, 'body');
        $type = 'text';

        if(!empty($body)){
            PostHandler::addPost(
                $type,
                $body,
                $this->loggedUser->id
            );

            $this->redirect('/');
        }
    }
}