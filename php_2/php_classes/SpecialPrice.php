<?php 
    class SpecialPrice extends Price {
        private $additionalDiscount;
        
        function __construct($price, $discount, $currency, $additionalDiscount){
            $this->additionalDiscount = $additionalDiscount;
            parent::__construct($price, $discount, $currency);   
        }

        public function SetAdditionalDiscount($additionalDiscount){
            if($additionalDiscount != 0 ){
                $this->additionalDiscount = $additionalDiscount;
            }
        }

        public function getFinalCost(){
            return $this->price -  $this->price * $this->additionalDiscount * $this->discount / 100;
        }
        
    }