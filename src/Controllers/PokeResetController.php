<?php

namespace ClarkWinkelmann\Poke\Controllers;

use Flarum\User\AssertPermissionTrait;
use Flarum\User\User;
use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;

class PokeResetController implements RequestHandlerInterface
{
    use AssertPermissionTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->assertCan($request->getAttribute('actor'), 'clarkwinkelmann-poke.reset');

        $userId = Arr::get($request->getQueryParams(), 'id');

        $user = User::query()->findOrFail($userId);

        $user->clarkwinkelmann_poke_count = 0;
        $user->save();

        return new EmptyResponse();
    }
}
