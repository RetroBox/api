<?php

namespace App\GraphQL\Query;

use App\GraphQL\Types;
use Exception;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class Post
{
	public static function getMany()
	{
		return [
			'type' => Type::listOf(Types::post()),
			'description' => 'Get many posts',
			'args' => [
				[
					'name' => 'limit',
					'description' => 'Number of items to get',
					'type' => Type::int(),
					'defaultValue' => -1
				],
				[
					'name' => 'orderBy',
					'description' => 'Order by a field',
					'type' => Type::string(),
					'defaultValue' => 'created_at'
				],
				[
					'name' => 'orderDir',
					'description' => 'Direction of the order',
					'type' => Type::string(),
					'defaultValue' => 'desc'
				]
			],
			'resolve' => function ($_, $args) {
				return \App\Models\Post::query()
					->limit($args['limit'])
					->orderBy($args['orderBy'], strtolower($args['orderDir']))
					->get();
			}
		];
	}

	public static function getOne()
	{
		return [
			'type' => Types::post(),
			'description' => 'Get a post by id',
			'args' => [
				[
					'name' => 'id',
					'description' => 'The Id of the post',
					'type' => Type::string()
				]
			],
			'resolve' => function ($_, $args) {
				$post = \App\Models\Post::query()->find($args['id']);
				if ($post == NULL){
                    return new Exception("Post not found", 404);
				}else{
					return $post
						->first();
				}
			}
		];
	}

	public static function store()
	{
		return [
			'type' => Types::post(),
			'args' => [
				[
					'name' => 'post',
					'description' => 'Post to store',
					'type' => new InputObjectType([
						'name' => 'PostInput',
						'fields' => [
							'name' => ['type' => Type::nonNull(Type::string())],
							'description' => ['type' => Type::nonNull(Type::string())],
							'content' => ['type' => Type::nonNull(Type::string())],
							'image' => ['type' => Type::nonNull(Type::string())]
						]
					])
				]
			],
			'resolve' => function () {
				return [];
			}
		];
	}
}