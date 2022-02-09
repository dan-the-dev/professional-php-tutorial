<?php
declare(strict_types=1);

namespace Tests\Framework\Csrf;

use PHPUnit\Framework\TestCase;
use SocialNews\Framework\Csrf\Token;

final class TokenTest extends TestCase
{
    public function testItGeneratesAValidToken512Length(): void
    {
        $actualToken = Token::generate();
        $this->assertEquals(512, strlen($actualToken->toString()));
    }

    public function testItCreatesATokenFromGivenString(): void
    {
        $actualToken = new Token('test');
        $this->assertEquals('test', $actualToken->toString());
    }

    public function testTokenWithSameValueAreEquals(): void
    {
        $token1 = new Token('test');
        $token2 = new Token('test');
        $this->assertTrue($token1->equals($token2));
    }

    public function testTokenWithDifferentValueAreNotEquals(): void
    {
        $token1 = new Token('test1');
        $token2 = new Token('test2');
        $this->assertFalse($token1->equals($token2));
    }
}