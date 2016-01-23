# Lab4 - 網頁自動化測試

## 安裝 Selenium IDE

打開 Firefox ，瀏覽以下網址：

```
https://addons.mozilla.org/zh-TW/firefox/addon/selenium-ide/
```

按下「新增至 Firefox 」安裝，再重新啟動 Firefox 。

## 用 Selenium IDE 錄製自動化測試

1. 打開 Selenium IDE ，確定錄製鈕是按下的狀態。
2. 在商品名稱上輸入： `book` 。
3. 重量輸入 `10` 。
4. 長度輸入 `30` 。
5. 寬度輸入 `20` 。
6. 高度輸入 `10` 。
7. 物流商選`黑貓快遞` 。
8. 按下`計算運費` 。
9. 在下方結果區的`黑貓快遞`上按滑鼠右鍵，選 `Show All Available Commands` > `assertText id=shipper_name 黑貓快遞`。
10. 在數字 `200` 上按滑鼠右鍵，選 `Show All Available Commands` > `assertText id=freight 200` 。
11. 物流商選`新竹貨運`，重覆步驟 8 ~ 10 。
12. 物流商選`郵局`，重覆步驟 8 ~ 10 。
13. 停止錄製，重新執行一次測試看是否完全正確。
14. 將測試結果存到 `tests/CalculateFreight.html` 中。

## 重構程式碼

### 整理結構

先理解每段程式碼的目題是什麼，然後為它們加上註解。

將使用 `$_GET` 帶進來的參數，全部移到 `if...else` 之外：

```php
$shipperId = $_GET['shipper_id'];
$weight = floatval($_GET['product_weight']);
$length = floatval($_GET['product_length']);
$width  = floatval($_GET['product_width']);
$height = floatval($_GET['product_height']);
```

執行測試。

### 提煉方法

將判斷為黑貓快遞便執行的程式碼區段提煉成 `calculateFreightByBlackCat` 函式：

```php
$freight = calculateFreightByBlackCat($weight);
```

```php
/**
 * @param $weight
 * @return int
 */
function calculateFreightByBlackCat($weight)
{
    if ($weight > 20) {
        $freight = 500;
        return $freight;
    } else {
        $freight = 100 + $weight * 10;
        return $freight;
    }
}
```

將判斷為新竹貨運便執行的程式碼區段提煉成 `calculateFreightByHsinchu` 函式：

```php
$freight = calculateFreightByHsinchu($length, $width, $height);
```

```php
/**
 * @param $length
 * @param $width
 * @param $height
 * @return string
 */
function calculateFreightByHsinchu($length, $width, $height)
{
    $size = $length * $width * $height;
    // 長 x 寬 x 高（公分）x 0.0000353
    if ($length > 100 || $width > 100 || $height > 100) {
        $freight = strval($size * 0.0000353 * 1100 + 500);
        return $freight;
    } else {
        $freight = strval($size * 0.0000353 * 1200);
        return $freight;
    }
}
```

將判斷為郵局便執行的程式碼區段提煉成 `calculateFreightByPostOffice` 函式：

```php
$freight = calculateFreightByPostOffice($weight, $length, $width, $height);
```

```php
/**
 * @param $weight
 * @param $length
 * @param $width
 * @param $height
 * @return int
 */
function calculateFreightByPostOffice($weight, $length, $width, $height)
{
    $freightByWeight = 80 + $weight * 10;
    $size = $length * $width * $height;
    $freightBySize = $size * 0.0000353 * 1100;

    if ($freightByWeight < $freightBySize) {
        $freight = $freightByWeight;
        return $freight;
    } else {
        $freight = $freightBySize;
        return $freight;
    }
}
```

執行測試。

### 引入參數物件

建立 `src/ShippingProduct.php` ，內容為 `Lab4\ShippingProduct` 類別：

```php
<?php

namespace Lab4;

class ShippingProduct
{
    private $weight;
    private $length;
    private $width;
    private $height;
    private $size;

    public function __construct($weight, $length, $width, $height)
    {

        $this->weight = $weight;
        $this->length = $length;
        $this->width = $width;
        $this->height = $height;
        $this->size = $length * $width * $height;
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }
}
```

在 `calculator.php` 最上面加入：

```php
require_once __DIR__ . '/../vendor/autoload.php';
```

建立參數物件：

```php
$product = new ShippingProduct($weight, $length, $width, $height);
```

改用參數物件：

```php
$freight = $this->calculateFreightByBlackCat($product);
```

修正 `calculateFreightByBlackCat` 函式：

```php
function calculateFreightByBlackCat(ShippingProduct $product)
{
    if ($product->weight > 20) {
        $freight = 500;
        return $freight;
    } else {
        $freight = 100 + $product->weight * 10;
        return $freight;
    }
}
```

執行測試。

`calculateFreightByHsinchu` 及 `calculateFreightByPostOffice` 以此類推。

### 提煉類別

建立 `src/BlackCat.php` ，內容如下：

```php
<?php

namespace Lab4;

class BlackCat
{
    public function getName()
    {
        return '黑貓快遞';
    }

    public function calculateFreight(ShippingProduct $product)
    {
        if ($product->weight > 20) {
            $freight = 500;
        } else {
            $freight = 100 + $product->weight * 10;
        }
        return $freight;
    }
}
```

將原來的：

```php
$shipperName = '黑貓快遞';
$freight = calculateFreightByBlackCat($product);
```

改為：

```php
$shipper = new BlackCat();
$shipperName = $shipper->getName();
$freight = $shipper->calculateFreight($product);
```

執行測試。

新竹貨運及郵局以此類推。

### 引入 Null Object

建立 `src/NoShipper.php` ，內容為：

```php
<?php

namespace Lab4;

class NoShipper
{
    public function getName()
    {
        return '(請選擇)';
    }

    public function calculateFreight(ShippingProduct $product)
    {
        return 0;
    }
}
```

將：

```php
$shipperName = '(請選擇)';
$freight = 0;
```

改為：

```php
$shipper = new NoShipper();
$shipperName = $shipper->getName();
$freight = $shipper->calculateFreight($product);
```

執行測試。

### 提煉介面

建立 `src/IShipper.php` ，內容為：

```php
<?php

namespace Lab4;

interface IShipper
{
    public function getName();
    public function calculateFreight(ShippingProduct $product);
}
```

將 `BlackCat` 、 `Hsinchu` 、 `PostOffice` 、 `NoShipper` 等類別，加上 `implements IShipper` ：

```php
class BlackCat implements IShipper
```

最後把 `if...else` 中的：

```php
$shipperName = $shipper->getName();
$freight = $shipper->calculateFreight($product);
```

移出判斷式外。

執行測試。

### 將生成物件的職責獨立出來

將 `if...else` 提煉成 `createShipper` 函式：

```php
createShipper($shipperId)
{
    if ($shipperId === '1') {
        // 選擇黑貓快遞計算運費
        $shipper = new BlackCat();
        return $shipper;
    } elseif ($shipperId === '2') {
        // 選擇新竹貨運計算運費
        $shipper = new Hsinchu();
        return $shipper;
    } elseif ($shipperId === '3') {
        // 選擇郵局計算運費
        $shipper = new PostOffice();
        return $shipper;
    } else {
        $shipper = new NoShipper();
        return $shipper;
    }
}
```