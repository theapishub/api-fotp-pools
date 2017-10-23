<?php


use Phinx\Migration\AbstractMigration;

class AdminInfo extends AbstractMigration
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
    public function up()
    {

        $email = 'drxfotp@gmail.com';
        $password = sha1('drxfotp');
        $passwordSalt = sha1($email.'f0tp-p00ls-@p1'.$password);
        $salt =  hash('sha256',$passwordSalt);
        // inserting only one row
        $admin = [
            'username'      => 'admin',
            'password'      => $password,
            'password_salt' => $salt,
            'email'         => $email,
            'fullname'    => 'Admin dirox',
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s'),
            'status'       => 0,
        ];

        $table = $this->table('users');
        $table->insert($admin);
        $table->saveData();
    }
}
