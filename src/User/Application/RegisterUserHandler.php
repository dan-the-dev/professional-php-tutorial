<?php
declare(strict_types=1);

namespace SocialNews\User\Application;

use SocialNews\User\Domain\User;
use SocialNews\User\Domain\UserRepository;

final class RegisterUserHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(RegisterUser $registerUser): void
    {
        $user = User::register($registerUser->getNickname(), $registerUser->getPassword());
        $this->userRepository->add($user);
    }
}