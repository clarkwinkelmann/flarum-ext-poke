<?php

namespace ClarkWinkelmann\Poke;

use ClarkWinkelmann\Poke\Blueprints\PokeBlueprint;
use ClarkWinkelmann\Poke\Controllers\PokeController;
use ClarkWinkelmann\Poke\Controllers\PokeResetController;
use ClarkWinkelmann\Poke\Extenders\UserAttributes;
use ClarkWinkelmann\Poke\Extenders\ForumAttributes;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),

    new Extend\Locales(__DIR__ . '/resources/locale'),

    new ForumAttributes(),
    new UserAttributes(),

    (new Extend\Routes('api'))
        ->post('/users/{id}/poke', 'clarkwinkelmann-poke', PokeController::class)
        ->post('/users/{id}/poke-reset', 'clarkwinkelmann-poke', PokeResetController::class),

    function (Dispatcher $events) {
        $events->listen(ConfigureNotificationTypes::class, function (ConfigureNotificationTypes $event) {
            $event->add(PokeBlueprint::class, BasicUserSerializer::class, ['alert']);
        });
    },
];
