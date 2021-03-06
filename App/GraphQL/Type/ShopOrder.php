<?php

namespace App\GraphQL\Type;

use App\GraphQL\Types;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class ShopOrder extends ObjectType
{
    public function __construct($depth = false)
    {
        if ($depth) {
            $depthArray = [
                'items' => [
                    'type' => Type::listOf(Types::shopItemWithDepth())
                ],
                'items_count' => [
                    'type' => Type::int()
                ]
            ];
            $name = "ShopOrderWithDepth";
        } else {
            $name = "ShopOrder";
            $depthArray = [];
        }
        $config = [
            'name' => $name,
            'description' => "A user's order",
            'fields' => array_merge([
                'id' => [
                    'type' => Type::id()
                ],
                'user' => [
                    'type' => Types::user()
                ],
                'shipping_method' => [
                    'type' => Type::string()
                ],
                'shipping_address' => [
                    'type' => Types::shippingAddress()
                ],
                'shipping_id' => [
                    'type' => Type::string()
                ],
                'on_way_id' => [
                    'type' => Type::string()
                ],
                'total_price' => [
                    'type' => Type::float()
                ],
                'sub_total_price' => [
                    'type' => Type::float()
                ],
                'total_shipping_price' => [
                    'type' => Type::float()
                ],
                'status' => [
                    'type' => Type::string()
                ],
                'way' => [
                    'type' => Type::string()
                ],
                'bill_url' => [
                    'type' => Types::url()
                ],
                'note' => [
                    'type' => Type::string(),
                    'description' => "A message left by customer at checkout to specify instructions to the order agent (or preparator)"
                ],
                'created_at' => [
                    'type' => Types::dateTime()
                ],
                'updated_at' => [
                    'type' => Types::dateTime()
                ]
            ], $depthArray)
        ];

        parent::__construct($config);
    }
}
