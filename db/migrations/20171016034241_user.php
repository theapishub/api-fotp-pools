<?php


use Phinx\Migration\AbstractMigration;

class User extends AbstractMigration
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
        $users = $this->table('users',['id' => false, 'primary_key' => ['user_id']]);
        $users->addColumn('user_id', 'integer', ['identity' =>true])
            ->addColumn('username', 'string', ['limit' => 20])
            ->addColumn('password', 'string', ['limit' => 100])
            ->addColumn('password_salt', 'string', ['limit' => 100])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('fullname', 'string', ['limit' => 60])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime', ['null' => true])
            ->addIndex(['user_id', 'username', 'email'], ['unique' => true])
            ->create();
    }
}
