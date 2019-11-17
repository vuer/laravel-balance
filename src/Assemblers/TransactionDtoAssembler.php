<?php

namespace Vuer\LaravelBalance\Assemblers;

use Vuer\LaravelBalance\Models\Transaction;
use Vuer\LaravelBalance\Dto\TransactionDto;

class TransactionDtoAssembler
{
    public function dtoToModel(TransactionDto $transactionDto): Transaction
    {
        $transactionModel = new Transaction();
        $transactionModel->amount = $transactionDto->getAmount();
        $transactionModel->type = $transactionDto->getType();

        return $transactionModel;
    }
}