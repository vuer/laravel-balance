<?php

namespace Vuer\LaravelBalance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Money\Money;

class Transaction extends Model
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
        if (!$this->created_at) {
            $this->created_at = (new \DateTime())->format('Y-m-d H:i:s');
        }
        $this->table = Config::get('vuer-account-balance.account_balance_transactions_table');
    }

    /**
     * @inheritdoc
     * @var bool
     */
    public $timestamps = false;

    public function getAmount(): Money
    {
        return new Money((int)$this->amount, $this->getAccountBalance()->getCurrency());
    }

    /**
     * @return AccountBalance
     */
    public function getAccountBalance(): AccountBalance
    {
        return $this->accountBalance;
    }

    /**
     * @param AccountBalance $accountBalance
     */
    public function setAccountBalance(AccountBalance $accountBalance)
    {
        $this->accountBalance()->associate($accountBalance);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountBalance()
    {
        return $this->belongsTo(AccountBalance::class);
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }
}