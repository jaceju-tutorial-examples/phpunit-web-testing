<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Lab4</title>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="/css/main.css"/>
</head>

<body>
<hr>
<div class="container">
    <div class="wrapper">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">商品資訊</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form"
                      method="get" action="calculator.php">
                    <fieldset>
                        <div class="form-group">
                            <label class="control-label col-lg-3"
                                   for="product_name">名稱</label>
                            <div class="col-lg-9">
                                <input class="form-control" placeholder="請輸入商品名稱"
                                       name="product_name" type="text"
                                       value="<?= isset($product_name) ? $product_name : '' ?>" autofocus="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3"
                                   for="product_name">重量</label>
                            <div class="col-lg-9">
                                <input class="form-control" placeholder="請輸入商品重量"
                                       name="product_weight" type="text"
                                       value="<?= isset($product_weight) ? $product_weight : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3"
                                   for="product_name">長度</label>
                            <div class="col-lg-9">
                                <input class="form-control" placeholder="請輸入商品長度"
                                       name="product_length" type="text"
                                       value="<?= isset($product_length) ? $product_length : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3"
                                   for="product_name">寬度</label>
                            <div class="col-lg-9">
                                <input class="form-control" placeholder="請輸入商品寬度"
                                       name="product_width" type="text"
                                       value="<?= isset($product_width) ? $product_width : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3"
                                   for="product_name">高度</label>
                            <div class="col-lg-9">
                                <input class="form-control" placeholder="請輸入商品高度"
                                       name="product_height" type="text"
                                       value="<?= isset($product_height) ? $product_height : '' ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-3"
                                   for="shipper_id">物流商</label>
                            <div class="col-lg-9">
                                <?php $shipperId = isset($shipperId) ? $shipperId : '' ?>
                                <select name="shipper_id" id="shipper_id">
                                    <option value="" <?php if ($shipperId ===
                                    ''): ?>selected<?php endif; ?>>請選擇
                                    </option>
                                    <option value="1" <?php if ($shipperId ===
                                    '1'): ?>selected<?php endif; ?>>黑貓快遞
                                    </option>
                                    <option value="2" <?php if ($shipperId ===
                                    '2'): ?>selected<?php endif; ?>>新竹貨運
                                    </option>
                                    <option value="3" <?php if ($shipperId ===
                                    '3'): ?>selected<?php endif; ?>>郵局
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-sm btn-success">計算運費</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="panel-footer">
                <p>物流商： <span id="shipper_name"><?= isset($shipperName) ? $shipperName : '(請選擇)' ?></span></p>
                <p>運費： <span id="freight"><?= isset($freight) ? $freight : '0' ?></span></p>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script src="/js/main.js"></script>
</body>

</html>
