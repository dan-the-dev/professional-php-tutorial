<?php
declare(strict_types=1);

namespace SocialNews\User\Application;

use SocialNews\User\Domain\User;
use SocialNews\User\Domain\UserRepository;

final class LoginHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Login $command): void
    {
        $user = $this->userRepository->findByNickname($command->getNickname());

        if ($user === null) {
            return;
        }

        $user->login($command->getPassword());
        $this->userRepository->save($user);
    }
}