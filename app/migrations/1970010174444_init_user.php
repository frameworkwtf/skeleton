<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class InitUser extends AbstractMigration
{
    public function change(): void
    {
        $this->table('users')
             ->addColumn('email', 'string', ['comment' => 'Email is user login and it is unique'])
             ->addColumn('forgot', 'string', ['default' => null, 'null' => true, 'comment' => 'Field for password reset code'])
             ->addColumn('password', 'string')
             ->addIndex(['email'], ['unique' => true])
             ->addIndex(['forgot'])
             ->create();
    }
}
