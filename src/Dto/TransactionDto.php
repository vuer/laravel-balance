<?php

namespace Vuer\LaravelBalance\Dto;

class TransactionDto
{
    /**
     * @var float
     */
    private $amount;

    /**
     * @var int|null
     */
    private $type;

    public function __construct(float $amount, int $type = null)
    {
        $this->amount = $amount;
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }
}