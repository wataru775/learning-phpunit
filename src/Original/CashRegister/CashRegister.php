<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister;

use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CalculateService\CalculateServiceRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CalculateService\CalculateServiceResponse;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CashRegisterRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CashRegisterResponse;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\ProductService\ProductServiceRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\ProductService\ProductServiceResponse;
use org\mmpp\learning\phpunit\Original\CashRegister\Service\CalculateService;
use org\mmpp\learning\phpunit\Original\CashRegister\Service\ProductService;

class CashRegister
{
    private $calculateService;
    private $productService;

    public function __construct(ProductService $productService,CalculateService $calculateService)
    {
        $this->calculateService = $calculateService;
        $this->productService = $productService;
    }

    /**
     * クレジットレジストリ処理
     * @param CashRegisterRequest $request クレジットレジストリサービスリクエスト
     * @return CashRegisterResponse クレジットレジストリサービスレスポンス
     */
    public function calculate(CashRegisterRequest $request) : CashRegisterResponse {
        // 価格情報・商品タイトルの取得
        $productServiceRequest = $this->makeProductServiceRequest($request);

        $productServiceResponse = $this->productService->seek($productServiceRequest);

        // 要求を解析して掲載書式に入れ替え
        $serviceRequest = $this->makeCalculateServiceRequest($productServiceResponse);
        // 計算処理へ
        $serviceResponse = $this->calculateService->calculate($serviceRequest);
        // 返却書式へと入れ替え
        return $this->makeResponse($serviceResponse);
    }

    /**
     * 計算サービスリクエストから製品情報サービスリクエストへと変換します
     * @param CashRegisterRequest $request 計算サービスリクエスト
     * @return ProductServiceRequest 製品情報サービスリクエスト
     */
    private function makeProductServiceRequest(CashRegisterRequest $request) : ProductServiceRequest {
        $serviceRequest = new ProductServiceRequest();
        $serviceRequest->seeks = $request->seeks;
        return $serviceRequest;
    }

    /**
     * 製品情報サービスレスポンスから計算サービスリクエストへと変換します
     * @param ProductServiceResponse $productResponse 製品情報サービスレスポンス
     * @return CalculateServiceRequest 計算サービスリクエスト
     */
    private function makeCalculateServiceRequest(ProductServiceResponse $productResponse): CalculateServiceRequest {
        $calculateRequest = new CalculateServiceRequest();
        $calculateRequest->items = $productResponse->items;
        return $calculateRequest;
    }

    /**
     * 計算サービスレスポンスからクレジットレジストリサービスレスポンスへと変換します
     * @param CalculateServiceResponse $calculateResponse 計算サービスレスポンス
     * @return CashRegisterResponse クレジットレジストリサービスレスポンス
     */
    private function makeResponse(CalculateServiceResponse $calculateResponse) : CashRegisterResponse {
        $response = new CashRegisterResponse();
        $response->items = $calculateResponse->items;
        $response->tax = $calculateResponse->tax;
        $response->total_price = $calculateResponse->total_price;
        return $response;
    }

}