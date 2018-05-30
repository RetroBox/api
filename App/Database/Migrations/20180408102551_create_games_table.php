<?php


use Phinx\Migration\AbstractMigration;

class CreateGamesTable extends AbstractMigration
{
	/**
	 * Change Method.
	 *
	 * Write your reversible migrations using this method.
	 *
	 * More information on writing migrations is available here:
	 * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
	 *
	 * The following commands can be used in this method and Phinx will
	 * automatically reverse them when rolling back:
	 *
	 *    createTable
	 *    renameTable
	 *    addColumn
	 *    renameColumn
	 *    addIndex
	 *    addForeignKey
	 *
	 * Remember to call "create()" or "update()" and NOT "save()" when working
	 * with the Table class.
	 */
	public function change()
	{
		//has many medias
		//has many genres
		//belongs to editor
		//belongs to platform
		$this->table('games')
			->addColumn('name', 'string')
			->addColumn('esrb_level', 'string', ['null' => true])
			//available language of the game
			->addColumn('locale', 'string', ['null' => true])
			//number of players
			->addColumn('players', 'integer', ['null' => true])
			->addColumn('thegamesdb_rating', 'float', ['null' => true])
			->addColumn('description', 'text', ['null' => true])
			->addColumn('editor_id', 'string', ['null' => true])
			->addColumn('platform_id', 'string', ['null' => true])
			->addColumn("released_at", 'datetime', ['null' => true])
			->addColumn("created_at", 'datetime', ['null' => true])
			->addColumn("updated_at", 'datetime', ['null' => true])
			->create();

		$this->table('games')
			->changeColumn('id', 'string')
			->update();
	}
}
