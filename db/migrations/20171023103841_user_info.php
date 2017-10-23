<?php


use Phinx\Migration\AbstractMigration;

class UserInfo extends AbstractMigration
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
        $email = 'son.nguyen@dirox.net';
        $password = sha1('123456');
        $passwordSalt = sha1($email.'f0tp-p00ls-@p1'.$password);
        $salt =  hash('sha256',$passwordSalt);
        // inserting only one row
        $table = $this->table('users');

        $user1 = [
            'username'      => 'son',
            'password'      => $password,
            'password_salt' => $salt,
            'email'         => $email,
            'fullname'    => 'Son Nguyen',
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s'),
            'status'       => 1,
        ];
        $table->insert($user1);

        $email = 'hoang.nguyen@dirox.net';
        $passwordSalt = sha1($email.'f0tp-p00ls-@p1'.$password);
        $salt =  hash('sha256',$passwordSalt);
        $user2 = [
            'username'      => 'hoang',
            'password'      => $password,
            'password_salt' => $salt,
            'email'         => $email,
            'fullname'    => 'Hoang Nguyen',
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s'),
            'status'       => 1,
        ];
        $table->insert($user2);

        $email = 'khoa.nguyen@dirox.net';
        $passwordSalt = sha1($email.'f0tp-p00ls-@p1'.$password);
        $salt =  hash('sha256',$passwordSalt);
        $user3 = [
            'username'      => 'khoa',
            'password'      => $password,
            'password_salt' => $salt,
            'email'         => $email,
            'fullname'    => 'Khoa Nguyen',
            'created'       => date('Y-m-d H:i:s'),
            'updated'       => date('Y-m-d H:i:s'),
            'status'       => 1,
        ];

        $table->insert($user3);

        $table->saveData();
    }
}
