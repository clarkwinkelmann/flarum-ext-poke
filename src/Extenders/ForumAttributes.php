<?php

namespace ClarkWinkelmann\Poke\Extenders;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use Illuminate\Contracts\Container\Container;

class ForumAttributes implements ExtenderInterface
{
    public function extend(Container $container, Extension $extension = null)
    {
        $container['events']->listen(Serializing::class, [$this, 'attributes']);
    }

    public function attributes(Serializing $event)
    {
        if ($event->isSerializer(ForumSerializer::class)) {
            $event->attributes['clarkwinkelmannPokeCanPoke'] = $event->actor->can('clarkwinkelmann-poke.poke');
            $event->attributes['clarkwinkelmannPokeCanReset'] = $event->actor->can('clarkwinkelmann-poke.reset');
        }
    }
}
