<?php


namespace Tests\Unit\org\mmpp\learning\phpunit\Original\CashRegister\Service;


use org\mmpp\learning\phpunit\Original\CashRegister\Classes\CalculateService\CalculateServiceRequest;
use org\mmpp\learning\phpunit\Original\CashRegister\Classes\Item;
use org\mmpp\learning\phpunit\Original\CashRegister\Service\CalculateService;
use PHPUnit\Framework\TestCase;

class CalculateServiceTest extends TestCase
{

    /**
     * 商品検索から料金計算までをおこなう試験
     * 失敗例
     */
    public function test_fail(){

        $service = new CalculateService();

        // 計算サービスへのリクエスト
        $request = new CalculateServiceRequest();

        // 処理
        $response = $service->calculate($request);

        // 結果を評価
        $this->assertEquals(0,$response->total_price,'商品なしのエラー');
    }
    /**
     * 商品検索から料金計算までをおこなう試験
     */
    public function test_normal(){

        $service = new CalculateService();

        // 計算サービスへのリクエスト
        $request = new CalculateServiceRequest();

        // 商品を追加する（9780131495050:xUnit Test Patterns を 1個 消費税 10% 手動価格:null）
        $request_item = new Item();
        $request_item->isbn = '9780131495050';
        $request_item->custom_price = null;
        $request_item->quantity = 1;
        $request_item->title = 'xUnit Test Patterns';
        $request_item->price = 1000;
        $request_item->tax_rate = 0.1;

        $request->items[] = $request_item;

        // 処理
        $response = $service->calculate($request);

        // 結果を評価
        $this->assertEquals(1100,$response->total_price,'合計金額');
        $this->assertEquals(100,$response->tax , '消費税');

        // 商品明細を確認
        $item = $response->items[0];
        $this->assertEquals('xUnit Test Patterns',$item->title , '商品名の取得');
        $this->assertEquals('9780131495050',$item->isbn , 'ISBNの取得');
        $this->assertEquals(1,$item->quantity , '商品数量');
        $this->assertEquals(null,$item->custom_price , 'カスタム価格');

        // リポジトリからの取得
        $this->assertEquals(0.1,$item->tax_rate);
        $this->assertEquals(1000,$item->subtotal_price);
        $this->assertEquals(1100,$item->total_price);
        $this->assertEquals(100,$item->tax);
    }
    /**
     * 商品検索から料金計算までをおこなう試験 -カスタムプライス-
     */
    public function test_custom_price(){

        $service = new CalculateService();

        // 計算サービスへのリクエスト
        $request = new CalculateServiceRequest();

        // 商品を追加する（9780131495050:xUnit Test Patterns を 1個 消費税 10% 手動価格:null）
        $request_item = new Item();
        $request_item->isbn = '9780131495050';
        $request_item->custom_price = 123;
        $request_item->quantity = 1;
        $request_item->title = 'xUnit Test Patterns';
        $request_item->price = 1000;
        $request_item->tax_rate = 0.1;

        $request->items[] = $request_item;

        // 処理
        $response = $service->calculate($request);

        // 結果を評価
        $this->assertEquals(135,$response->total_price,'合計金額');
        $this->assertEquals(12,$response->tax , '消費税');

        // 商品明細を確認
        $item = $response->items[0];
        $this->assertEquals('xUnit Test Patterns',$item->title , '商品名の取得');
        $this->assertEquals('9780131495050',$item->isbn , 'ISBNの取得');
        $this->assertEquals(1,$item->quantity , '商品数量');
        $this->assertEquals(123,$item->custom_price , 'カスタム価格');

        // リポジトリからの取得
        $this->assertEquals(0.1,$item->tax_rate);
        $this->assertEquals(123,$item->subtotal_price);
        $this->assertEquals(12,$item->tax);
        $this->assertEquals(135,$item->total_price);
    }

    /**
     * 商品検索から料金計算までをおこなう試験
     * 複数の商品
     */
    public function test_normal_items(){

        $service = new CalculateService();

        // 計算サービスへのリクエスト
        $request = new CalculateServiceRequest();

        // 商品を追加する（9780131495050:xUnit Test Patterns を 1個 消費税 10% 手動価格:null）
        $request_item = new Item();
        $request_item->isbn = '9780131495050';
        $request_item->custom_price = null;
        $request_item->quantity = 1;
        $request_item->title = 'xUnit Test Patterns';
        $request_item->price = 1000;
        $request_item->tax_rate = 0.1;

        $request->items[] = $request_item;
        $request_item = new Item();
        $request_item->isbn = '9780131495050';
        $request_item->custom_price = null;
        $request_item->quantity = 1;
        $request_item->title = 'xUnit Test Patterns';
        $request_item->price = 1000;
        $request_item->tax_rate = 0.1;

        $request->items[] = $request_item;

        // 処理
        $response = $service->calculate($request);

        // 結果を評価
        $this->assertEquals(2200,$response->total_price,'合計金額');
        $this->assertEquals(200,$response->tax , '消費税');

        // 商品明細を確認
        $item = $response->items[0];
        $this->assertEquals('xUnit Test Patterns',$item->title , '商品名の取得');
        $this->assertEquals('9780131495050',$item->isbn , 'ISBNの取得');
        $this->assertEquals(1,$item->quantity , '商品数量');
        $this->assertEquals(null,$item->custom_price , 'カスタム価格');

        // リポジトリからの取得
        $this->assertEquals(0.1,$item->tax_rate);
        $this->assertEquals(1000,$item->subtotal_price);
        $this->assertEquals(1100,$item->total_price);
        $this->assertEquals(100,$item->tax);

        // 商品明細を確認
        $item2 = $response->items[0];
        $this->assertEquals('xUnit Test Patterns',$item2->title , '商品名の取得');
        $this->assertEquals('9780131495050',$item2->isbn , 'ISBNの取得');
        $this->assertEquals(1,$item2->quantity , '商品数量');
        $this->assertEquals(null,$item2->custom_price , 'カスタム価格');

        // リポジトリからの取得
        $this->assertEquals(0.1,$item2->tax_rate);
        $this->assertEquals(1000,$item2->subtotal_price);
        $this->assertEquals(1100,$item2->total_price);
        $this->assertEquals(100,$item2->tax);
    }
}