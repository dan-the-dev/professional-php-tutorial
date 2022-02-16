<?php
declare(strict_types=1);

namespace Tests\Framework\Csrf;

use Exception;
use PHPUnit\Framework\TestCase;
use SocialNews\Framework\Csrf\StoredTokenReader;
use SocialNews\Framework\Csrf\TokenValue;
use SocialNews\Framework\Csrf\TokenKey;
use SocialNews\Framework\Csrf\TokenStorage;

final class StoredTokenReaderTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testGenerateAndStoreTokenAndReturnIt(): void
    {
        $tokenStorage = $this->createMock(TokenStorage::class);
        $storedTokenReader = new StoredTokenReader($tokenStorage);

        $tokenStorage->expects($this->once())
            ->method('store')
            ->with(new TokenKey('test'), $this->anything());

        $storedTokenReader->generateToken(new TokenKey('test'));
    }

    /**
     * @throws Exception
     */
    public function testItRetrieveATokenAndReturnIt(): void
    {
        $tokenStorage = $this->createMock(TokenStorage::class);
        $storedTokenReader = new StoredTokenReader($tokenStorage);

        $tokenStorage->expects($this->once())
            ->method('retrieve')
            ->with(new TokenKey('test'))
            ->willReturn(new TokenValue('test-token'));

        $actualToken = $storedTokenReader->read(new TokenKey('test'));
        $this->assertEquals(new TokenValue('test-token'), $actualToken);
    }

    /**
     * @throws Exception
     */
    public function testItDoesNotRetrieveATokenAndGenerateNewOne(): void
    {
        $tokenStorage = $this->createMock(TokenStorage::class);
        $storedTokenReader = new StoredTokenReader($tokenStorage);

        $tokenStorage->expects($this->once())
            ->method('retrieve')
            ->with(new TokenKey('test'))
            ->willReturn(null);

        $tokenStorage->expects($this->once())
            ->method('store')
            ->with(new TokenKey('test'), $this->anything());

        $storedTokenReader->read(new TokenKey('test'));
    }
}