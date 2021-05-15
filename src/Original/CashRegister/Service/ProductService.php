<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Service;


use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Item;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Product;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\ProductService\ProductServiceRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\ProductService\ProductServiceResponse;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Repository\ProductRepositoryRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Seek;
use org\mmpp\learning\phpunit\Original\CashRegister\Repository\ProductRepository;

/**
 * 製品情報取得サービス
 * Class ProductService
 * @package org\mmpp\learning\phpunit\Original\CashRegister\Service
 */
class ProductService
{
    /**
     * @var ProductRepository 製品情報リポジトリ
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * 製品情報を取得します
     * @param ProductServiceRequest $request サービス検索リクエスト
     * @return ProductServiceResponse 検索結果
     */
    public function seek(ProductServiceRequest $request) : ProductServiceResponse
    {
        // 製品情報配列
        $items = [];
        foreach ($request->seeks as $seek){
            // ISBNから製品情報を取得します
            $repositoryRequest = self::makeProductRepositoryRequest($seek);
            $product = $this->repository->find($repositoryRequest);
            // 製品情報をリポジトリ結果から生成します
            $items[] = $this->makeItem($seek,$product);
        }
        return $this->makeResponse($items);
    }

    /**
     * 製品リポジトリリクエストを製品サービスリクエストからを生成します
     * @param $seek Seek 検索条件
     * @return ProductRepositoryRequest 製品リポジトリリクエスト
     */
    public function makeProductRepositoryRequest(Seek $seek) : ProductRepositoryRequest{
        $repositoryRequest = new ProductRepositoryRequest();
        $repositoryRequest->isbn = $seek->isbn;
        return $repositoryRequest;
    }

    /**
     * 製品サービスレスポンスを生成します
     * @param array $products 製品リポジトリ検索結果
     * @return ProductServiceResponse 製品サービスレスポンス
     */
    public function makeResponse(array $products) : ProductServiceResponse{
        $response = new ProductServiceResponse();
        $response->items = $products;
        return $response;
    }

    /**
     * 検索用の製品情報とリポジトリ結果の製品情報を合わせて返脚用製品情報を生成します
     * 検索結果には数量やカスタマイズ値段などの情報を持っていないためです
     * @param Seek $seek 検索製品情報
     * @param Product $product リポジトリ製品情報
     * @return Item 返脚用製品情報
     */
    public function makeItem(Seek $seek,Product $product) : Item{
        $item = new Item();

        // 検索製品情報からの情報引継
        $item->isbn = $seek->isbn;
        $item->quantity = $seek->quantity;
        $item->custom_price = $seek->custom_price;

        // リポジトリ製品情報
        $item->title = $product->title;
        $item->price = $product->price;
        $item->tax_rate = $product->tax_rate;

        return $item;
    }
}