<?php
declare(strict_types=1);

namespace Tests\Framework\Csrf;

use PHPUnit\Framework\TestCase;
use SocialNews\Framework\Csrf\StoredTokenValidator;
use SocialNews\Framework\Csrf\Token;
use SocialNews\Framework\Csrf\TokenKey;
use SocialNews\Framework\Csrf\TokenStorage;

final class StoredTokenValidatorTest extends TestCase
{
    public function testValidatesTwoEqualsToken(): void
    {
        $tokenStorage = $this->createMock(TokenStorage::class);
        $storedTokenValidator = new StoredTokenValidator($tokenStorage);

        $tokenStorage->expects($this->once())
            ->method('retrieve')
            ->with(new TokenKey('test'))
            ->willReturn(new Token('test-token'));

        $actualResult = $storedTokenValidator->validate(new TokenKey('test'), new Token('test-token'));
        $this->assertTrue($actualResult);
    }

    public function testItDoesntValidatesTwoDifferentToken(): void
    {
        $tokenStorage = $this->createMock(TokenStorage::class);
        $storedTokenValidator = new StoredTokenValidator($tokenStorage);

        $tokenStorage->expects($this->once())
            ->method('retrieve')
            ->with(new TokenKey('test'))
            ->willReturn(new Token('test-token'));

        $actualResult = $storedTokenValidator->validate(new TokenKey('test'), new Token('test-token-2'));
        $this->assertFalse($actualResult);
    }

    public function testItDoesntValidateTokenWhenKeyDoesntExists(): void
    {
        $tokenStorage = $this->createMock(TokenStorage::class);
        $storedTokenValidator = new StoredTokenValidator($tokenStorage);

        $tokenStorage->expects($this->once())
            ->method('retrieve')
            ->with(new TokenKey('test'))
            ->willReturn(null);

        $actualResult = $storedTokenValidator->validate(new TokenKey('test'), new Token('test-token'));
        $this->assertFalse($actualResult);
    }
}