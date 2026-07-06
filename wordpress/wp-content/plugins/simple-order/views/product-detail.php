<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!session_id()) {
    session_start();
}

$slug = get_query_var('product_slug');

if (!$slug) {
    wp_die('Product slug not found');
}

$products = wc_get_products([
    'slug'  => $slug,
    'limit' => 1,
]);

$product = $products[0] ?? null;

if (!$product) {
    wp_die('Product not found');
}

$product_id = $product->get_id();

?>

<div class="so-product-detail">

    <h1>
        <?= esc_html($product->get_name()); ?>
    </h1>

    <?php if ($product->get_image_id()) : ?>

        <div class="so-product-image">
            <?= wp_get_attachment_image(
                $product->get_image_id(),
                'large'
            ); ?>
        </div>

    <?php endif; ?>

    <div class="so-product-price">
        <?= $product->get_price_html(); ?>
    </div>

    <div class="so-product-description">
        <?= wpautop(
            $product->get_description()
        ); ?>
    </div>

    <div class="so-product-qty">

        <label for="qty">
            Quantity
        </label>

        <input
            type="number"
            id="qty"
            value="1"
            min="1"
        >

    </div>

    <button
        type="button"
        onclick="addToCart(<?= $product_id ?>)"
    >
        Add To Cart
    </button>

</div>

<script>

async function addToCart(productId)
{
    const qty =
        document.getElementById('qty').value;

    try {

        const response = await fetch(
            '/wp-admin/admin-ajax.php',
            {
                method: 'POST',
                headers: {
                    'Content-Type':
                    'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    action: 'so_add_to_cart',
                    product_id: productId,
                    quantity: qty
                })
            }
        );

        const data =
            await response.json();

        if (data.success) {

            alert(
                data.data?.message ??
                'Added to cart'
            );

        } else {

            alert(
                data.data?.message ??
                'Add to cart failed'
            );

        }

    } catch (error) {

        console.error(error);

        alert(
            'Server error'
        );

    }
}

</script>