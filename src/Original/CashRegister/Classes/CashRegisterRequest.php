<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Classes;


class CashRegisterRequest
{

    /**
     * @var array 要求構成要素
     */
    public $seeks = [];

    /**
     * CashRegisterRequest constructor.
     */
    public function __construct()
    {
        $this->seeks = [];
    }
}