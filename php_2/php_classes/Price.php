<?php 
    class Price {
        protected $price;
        protected $discount;
        public $currency;
        const currencyExchange = '1$ = 72р';
    
        function __construct($price, $discount, $currency){
            $this->price = $price;
            $this->discount = $discount;
            $this->currency = $currency;
        }
    
        public function getPrice(){
            return $this->price;
        }
    
        public function setProperties($price, $discount){
            if($price > 0 && $discount != 0){
                $this->price = $price;
                $this->discount = $discount;
            }
        }
    
        // Метод подсчета стоимости
        public function getFinalCost(){
            return $this->price -  $this->price * $this->discount / 100;
        }

        public function getCurrencyExchange(){
            echo self::currencyExchange;
        }
    
    }
?>