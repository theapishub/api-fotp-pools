<?php

use Phinx\Seed\AbstractSeed;

class PermissionSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [];

        $AdminList = [
           [
            'key' =>1,
           'value' => 'Delete any user'
          ],
          [
              'key' =>2,
              'value' => 'Create any user'
          ],
          [
              'key' =>3,
              'value' => 'Update any user'
          ]
        ];

        $UserList = [
            'status' => 1,
            'permission_status' => 4,
            'permission_des' => 'Self update'
        ];

        for ($i = 0; $i < 3; $i++) {
            $data[] = [
                'status'      => 0,
                'permission_status'      => $AdminList[$i]['key'],
                'permission_des' => $AdminList[$i]['value'],
            ];
        }
        $this->insert('permission', $data);
        $this->insert('permission', $UserList);
    }
}