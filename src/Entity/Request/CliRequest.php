<?php

namespace src\Entity\Request;

use src\Entity\BaseRequest;

class CliRequest extends BaseRequest
{
   public function __construct(string $inputProductName, array $additions = [])
   {
       $this->productName = $inputProductName;
       $this->additions = $additions;
   }

   /**
    * @return string
   */
   public function getProductName(): string {
       return $this->productName;
   }

   /**
    * @return array
   */
   public function getAdditionsList(): array {
       return $this->additions;
   }
}