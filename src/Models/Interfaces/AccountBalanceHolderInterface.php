<?php

namespace Vuer\LaravelBalance\Models\Interfaces;

use Vuer\LaravelBalance\Models\AccountBalance;

interface AccountBalanceHolderInterface
{
    public function getAccount(string $currency): ?AccountBalance;

    public function addAccountBalance(AccountBalance $accountBalance);
}