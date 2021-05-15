<?php
namespace Tests\Feature\org\mmpp\learning\phpunit\Original\CashRegister;


use org\mmpp\learning\phpunit\Original\CashRegister\CashRegister;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CashRegisterRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Product;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Seek;
use org\mmpp\learning\phpunit\Original\CashRegister\Repository\ProductRepository;
use org\mmpp\learning\phpunit\Original\CashRegister\Service\CalculateService;
use org\mmpp\learning\phpunit\Original\CashRegister\Service\ProductService;
use PHPUnit\Framework\TestCase;

class CashRegisterTest extends TestCase
{
    public function test_calculate_null(){
        // レジスターへのリクエストを作成
        $request = new CashRegisterRequest();

        // 計算を実施
        $receipt = self::create_CashRegister_stub()->calculate($request);

        // 評価
        $this->assertEquals(0,$receipt->tax);
        $this->assertEquals(0,$receipt->total_price);

    }
    public function test_calculate(){
        // レジスターへのリクエストを作成
        $request = new CashRegisterRequest();

        // 商品を追加する（9780131495050:xUnit Test Patterns を 1個 消費税 10% 手動価格:null）
        $request->seeks[] = new Seek('9780131495050',1,null);

        // 計算を実施
        $receipt = self::create_CashRegister_stub()->calculate($request);

        // 評価
        $this->assertEquals(100,$receipt->tax);
        $this->assertEquals(1100,$receipt->total_price);

        // 商品情報を評価
        $item = $receipt->items[0];
        $this->assertEquals('xUnit Test Patterns',$item->title);

        $this->assertEquals('9780131495050',$item->isbn);
        $this->assertEquals(1,$item->quantity);
        $this->assertEquals(0.1,$item->tax_rate);

        $this->assertEquals(1000,$item->subtotal_price);
        $this->assertEquals(100,$item->tax);
        $this->assertEquals(1100,$item->total_price);

    }
    private function create_CashRegister_stub() : CashRegister{
        // レジスターのクラスを生成する
        return new CashRegister(
            new ProductService(
                new ProductRepositoryStub()
            ),
            new CalculateService());
    }
}
class ProductRepositoryStub extends ProductRepository{
    public function find($isbn) : Product {
        $product = new Product();

        $product->isbn = '9780131495050';
        $product->title = 'xUnit Test Patterns';
        $product->price = 1000;
        $product->tax_rate = 0.1;

        return $product;
    }

}
