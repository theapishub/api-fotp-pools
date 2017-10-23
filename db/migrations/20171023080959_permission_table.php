<?php


use Phinx\Migration\AbstractMigration;

class PermissionTable extends AbstractMigration
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
        $users = $this->table('permission', ['id' => false, 'primary_key' => ['permission_id']]);
        $users->addColumn('permission_id', 'integer', ['identity' => true])
            ->addColumn('status', 'integer')
            ->addColumn('permission_status', 'integer')
            ->addColumn('permission_des', 'string')
            ->addIndex(['permission_id','permission_status'], ['unique' => true])
            ->addForeignKey('status', 'role', 'status', array('delete' => 'NO_ACTION', 'update' => 'NO_ACTION'))
            ->create();
    }
}
