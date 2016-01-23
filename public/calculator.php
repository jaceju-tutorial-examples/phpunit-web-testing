<?php

$shipperId = $_GET['shipper_id'];

if ($shipperId === '1') {

    $shipperName = '黑貓快遞';

    $weight = floatval($_GET['product_weight']);
    if ($weight > 20) {
        $freight = 500;
    } else {
        $freight = 100 + $weight * 10;
    }

} elseif ($shipperId === '2') {

    $shipperName = '新竹貨運';

    $length = floatval($_GET['product_length']);
    $width  = floatval($_GET['product_width']);
    $height = floatval($_GET['product_height']);

    $size = $length * $width * $height;

    // 長 x 寬 x 高（公分）x 0.0000353
    if ($length > 100 || $width > 100 || $height > 100) {
        $freight = floatval($size * 0.0000353 * 1100 + 500);
    } else {
        $freight = floatval($size * 0.0000353 * 1200);
    }

} elseif ($shipperId === '3') {
    $shipperName = '郵局';

    $weight = floatval($_GET['product_weight']);
    $freightByWeight = 80 + $weight * 10;

    $length = floatval($_GET['product_length']);
    $width  = floatval($_GET['product_width']);
    $height = floatval($_GET['product_height']);
    $size = $length * $width * $height;
    $freightBySize = $size * 0.0000353 * 1100;

    if ($freightByWeight < $freightBySize) {
        $freight = $freightByWeight;
    } else {
        $freight = $freightBySize;
    }

} else {
    $shipperName = '(請選擇)';
    $freight = 0;
}

$result = array_merge(compact('shipperName', 'freight', 'shipperId'), $_GET);

echo json_encode($result);
