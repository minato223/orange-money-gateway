<?php

namespace LamineMinato\OrangeMoneyGateway\Domain\Exception;

use Exception;

class OrangeMoneyException extends Exception {

   private ?string $description = null;
   public function __construct(string $message,string $description = null) {
        parent::__construct($message);
        $this->description = $description;
    }

   /**
    * Get the value of description
    */ 
   public function getDescription()
   {
      return $this->description;
   }
}