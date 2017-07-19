<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\Models\User;

use e6d6f68f7a2e\Models\User\_Exceptions\UserNotFoundException;

interface UserRepository
{
    /**
     * Retrieves User and should one not be found throws an exception.
     *
     * @param int $id
     * @return User
     *
     * @throws UserNotFoundException
     */
    public function getOneById(int $id): User;

    /**
     * Saves user with new data.
     *
     * @param User $user
     */
    public function saveOne(User $user): void;
}
