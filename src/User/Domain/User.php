<?php
declare(strict_types=1);

namespace SocialNews\User\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class User
{
    private UuidInterface $id;
    private string $nickname;
    private string $passwordHash;
    private DateTimeImmutable $creationDate;
    private int $failedLoginAttempts;
    private ?DateTimeImmutable $lastFailedLoginAttempts;
    private array $recordedEvents = [];

    public function __construct(
        UuidInterface $id,
        string $nickname,
        string $passwordHash,
        DateTimeImmutable $creationDate,
        int $failedLoginAttempts,
        ?DateTimeImmutable $lastFailedLoginAttempts
    )
    {
        $this->id = $id;
        $this->nickname = $nickname;
        $this->passwordHash = $passwordHash;
        $this->creationDate = $creationDate;
        $this->failedLoginAttempts = $failedLoginAttempts;
        $this->lastFailedLoginAttempts = $lastFailedLoginAttempts;
    }

    public static function register(string $nickname, string $password): User
    {
        return new User(
            Uuid::uuid4(),
            $nickname,
            password_hash($password, PASSWORD_DEFAULT),
            new DateTimeImmutable(),
            0,
            null
        );
    }

    public function login(string $password): void
    {
        if (!password_verify($password, $this->passwordHash)) {
            $this->lastFailedLoginAttempts = new DateTimeImmutable();
            $this->failedLoginAttempts++;
            return;
        }
        $this->failedLoginAttempts = 0;
        $this->lastFailedLoginAttempts = null;
        $this->recordedEvents[] = new UserWasLoggedIn();

    }

    /**
     * @return int
     */
    public function getFailedLoginAttempts(): int
    {
        return $this->failedLoginAttempts;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function getLastFailedLoginAttempts(): ?DateTimeImmutable
    {
        return $this->lastFailedLoginAttempts;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getCreationDate(): DateTimeImmutable
    {
        return $this->creationDate;
    }
    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getRecordedEvents(): array
    {
        return $this->recordedEvents;
    }

    public function clearRecordedEvents(): void
    {
        $this->recordedEvents = [];
    }
}