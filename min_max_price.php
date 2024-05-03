<?php
    $sqlMinPrice = "SELECT MIN(price) AS minPrice FROM products";
    $resultMinPrice = $connect->query($sqlMinPrice);

    $minPriceRow = $resultMinPrice->fetch_assoc();
    $minPrice = $minPriceRow['minPrice'];

    $sqlMaxPrice = "SELECT MAX(price) AS maxPrice FROM products";
    $resultMaxPrice = $connect->query($sqlMaxPrice);

    $maxPriceRow = $resultMaxPrice->fetch_assoc();
    $maxPrice = $maxPriceRow['maxPrice'];
?>