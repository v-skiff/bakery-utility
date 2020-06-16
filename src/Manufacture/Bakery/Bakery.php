<?php

namespace src\Manufacture\Bakery;

use src\Entity\Product\Pancake;
use src\Entity\BaseProduct;
use src\Entity\BaseRequest;
use src\Manufacture\ManufactureInterface;

class Bakery implements ManufactureInterface
{
    public function produce(BaseRequest $request): BaseProduct
    {
        $productName = $request->getProductName();
        $productClass = "src\\Entity\\Product\\" . $productName;
        $product = new $productClass();

        $additions = $request->getAdditionsList();
        $receiptIngredients = $product->getReceiptIngredients($additions);

        foreach($receiptIngredients as $ingredientName => $className) {
            try {
                $ingredient = new $className;
            } catch (\Error $error) {
                continue;
            }
            $product->addIngredient($ingredient);
        }

        return $product;
    }
}
