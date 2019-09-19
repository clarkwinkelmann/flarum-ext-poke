<?php

namespace ClarkWinkelmann\Poke\Controllers;

use ClarkWinkelmann\Poke\Blueprints\PokeBlueprint;
use Flarum\Api\Controller\AbstractShowController;
use Flarum\Api\Serializer\UserSerializer;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\AssertPermissionTrait;
use Flarum\User\User;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class PokeController extends AbstractShowController
{
    use AssertPermissionTrait;

    public $serializer = UserSerializer::class;

    protected $notifications;

    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $this->assertCan($request->getAttribute('actor'), 'clarkwinkelmann-poke.poke');

        $userId = Arr::get($request->getQueryParams(), 'id');

        $user = User::query()->findOrFail($userId);

        $user->clarkwinkelmann_poke_count++;
        $user->save();

        $this->notifications->sync(
            new PokeBlueprint($request->getAttribute('actor'), (int)$user->clarkwinkelmann_poke_count),
            [$user]
        );

        return $user;
    }
}
