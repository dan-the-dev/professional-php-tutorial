<?php
declare(strict_types=1);

namespace SocialNews\Framework\Rbac\Role;

use SocialNews\Framework\Rbac\Permission;
use SocialNews\Framework\Rbac\Role;

final class Author extends Role
{

    protected function getPermissions(): array
    {
        return [new Permission\SubmitLink()];
    }
}