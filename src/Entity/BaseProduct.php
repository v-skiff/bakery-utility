<?php

namespace src\Entity;

abstract class BaseProduct
{
    const NAME_PANCAKE = 'pancake';
    const NAME_AMERICANO = 'americano';

    protected $failReason;
    protected $receipt;

    /** @var array */
    protected $ingredients = [];

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @param array $additions
     * @return array
     */
    abstract public function getReceiptIngredients(array $additions): array;

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        if (count($this->getReceiptIngredients()) !== count($this->ingredients)) {
            $this->failReason = 'there is no enough of ingredients';
            return false;
        }

        foreach ($this->getReceiptIngredients() as $ingredientName => $className) {
            if (!isset($this->getIngredients()[$ingredientName]) || get_class($this->getIngredients()[$ingredientName]) !== $className) {
                $this->failReason = "some problem with {$ingredientName}";
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    public function getIngredients(): array
    {
        return $this->ingredients;
    }

    /**
     * @param BaseIngredient $ingredient
     * @return void
     */
    public function addIngredient(BaseIngredient $ingredient)
    {
        $this->ingredients[$ingredient->getName()] = $ingredient;
    }

    /**
     * @return array
     */
    public static function getProductsList()
    {
        $reflector = new \ReflectionClass(__CLASS__);
        $constants = $reflector->getConstants();
        $values = [];

        foreach($constants as $constant => $value) {
            $prefix = "NAME_";
            if(strpos($constant, $prefix) !==false) {
                $values[] = $value;
            }
        }

        return $values;
    }

    /**
     * @return string
     */
    public function getFailReason() {
        return $this->failReason ?? '';
    }

    /**
     * @param array $additions
     * @return array
     */
    protected function modifyReceipt($additions = []): array {
        if ($additions) {
            $constPrefix = 'NAME_';
            foreach($additions as $addition) {
                $className = 'src\\Entity\\Ingredient\\' . ucfirst(mb_strtolower($addition));
                if (class_exists($className)) {
                    $constName = $constPrefix . mb_strtoupper($addition);
                    $ingredientName = constant('src\Entity\BaseIngredient::' . $constName);
                    if (! isset($this->receipt[$ingredientName])) {
                        $this->receipt[$ingredientName] = $className;
                    }
                } else {
                    continue;
                }
            }
        }
        return $this->receipt;
    }
}
