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
	 * @param string type
	 * @param string body
	 * @param int idUser
	**/
	public static function addPost($type, $body, $idUser)
	{
		$body = trim($body);

		if(!empty($idUser) && !empty($body)){

			Post::insert([
				'type' => $type,
				'created_at' => date('Y-m-d H:i:s'),
				'body' => $body,
				'id_user' => $idUser
			])->execute();
		}
	}

	public function getHomeFeed($idUser)
    {
    	//1 pegar lista de usuários que eu sigo
        $userList = UserRelation::select()->where('user_from', $idUser)->get();

        $users = [];

        foreach($userList as $userItem){
            $users[] = $userItem['user_to'];
        }

        $users[] = $idUser;//adicionando meu usuario

        //2 pegar posts da lista de usuarios que sigo ordenado pela data
        $postsList = Post::select()
	        ->where('id_user','in', $users)
	        ->orderBy('created_at', 'desc')
        ->get();

        //3. transformar resultados de post e users em objetos de seus models
        $posts = [];

        foreach($postsList as $postItem){
        	
        	$newPost = new Post();

        	$newPost->id = $postItem['id'];
        	$newPost->type = $postItem['type'];
        	$newPost->created_at = $postItem['created_at'];
        	$newPost->body = $postItem['body'];
        	$newPost->id_user = $postItem['id_user'];

        	//4 preencher informaçoes adicionais no post como avatar nome etc..
        	$newUser = User::select()->where('id', $postItem['id_user'])->one();
        	
        	$newPost->user = new User();
        	$newPost->user->id = $newUser['id'];
        	$newPost->user->name = $newUser['name'];
        	$newPost->user->avatar = $newUser['avatar'];

        	$posts[] = $newPost;
        }
        //5 retornar o resultado
        return $posts;
    }
}