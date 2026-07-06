<?php

class SO_Cart
{
    public function __construct()
    {
        add_action('wp_ajax_so_add_to_cart', [$this, 'add_to_cart']);
        add_action('wp_ajax_nopriv_so_add_to_cart', [$this, 'add_to_cart']);
    }

    public function add_to_cart()
    {
        $product_id = intval($_POST['product_id']);
        $qty        = intval($_POST['quantity']);

        if (!WC()->cart) {
            wc_load_cart();
        }

        WC()->cart->add_to_cart($product_id, $qty);

        wp_send_json_success([
            'message' => 'Added to cart',
            'cart_count' => WC()->cart->get_cart_contents_count()
        ]);
    }
}