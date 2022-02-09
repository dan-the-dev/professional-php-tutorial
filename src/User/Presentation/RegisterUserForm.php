<?php
declare(strict_types=1);

namespace SocialNews\User\Presentation;

use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;
use SocialNews\Framework\Csrf\TokenKey;
use SocialNews\User\Application\NicknameTakenQuery;
use SocialNews\User\Application\RegisterUser;

final class RegisterUserForm
{
    private StoredTokenValidator $storedTokenValidator;
    private NicknameTakenQuery $nicknameTakenQuery;
    private string $token;
    private string $nickname;
    private string $password;

    public function __construct(StoredTokenValidator $storedTokenValidator, NicknameTakenQuery $nicknameTakenQuery, string $token, string $nickname, string $password)
    {
        $this->storedTokenValidator = $storedTokenValidator;
        $this->nicknameTakenQuery = $nicknameTakenQuery;
        $this->token = $token;
        $this->nickname = $nickname;
        $this->password = $password;
    }

    /**
     * @return string[]
     */
    public function getValidationErrors(): array
    {
        $errors = [];

        if (!$this->storedTokenValidator->validate(new TokenKey('registration'), new Token($this->token))) {
            $errors[] = 'Invalid token';
        }
        if ($this->nicknameTakenQuery->execute($this->nickname)) {
            $errors[] = 'This nickname is already being used';
        }
        if (strlen($this->nickname) < 3 || strlen($this->nickname) > 20) {
            $errors[] = 'Nickname must be between 3 and 20 characters.';
        }
        if (!ctype_alnum($this->nickname)) {
            $errors[] = 'Nickname can only consist of letters and numbers.';
        }
        if (strlen($this->password) < 8) {
            $errors[] = 'Password must be at least 8 characters.';
        }

        return $errors;
    }

    public function hasValidationErrors(): bool
    {
        return (count($this->getValidationErrors()) > 0);
    }

    public function toCommand(): RegisterUser
    {
        return new RegisterUser(
            $this->nickname,
            $this->password,
        );
    }
}