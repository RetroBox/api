<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class User extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'User',
            'description' => 'A user account',
            'fields' => [
                'id' => [
                    'type' => Type::string(),
                    'description' => 'The user STAIL.EU uuid'
                ],
                'first_name' => [
                    'type' => Type::string()
                ],
                'last_name' => [
                    'type' => Type::string()
                ],
                'last_locale' => [
                    'type' => Type::string()
                ],
                'address_first_line' => [
                    'type' => Type::string()
                ],
                'address_second_line' => [
                    'type' => Type::string()
                ],
                'address_postal_code' => [
                    'type' => Type::string()
                ],
                'address_city' => [
                    'type' => Type::string()
                ],
                'address_country' => [
                    'type' => Type::string()
                ],
                'last_username' => [
                    'type' => Type::string()
                ],
                'last_email' => [
                    'type' => Type::string()
                ],
                'last_avatar' => [
                    'type' => Type::string()
                ],
                'last_ip' => [
                    'type' => Type::string()
                ],
                'last_user_agent' => [
                    'type' => Type::string()
                ],
                'last_login_at' => [
                    'type' => Types::dateTime()
                ],
                'is_admin' => [
                    'type' => Type::boolean()
                ],
                'created_at' => [
                    'type' => Types::dateTime()
                ],
                'updated_at' => [
                    'type' => Types::dateTime()
                ]
            ]
        ];

        parent::__construct($config);
    }
}