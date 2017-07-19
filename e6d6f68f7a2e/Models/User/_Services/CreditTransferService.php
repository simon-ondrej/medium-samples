<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\Models\User\_Services;

use e6d6f68f7a2e\Models\User\_Exceptions\NotEnoughCreditsException;
use e6d6f68f7a2e\Models\User\_Exceptions\UserNotFoundException;
use e6d6f68f7a2e\Models\User\UserRepository;
use e6d6f68f7a2e\Modules\Database\_Exceptions\DatabaseException;
use e6d6f68f7a2e\Modules\Database\TxManager;
use e6d6f68f7a2e\ValueObjects\Credits;

final class CreditTransferService
{
    /**
     * @var TxManager
     */
    private $txManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param TxManager      $txManager
     * @param UserRepository $userRepository
     */
    public function __construct(TxManager $txManager, UserRepository $userRepository)
    {
        $this->txManager      = $txManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param int     $userIdFrom
     * @param int     $userIdTo
     * @param Credits $amount
     *
     * @throws NotEnoughCreditsException
     * @throws UserNotFoundException
     */
    public function transferCredits(int $userIdFrom, int $userIdTo, Credits $amount): void
    {
        $transaction = $this->txManager->beginTransaction();

        try {
            $userFrom = $this->userRepository->getOneById($userIdFrom);
            $userTo   = $this->userRepository->getOneById($userIdTo);

            $userFrom->transferCreditsTo($userTo, $amount);

            $this->userRepository->saveOne($userFrom);
            $this->userRepository->saveOne($userTo);

            $transaction->commit();
        } catch (DatabaseException $e) {
            $transaction->rollBack();
        }
    }
}
