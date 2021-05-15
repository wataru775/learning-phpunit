<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Model;

// Eloquentとかのイメージ

class Product
{
    /**
     * @var string バーコード
     */
    public $isbn;
    /**
     * @var string 名称
     */
    public $title;
    /**
     * @var float 税率
     */
    public $tax_rate;
    /**
     * @var int 単価
     */
    public $price;
}