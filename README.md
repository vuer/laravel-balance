# Laravel Balance

[![Latest Stable Version](https://poser.pugx.org/vuer/laravel-balance/v/stable)](https://packagist.org/packages/vuer/laravel-balance) [![Total Downloads](https://poser.pugx.org/vuer/laravel-balance/downloads)](https://packagist.org/packages/vuer/laravel-balance) [![Latest Unstable Version](https://poser.pugx.org/vuer/laravel-balance/v/unstable)](https://packagist.org/packages/vuer/laravel-balance) [![License](https://poser.pugx.org/vuer/laravel-balance/license)](https://packagist.org/packages/vuer/laravel-balance)

## Installation

You can install this package via composer using this command:
  
```
composer require vuer/laravel-balance
```

Next, you must install the service provider:

``` php
// config/app.php
'providers' => [
    ...
    Vuer\LaravelBalance\BalanceServiceProvider::class,
];
```

Publish migration and configuration file:

```
php artisan vendor:publish
```

After the migration has been published you can create the tables by running the migrations:
```
php artisan migrate
```

## Usage
### Preparing your model

Associate account balance with a model:
``` php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Vuer\LaravelBalance\Models\AccountBalance;
use Vuer\LaravelBalance\Models\Interfaces\AccountBalanceHolderInterface

class User extends Model implements AccountBalanceHolderInterface
{
    public function accountBalances()
    {
        return $this->morphOne(AccountBalance::class, 'holder');
    }

    public function getAccount(string $currency): ?AccountBalance
    {
        return $this->accountBalances()->where('currency', $currency)->first();
    }

    public function addAccountBalance(AccountBalance $accountBalance)
    {
        $accountBalance->holder()->associate($this);
        $accountBalance->save();
    }
}
```

### Account balance
Register dependencies:
``` php
<?php
use Vuer\LaravelBalance\Services\Accountant;
use Vuer\LaravelBalance\Services\TransactionProcessor;

class SomeController extends Controller
{
    /**
     * @var Accountant
     */
    private $accountant;
    
    /**
     * @var TransactionProcessor
     */
    private $transactionProcessor;

    public function __construct(Accountant $accountant, TransactionProcessor $transactionProcessor)
    {
        $this->accountant = $accountant;
        $this->transactionProcessor = $transactionProcessor;
    }
}
```
To create account use methods `getAccountOrCreate` or `createAccount`.
``` php
$account = $this->accountant->getAccountOrCreate($user, new \Money\Currency('EUR'));
$account = $this->accountant->createAccount($user, new \Money\Currency('EUR'));
```
To get existing account use method `getAccount`.
``` php
$account = $this->accountant->getAccount($user, new \Money\Currency('EUR'));
```
To get account balance values:
``` php
$currency = $account->getBalance()->getCurrency();
$amount = $account->getBalance()->getAmount();
```
### Create transactions
To add 100 EUR to your balance:
```php
$account = $this->accountant->getAccount($user, new \Money\Currency('EUR'));
$transaction = $this->transactionProcessor->create($account, new \Vuer\LaravelBalance\Dto\TransactionDto(100));
```
Only integers allowed, so then if you want to place decimals then consider storing 1 USD as 100.
