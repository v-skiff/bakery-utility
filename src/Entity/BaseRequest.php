<?php

namespace src\Entity;

abstract class BaseRequest
{
    /** @var string */
    protected $productName;

    /** @var array */
    protected $additions;

    /**
     * @return string
     */
    abstract public function getProductName(): string;

    /**
     * @return array
     */
    abstract public function getAdditionsList(): array;
}
