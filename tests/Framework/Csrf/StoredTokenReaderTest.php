<?php
declare(strict_types=1);

namespace Tests\Framework\Csrf;

use Exception;
use PHPUnit\Framework\TestCase;
use SocialNews\Framework\Csrf\StoredTokenReader;
use SocialNews\Framework\Csrf\Token;
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
            ->with('test', $this->anything());

        $storedTokenReader->generateToken('test');
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
            ->with('test')
            ->willReturn(new Token('test-token'));

        $actualToken = $storedTokenReader->read('test');
        $this->assertEquals(new Token('test-token'), $actualToken);
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
            ->with('test')
            ->willReturn(null);

        $tokenStorage->expects($this->once())
            ->method('store')
            ->with('test', $this->anything());

        $storedTokenReader->read('test');
    }
}