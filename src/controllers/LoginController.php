<?php
namespace src\controllers;

use \core\Controller;
use \src\handles\LoginHandler;

class LoginController extends Controller {

    //renderiza a page singin
    public function singin() {

        $flash = '';

        if(!empty($_SESSION['flash'])){

            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('singin',[
            'flash' => $flash
        ]);
    }

    /*
     * recebe dados do formulario de login 
     * e chame método para verificar se usuario
     * e senha estão batem
    */
    public function singinAction() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password){
           $token = LoginHandler::verifyLogin($email, $password);

           if($token){
                $_SESSION['token'] = $token;
                $this->redirect('/');
           }
           else{
                $_SESSION['flash'] = 'Email ou senha não conferem';
                $this->redirect('/login');
           }

        }
        else{
            $_SESSION['flash'] = 'Digite os campos de email e/ou senha';
            $this->redirect('/login');
        }
    }

    /*cadastro do sistema*/
    public function singup()
    {
         $flash = '';

        if(!empty($_SESSION['flash'])){

            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('singup',[
            'flash' => $flash
        ]);   
    }

    public function singupAction()
    {
         $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
         $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
         $password = filter_input(INPUT_POST, 'password');
         $birthdate = filter_input(INPUT_POST, 'birthdate');

         if($name && $email && $password && $birthdate){

            $birthdate = explode('/', $birthdate);

            if(count($birthdate) !== 3){
                $_SESSION['flash'] = 'data de nascimento invalida!';
                $this->redirect('/cadastro');
            }
            
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];

            if(!strtotime($birthdate)){
                $_SESSION['flash'] = 'data de nascimento invalida!';
                $this->redirect('/cadastro');
            }
             //verifica se email já existe
            if(!LoginHandler::emailExists($email)){
                $token = LoginHandler::addUser($name, $email, $password, $birthdate);
                $_SESSION['token'] = $token;
                $this->redirect('/');
            }
            else{
                $_SESSION['flash'] = 'Email já existe';
                $this->redirect('/cadastro');
            }
         }
         else{
            $_SESSION['flash'] = 'dados vazios preencha todos os dados';
            $this->redirect('/cadastro');
         }

    }
}