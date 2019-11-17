<?php

namespace Vuer\LaravelBalance\Services;

use Money\Currency;
use Vuer\LaravelBalance\Exceptions\AccountBalanceLogicException;
use Vuer\LaravelBalance\Models\AccountBalance;
use Vuer\LaravelBalance\Models\Interfaces\AccountBalanceHolderInterface;

class Accountant
{
    public function getAccount(AccountBalanceHolderInterface $accountBalanceHolder, Currency $currency): ?AccountBalance
    {
        return $accountBalanceHolder->getAccount($currency->getCode());
    }

    public function getAccountOrCreate(AccountBalanceHolderInterface $accountBalanceHolder, Currency $currency): AccountBalance
    {
        $account = $this->getAccount($accountBalanceHolder, $currency);

        if (null === $account) {
            $account = $this->createAccount($accountBalanceHolder, $currency);
        }

        return $account;
    }

    public function createAccount(AccountBalanceHolderInterface $accountBalanceHolder, Currency $currency): AccountBalance
    {
        if (null !== $this->getAccount($accountBalanceHolder, $currency)) {
            throw AccountBalanceLogicException::accountAlreadyExists($accountBalanceHolder, $currency);
        }

        $accountBalance = new AccountBalance();
        $accountBalance->currency = $currency->getCode();

        $accountBalanceHolder->addAccountBalance($accountBalance);

        return $accountBalance;
    }
}