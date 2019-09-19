<?php

use Flarum\Database\Migration;

return Migration::addColumns('users', [
    'clarkwinkelmann_poke_count' => [
        'integer',
        'default' => 0,
        'unsigned' => true,
    ],
]);
