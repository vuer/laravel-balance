<?php

namespace Vuer\LaravelBalance;

use Illuminate\Support\ServiceProvider;

class BalanceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $timestamp = date('Y_m_d_His', time());

        $this->publishes([
            __DIR__ . '/../database/migrations/create_account_balance_setup_tables.php.stub' => app()->basePath() . '/database/migrations/' . $timestamp . '_create_account_balance_setup_tables.php',
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/../config/config.php' => app()->basePath() . '/config/vuer-account-balance.php',
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}