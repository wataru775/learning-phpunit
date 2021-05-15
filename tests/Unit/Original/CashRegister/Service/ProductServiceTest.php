<?php


namespace Tests\Unit\org\mmpp\learning\phpunit\Original\CashRegister\Service;


use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Product;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\ProductService\ProductServiceRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Seek;
use org\mmpp\learning\phpunit\Original\CashRegister\Repository\ProductRepository;
use org\mmpp\learning\phpunit\Original\CashRegister\Service\ProductService;
use PHPUnit\Framework\TestCase;

class ProductServiceTest extends TestCase
{

    public function test_seek_normal(){
        // seek -> Product

        // 商品情報を引っ張ってくる
        $repository = new ProductRepositoryStub();

        // 試験対象クラスを生成
        $service = new ProductService($repository);

        $request = new ProductServiceRequest();

        // 商品を追加する（9780131495050:xUnit Test Patterns を 1個 手動価格:null）
        $request->seeks[] = new Seek('9780131495050',1,null);

        $response = $service->seek($request);

        $item = $response->items[0];
        $this->assertEquals('xUnit Test Patterns',$item->title);

        $this->assertEquals('9780131495050',$item->isbn);
        $this->assertEquals(1,$item->quantity);
        $this->assertEquals(0.1,$item->tax_rate);

    }

    /**
     * 製品リポジトリリクエストを製品サービスリクエストからを生成する試験
     */
    public function test_makeProductRepositoryRequest(){
        // 製品リポジトリリクエストを生成
        $request = new ProductServiceRequest();
        $request->seeks[] = new Seek('9780131495050',1,null);

        $req = self::getProductService()->makeProductRepositoryRequest($request->seeks[0]);

        // 製品サービスリクエストの評価
        $this->assertEquals('9780131495050',$req->isbn);
    }

    /**
     * 製品サービスレスポンスを生成する試験
     */
    public function test_makeResponse(){
        // 製品情報一覧 (リポジトリからの返却値)
        $products = array();
        $product = new Product();
        $product->isbn = '9780131495050';
        $product->title = 'xUnit Test Patterns';
        $product->price = 1000;
        $product->tax_rate = 0.1;

        $products[] = $product;

        $req = self::getProductService()->makeResponse($products);

        // 製品サービスレスポンスを評価
        $this->assertEquals('9780131495050',$req->items[0]->isbn);
        $this->assertEquals('xUnit Test Patterns',$req->items[0]->title);
        $this->assertEquals(1000,$req->items[0]->price);
        $this->assertEquals(0.1,$req->items[0]->tax_rate);

    }

    /**
     * 引き渡される製品情報とリポジトリの製品情報から製品情報を組み上げる試験
     */
    public function test_makeItem(){
        // 入力製品情報
        $seek = new Seek('9780131495050',1,null);

        // リポジトリからの製品情報
        $product = new Product();
        $product->isbn = '9780131495050';
        $product->title = 'xUnit Test Patterns';
        $product->price = 1000;
        $product->tax_rate = 0.1;


        $item = self::getProductService()->makeItem($seek,$product);

        // 製品情報を評価
        $this->assertEquals('9780131495050',$item->isbn);
        $this->assertEquals('xUnit Test Patterns',$item->title);
        $this->assertEquals(1000,$item->price);
        $this->assertEquals(0.1,$item->tax_rate);
        $this->assertEquals(1,$item->quantity);
        $this->assertEquals(null,$item->custom_price);
    }

    private function getProductService() : ProductService{
        return new ProductService(new ProductRepository());
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