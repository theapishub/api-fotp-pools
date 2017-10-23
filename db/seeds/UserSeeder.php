<?php
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $data = [];

        for ($i = 0; $i < 100; $i++) {
            $salt = $faker->password.'290a27164f3b438308f0b942223b64db4faf5c68';
            $data[] = [
                'username'      => $faker->userName,
                'password'      => sha1($faker->password),
                'password_salt' => hash('sha256', $salt),
                'email'         => $faker->email,
                'fullname'    => $faker->name,
                'created'       => date('Y-m-d H:i:s'),
                'updated'       => date('Y-m-d H:i:s'),
                'status'       => 1,
            ];
        }

        $this->insert('users', $data);
    }
}
