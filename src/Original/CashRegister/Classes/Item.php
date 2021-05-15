<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Classes;

/**
 * 商品情報
 * Class Item
 * @package org\mmpp\learning\phpunit\Original\CashRegister\Classes
 */
class Item
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
     * @var int 単価
     */
    public $price;
    /**
     * @var int カスタムプライス
     */
    public $custom_price;
    /**
     * @var float 税率
     */
    public $tax_rate;
    /**
     * @var int 数量
     */
    public $quantity;
    /**
     * @var int 商品合計金額
     * 単価 x 数量 + 税
     */
    public $total_price;
    /**
     * @var int 商品小計
     * 単価 x 数量
     */
    public $subtotal_price;
    /**
     * @var int 税額
     * 商品単価 x 数量 x 税率
     */
    public $tax;
}