<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\Models\User\_Exceptions;

final class NotEnoughCreditsException extends \DomainException
{
    /**
     * @param int $userId
     * @return NotEnoughCreditsException
     */
    public static function withUserId(int $userId): NotEnoughCreditsException
    {
        return new NotEnoughCreditsException(
            sprintf('The user with the id %d does not have enough credits.', $userId)
        );
    }
}
