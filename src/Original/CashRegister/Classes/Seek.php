<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Classes;


class Seek
{
    /**
     * @var string バーコード
     */
    public $isbn;
    /**
     * @var int 数量
     */
    public $quantity;
    /**
     * @var int カスタムプライス
     */
    public $custom_price;

    public function __construct($isbn,$quantity,$custom_price = null)
    {
        $this->isbn  = $isbn;
        $this->quantity = $quantity;
        $this->custom_price = $custom_price;
    }

}