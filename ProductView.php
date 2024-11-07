<?php
class ProductView
{
    public function displayProducts($products)
    {
        echo "<div class='product-container'>";
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<a href='product_detail.php?id={$product['id']}'>";
            echo "<img src='{$product['image']}' alt='{$product['name']}' class='product-image' />";
            echo "<h3>{$product['name']}</h3>";
            echo "<p>{$product['prix']} €</p>";
            echo "</a>";
            echo "</div>";
        }
        echo "</div>";
    }
}
?>