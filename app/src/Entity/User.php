<?php

declare(strict_types=1);

namespace App\Entity;

use Respect\Validation\Validator as v;
use Wtf\ORM\Entity;

class User extends Entity
{
    /**
     * {@inheritdoc}
     */
    public function getTable(): string
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function getValidators(): array
    {
        return [
            'email' => v::email(),
            'password' => v::stringType(),
            'forgot' => v::optional(v::stringType()),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getRelations(): array
    {
        return [];
    }
}
