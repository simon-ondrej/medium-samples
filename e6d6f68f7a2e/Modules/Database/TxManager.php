<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\Modules\Database;

use e6d6f68f7a2e\Modules\Database\_Exceptions\DatabaseException;

interface TxManager
{
    /**
     * @return Transaction
     *
     * @throws DatabaseException
     */
    public function beginTransaction(): Transaction;
}
