<?php

declare(strict_types=1);

namespace e6d6f68f7a2e\Models\User;

use e6d6f68f7a2e\Models\User\_Exceptions\NotEnoughCreditsException;
use e6d6f68f7a2e\ValueObjects\Credits;
use e6d6f68f7a2e\ValueObjects\Credits\_Exceptions\NegativeCreditsValueError;

final class User
{
    /**
     * @var int|null
     */
    private $id = null;

    /**
     * @var Credits
     */
    private $credits;

    public function __construct()
    {
        // The default amount of credits for a user is 0.
        $this->credits = Credits::withValue(0);
    }

    /**
     * @param int $id
     */
    public function assignId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Credits
     */
    public function getCredits(): Credits
    {
        return $this->credits;
    }

    /**
     * Tries to transfer credits from this user to another and throws on unsuccessful operation, i.e. when this user
     * does not have enough credits to be transferred.
     *
     * @param User    $targetedUser
     * @param Credits $amount
     *
     * @throws NotEnoughCreditsException
     */
    public function transferCreditsTo(User $targetedUser, Credits $amount): void
    {
        if ($this->credits->isLessThan($amount)) {
            throw NotEnoughCreditsException::withUserId($this->id);
        }

        // At this point we can safely withdraw the funds, because the user has enough.
        $this->withdrawCredits($amount);
        $targetedUser->addCredits($amount);
    }

    /**
     * Adds credits to user.
     *
     * @param Credits $amount
     */
    private function addCredits(Credits $amount): void
    {
        $this->credits = $this->credits->add($amount);
    }

    /**
     * Withdraws credits from user. You should make sure to validate the credits can be withdrawn before calling this
     * method so that the NegativeCreditsValueError is not thrown.
     *
     * @param Credits $amount
     *
     * @throws NegativeCreditsValueError
     */
    private function withdrawCredits(Credits $amount): void
    {
        $this->credits = $this->credits->subtract($amount);
    }
}
