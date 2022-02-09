<?php
declare(strict_types=1);

namespace Tests\Framework\Csrf;

use PHPUnit\Framework\TestCase;
use SocialNews\Framework\Csrf\SymfonySessionTokenStorage;
use SocialNews\Framework\Csrf\Token;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SymfonySessionTokenStorageTest extends TestCase
{
    public function testItStoresTokenInSessionCorrectly(): void
    {
        $sessionInterface = $this->createMock(SessionInterface::class);
        $sessionTokenStorage = new SymfonySessionTokenStorage($sessionInterface);

        $sessionInterface->expects($this->once())
            ->method('set')
            ->with('test', 'test-token');

        $sessionTokenStorage->store('test', new Token('test-token'));
    }

    public function testItRetrieveTokenInSessionAndReturnIt(): void
    {
        $sessionInterface = $this->createMock(SessionInterface::class);
        $sessionTokenStorage = new SymfonySessionTokenStorage($sessionInterface);

        $sessionInterface->expects($this->once())
            ->method('get')
            ->with('test')
            ->willReturn('test-token');

        $actualToken = $sessionTokenStorage->retrieve('test');
        $this->assertEquals(new Token('test-token'), $actualToken);
    }

    public function testItDoesntRetrieveTokenInSessionAndReturnNull(): void
    {
        $sessionInterface = $this->createMock(SessionInterface::class);
        $sessionTokenStorage = new SymfonySessionTokenStorage($sessionInterface);

        $sessionInterface->expects($this->once())
            ->method('get')
            ->with('test')
            ->willReturn(null);

        $actualToken = $sessionTokenStorage->retrieve('test');
        $this->assertNull($actualToken);
    }
}