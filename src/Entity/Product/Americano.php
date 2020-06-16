<?php

namespace src\Entity\Product;

use src\Entity\BaseIngredient;
use src\Entity\BaseProduct;
use src\Entity\Ingredient\Coffee;
use src\Entity\Ingredient\Egg;
use src\Entity\Ingredient\Flour;
use src\Entity\Ingredient\Milk;
use src\Entity\Ingredient\Sugar;
use src\Entity\Ingredient\Water;

class Americano extends BaseProduct
{
    public function __construct()
    {
        $this->receipt = [
            BaseIngredient::NAME_WATER => Water::class,
            BaseIngredient::NAME_COFFEE => Coffee::class,
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::NAME_AMERICANO;
    }

    /**
     * @param array $additions
     * @return array
     */
    public function getReceiptIngredients(array $additions = []): array
    {
        if ($additions) {
            $this->modifyReceipt($additions);
        }
        return $this->receipt;
    }
}
