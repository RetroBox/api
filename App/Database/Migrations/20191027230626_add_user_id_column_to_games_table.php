<?php


use Phinx\Migration\AbstractMigration;

class AddUserIdColumnToGamesTable extends AbstractMigration
{
    public function change()
    {
        $this->table('games')
            ->addColumn('user_id','string', ['null' => true]) // this field will be filled if the game come from a user import (private game library)
            ->update();
    }
}
