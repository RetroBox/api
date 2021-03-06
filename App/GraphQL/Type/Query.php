<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\ObjectType;

class Query extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                //games
                'getManyGames' => \App\GraphQL\Query\Game::getMany(),
                'getOneGame' => \App\GraphQL\Query\Game::getOne(),

                //game editor
                'getManyGameEditors' => \App\GraphQL\Query\GameEditor::getMany(),
                'getOneGameEditor' => \App\GraphQL\Query\GameEditor::getOne(),

                //game platform
                'getManyGamePlatforms' => \App\GraphQL\Query\GamePlatform::getMany(),
                'getOneGamePlatform' => \App\GraphQL\Query\GamePlatform::getOne(),

                //game media
                'getManyGameMedias' => \App\GraphQL\Query\GameMedia::getMany(),
                'getOneGameMedia' => \App\GraphQL\Query\GameMedia::getOne(),

                // game rom
                'getManyGameRoms' => \App\GraphQL\Query\GameRom::getMany(),
                'getOneGameRom' => \App\GraphQL\Query\GameRom::getOne(),

                //game tag
                'getManyGameTags' => \App\GraphQL\Query\GameTag::getMany(),
                'getOneGameTag' => \App\GraphQL\Query\GameTag::getOne(),

                //posts
                'getManyPosts' => \App\GraphQL\Query\Post::getMany(),
                'getOnePost' => \App\GraphQL\Query\Post::getOne(),

                //shop item
                'getManyShopItems' => \App\GraphQL\Query\ShopItem::getMany(),
                'getOneShopItem' => \App\GraphQL\Query\ShopItem::getOne(),

                //shop category
                'getManyShopCategories' => \App\GraphQL\Query\ShopCategory::getMany(),
                'getOneShopCategory' => \App\GraphQL\Query\ShopCategory::getOne(),

                //shop order
                'getManyShopOrders' => \App\GraphQL\Query\ShopOrder::getMany(),
                'getOneShopOrder' => \App\GraphQL\Query\ShopOrder::getOne(),

                //users
                'getManyUsers' => \App\GraphQL\Query\User::getMany(),
                'getOneUser' => \App\GraphQL\Query\User::getOne(),

                //console
                'getManyConsoles' => \App\GraphQL\Query\Console::getMany(),
                'getOneConsole' => \App\GraphQL\Query\Console::getOne(),
                'getConsoleVersions' => \App\GraphQL\Query\Console::getConsoleVersions(),
                'openConsoleTerminalSession' => \App\GraphQL\Query\Console::openConsoleTerminalSession(),

                //consoleImages
                'getManyConsoleImages' => \App\GraphQL\Query\ConsoleImage::getMany(),

                //country
                'getCountries' => \App\GraphQL\Query\Countries::getMany()
            ]
        ];

        parent::__construct($config);
    }
}
