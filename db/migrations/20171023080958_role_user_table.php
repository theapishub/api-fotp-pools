<?php


use Phinx\Migration\AbstractMigration;

class RoleUserTable extends AbstractMigration
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
        $users = $this->table('role_users',['id' => false, 'primary_key' => ['role_user_id']]);
        $users->addColumn('role_user_id', 'integer', ['identity' =>true])
            ->addColumn('user_id', 'integer')
            ->addColumn('role_id', 'integer')
            ->addIndex(['user_id','role_id'], ['unique' => true])
            ->addForeignKey('user_id', 'users', 'user_id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
            ->addForeignKey('role_id', 'role', 'role_id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
            ->create();
    }
}
