<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Repository;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Product;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Repository\ProductRepositoryRequest;

/**
 * 製品情報アクセスリポジトリ
 * Class ProductRepository
 * @package org\mmpp\learning\phpunit\Original\CashRegister\Repository
 */
class ProductRepository
{

    /**
     * データーベスより指定のISBNの情報を取得します
     * @param $request ProductRepositoryRequest リポジトリ検索リクエスト
     * @return Product 製品情報
     */
    public function find(ProductRepositoryRequest $request) : Product
    {
        // SQLなどでデーターベースから取得します...
        // Model\Product::where('isbn',$isbn)->first();
        // データベースの結果をこのクラスの返却クラスに変換します
        return new Product();
    }
}