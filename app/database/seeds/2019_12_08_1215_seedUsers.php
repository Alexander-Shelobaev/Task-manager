<?php

return [

    ['login' => 'admin', 'email' => 'alex@gmail.com',
    'password' => password_hash('123', PASSWORD_DEFAULT),
    'active_key' => password_hash(mt_rand(), PASSWORD_DEFAULT),
    'active' => 1, 'name' => 'Alex'],

    ['login' => 'Mike', 'email' => 'Mike@gmail.com',
    'password' => password_hash('354Mike', PASSWORD_DEFAULT),
    'active_key' => password_hash(mt_rand(), PASSWORD_DEFAULT),
    'active' => 1, 'name' => 'Mike'],

    ['login' => 'Ben', 'email' => 'ben@gmail.com',
    'password' => password_hash('Ben125661', PASSWORD_DEFAULT),
    'active_key' => password_hash(mt_rand(), PASSWORD_DEFAULT),
    'active' => 1, 'name' => 'Ben'],

];
