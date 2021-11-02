<?php
    namespace App;
    use Session;
    class Cart{

        public $items = null;
        public $totalQty = 0;
        public $totalPrice = 0;


        public function __construct($oldCart){
            
            if($oldCart){
                $this->items = $oldCart->items;
                $this->totalQty = $oldCart->totalQty;
                $this->totalPrice = $oldCart->totalPrice;
            }

        }

        public function add($item, $product_id){

            $storedItem = ['qty' => 0, 'product_id' => 0, 'productName' => $item->productName,
        'productPrice' => $item->productPrice, 'productImage' => $item->productImage, 'item' =>$item];

        if($this->items){
            if(array_key_exists($product_id, $this->items)){
                $storedItem = $this->items[$product_id];
            }
        }

        $storedItem['qty']++;
        $storedItem['product_id'] = $product_id;
        $storedItem['productName'] = $item->productName;
        $storedItem['productPrice'] = $item->productPrice;
        $storedItem['productImage'] = $item->productImage;
        $this->totalQty++;
        $this->totalPrice += $item->productPrice;
        $this->items[$product_id] = $storedItem;

        }

         public function updateQty($id, $qty){
            $this->totalQty -= $this->items[$id]['qty'];
            $this->totalPrice -= $this->items[$id]['productPrice'] * $this->items[$id]['qty'];
            $this->items[$id]['qty'] = $qty;
            $this->totalQty += $qty;
            $this->totalPrice += $this->items[$id]['productPrice'] * $qty;

        }

        

        public function deleteCart($id){
            $this->totalQty -= $this->items[$id]['qty'];
            $this->totalPrice -= $this->items[$id]['productPrice'] * $this->items[$id]['qty'];
            unset($this->items[$id]);
        } 


    }
?>