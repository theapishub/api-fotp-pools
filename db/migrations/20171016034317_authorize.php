<?php


use Phinx\Migration\AbstractMigration;

class Authorize extends AbstractMigration
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
        $session = $this->table('authorize', ['id'=> false, 'primary_key' => ['authorize_id']]);
        $session
            ->addColumn('authorize_id', 'integer',['identity' =>true])
            ->addColumn('user_id', 'integer')
            ->addColumn('authorize_key', 'string')
            ->addColumn('refresh_key', 'string')
            ->addColumn('key_expire', 'string')
            ->addIndex(['authorize_key', 'refresh_key'], ['unique' => true])
            ->addForeignKey('user_id', 'users', 'user_id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
            ->create();
    }
}
