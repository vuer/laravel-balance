<?php

namespace Vuer\LaravelBalance\Models;

use Illuminate\Database\Eloquent\Model;
use Money\Currency;
use Money\Money;
use Vuer\LaravelBalance\Models\Interfaces\AccountBalanceHolderInterface;
use Illuminate\Support\Facades\Config;

class AccountBalance extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('vuer-account-balance.account_balance_table');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function holder()
    {
        return $this->morphTo();
    }

    /**
     * @return AccountBalanceHolderInterface
     */
    public function getHolder(): AccountBalanceHolderInterface
    {
        return $this->holder;
    }

    /**
     * @return Money
     */
    public function getBalance(): Money
    {
        return new Money($this->balance, $this->getCurrency());
    }

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return new Currency($this->currency);
    }

    /**
     * @param Transaction $transaction
     */
    public function addTransaction(Transaction $transaction)
    {
        $transaction->setAccountBalance($this);
    }

    public function updateBalance(Money $balance)
    {
        $this->balance = $balance->getAmount();
    }
}