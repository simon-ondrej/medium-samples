<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\Modules\Database;

use e6d6f68f7a2e\Modules\Database\_Exceptions\DatabaseException;

interface Transaction
{
    /**
     * @throws DatabaseException
     */
    public function commit(): void;

    /**
     * @throws DatabaseException
     */
    public function rollBack(): void;
}
