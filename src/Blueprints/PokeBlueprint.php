<?php

namespace ClarkWinkelmann\Poke\Blueprints;

use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\User\User;

class PokeBlueprint implements BlueprintInterface
{
    protected $fromUser;
    protected $counter;

    public function __construct(User $fromUser, int $counter)
    {
        $this->fromUser = $fromUser;
        $this->counter = $counter;
    }

    public function getFromUser()
    {
        return $this->fromUser;
    }

    public function getSubject()
    {
        return $this->fromUser;
    }

    public function getData()
    {
        return $this->counter;
    }

    public static function getType()
    {
        return 'clarkwinkelmann-poke';
    }

    public static function getSubjectModel()
    {
        return User::class;
    }
}
