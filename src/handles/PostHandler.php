<?php 
namespace src\handles;

use \src\models\Post;
use \src\models\UserRelation;
use \src\models\User;
/**
 *classe responsavel por manipular Post no banco de dados 
 **/
class PostHandler
{
	/**
	 * Método adiciona post na tabela posts
	 * @access public
	 * @param string $type
	 * @param string $body
	 * @param int $idUser
	**/
	public static function addPost($type, $body, $idUser)
	{
		try {

			$body = trim($body);

			if(!empty($idUser) && !empty($body)){

				Post::insert([
					'type' => $type,
					'created_at' => date('Y-m-d H:i:s'),
					'body' => $body,
					'id_user' => $idUser
				])->execute();
			}

			return true;
			
		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * processa dados do feed e cuida da paginação
	 * @param int $idUser
	 * @param string $page
	 * @return array
	 * **/

	public function getHomeFeed($idUser, $page)
    {
    	$pagePer = 3;//define quantidade de post que podem aparecer na página

    	//1 pegar lista de usuários que eu sigo
        $userList = UserRelation::select()->where('user_from', $idUser)->get();

        $users = [];

        foreach($userList as $userItem){
            $users[] = $userItem['user_to'];//recebe cada usuário que segue quem esta logado 
        }

        $users[] = $idUser;//adicionando meu usuário

        //2 pegar posts da lista de usuários que sigo ordenado pela data
        $postsList = Post::select()
	        ->where('id_user','in', $users)
	        ->orderBy('created_at', 'desc')
	        ->page($page,$pagePer)//recebe página atual e quantidade de registros
        ->get();

        /**
         * Pega o total de registros dos posts 
         * e divide resultado pela quantidade de poste que queremos exibir 
         * na tela inicial
         * */
         $total = Post::select()
	        ->where('id_user','in', $users)
        ->count();

        $pageCount = ceil($total / $pagePer);//usa função ceil para arredondar para cima

        //3. transformar resultados de post e users em objetos de seus models
        //ubido informações dos posts e seus usuários
        $posts = [];

        foreach($postsList as $postItem){
        	
        	$newPost = new Post();

        	$newPost->id = $postItem['id'];
        	$newPost->type = $postItem['type'];
        	$newPost->created_at = $postItem['created_at'];
        	$newPost->body = $postItem['body'];
        	$newPost->id_user = $postItem['id_user'];
        	$newPost->mine = false;

        	if($postItem['id_user'] == $idUser){
        		$newPost->mine = true;
        	}
        	//4 preencher informaçoes adicionais no post como avatar nome etc..
        	$newUser = User::select()->where('id', $postItem['id_user'])->one();
        	
        	//como se fosse configuração chave estrangeira en dotnet em um model
        	$newPost->user = new User();
        	$newPost->user->id = $newUser['id'];
        	$newPost->user->name = $newUser['name'];
        	$newPost->user->avatar = $newUser['avatar'];

        	$newPost->likesCount = 0;
        	$newPost->liked = false;

        	$newPost->commentsCount = [];

        	$posts[] = $newPost;
        }
        
        //5 retornar o resultado
        return [
        	'posts' => $posts,
        	'pageCount' => $pageCount,//envia quantidade de paginas para home
        	'currentPage' => $page//envia a pagina atual que uauario esta
        ];
    }
}