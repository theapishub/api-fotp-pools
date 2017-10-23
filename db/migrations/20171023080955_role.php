<?php


use Phinx\Migration\AbstractMigration;

class Role extends AbstractMigration
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
        $role = $this->table('role', ['id'=> false, 'primary_key' => ['role_id']]);
        $role
            ->addColumn('role_id', 'integer',['identity' =>true])
            ->addColumn('status','integer',['null' => false])
            ->addColumn('role_message', 'string')
            ->addIndex(['status', 'role_id'], ['unique' => true])
            ->create();
    }
}
