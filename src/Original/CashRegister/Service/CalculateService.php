<?php


namespace org\mmpp\learning\phpunit\Original\CashRegister\Service;


use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CalculateService\CalculateServiceRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CalculateService\CalculateServiceResponse;

class CalculateService
{
    public function calculate(CalculateServiceRequest $request) : CalculateServiceResponse
    {
        $response = new CalculateServiceResponse();

        $total_price = 0;
        $total_tax = 0;

        foreach ($request->items as $item){

            // 商品価格
            if($item->custom_price){
                $price = $item->custom_price * $item->quantity;
            }else{
                $price = $item->price * $item->quantity;
            }
            $item->subtotal_price = $price;

            // 税額計算
            $tax = $price * $item->tax_rate;
            // 総額表示対応？
            $tax = floor($tax);

            $item->tax = $tax;
            $item->price = $price;

            $item->total_price = $price + $tax;

            $total_price += $item->total_price;
            $total_tax += $item->tax;

            // 料金を入れたので返却に入れる
            $response->items[] = $item;
        }

        $response->total_price = $total_price;
        $response->tax = $total_tax;

        return $response;

    }

}