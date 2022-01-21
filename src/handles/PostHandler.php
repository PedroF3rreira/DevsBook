<?php 
namespace src\handles;

use \src\models\Post;
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
}