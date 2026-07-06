<?php

class SO_Loader
{
    public function __construct()
    {
        $this->includes();

        new SO_Cart();
        new SO_Product();
        new SO_Order();

        add_action('init', [$this, 'add_rewrite_rules']);
        add_filter('query_vars', [$this, 'add_query_vars']);
        add_action('init', function () {
            if (isset($_GET['sa_logout'])) {
                sa_logout();
        }
        });

        add_action(
            'template_redirect',
            [$this, 'template_loader']
        ); // Load custom templates

        add_filter(
            'woocommerce_product_get_permalink',
            [$this, 'override_permalink'],
            10,
            2
        );
    }

    private function includes()
    {
        require_once plugin_dir_path(__FILE__) . '../../simple-auth/includes/auth-logout.php';
        require_once plugin_dir_path(__FILE__) . 'class-so-product.php';
        require_once plugin_dir_path(__FILE__) . 'class-so-cart.php';
        require_once plugin_dir_path(__FILE__) . 'class-so-order.php';
    }

    public function add_rewrite_rules()
    {
        add_rewrite_rule(
            '^simple-order/?$',
            'index.php?so_page=products',
            'top'
        );

        add_rewrite_rule(
            '^simple-order/product/([^/]+)/?$',
            'index.php?so_page=product&product_slug=$matches[1]',
            'top'
        );

        add_rewrite_rule(
            '^simple-order/cart/?$',
            'index.php?so_page=cart',
            'top'
        );
    }

    public function add_query_vars($vars)
    {
        $vars[] = 'so_page';
        $vars[] = 'product_slug';

        return $vars;
    }

    public function template_loader()
    {
        $page = get_query_var('so_page');

        if (!$page) {
            return;
        }

        if (!session_id()) {
            session_start();
        }

        switch ($page) {

            case 'product':
                include plugin_dir_path(__FILE__) . '../views/product-detail.php';
                exit;

            case 'cart':
                include plugin_dir_path(__FILE__) . '../views/cart.php';
                exit;

            case 'products':
            default:
                include plugin_dir_path(__FILE__) . '../views/products.php';
                exit;
        }
    }

    public function override_permalink($permalink, $product)
    {
        return home_url(
            '/simple-order/product/' .
            $product->get_slug()
        );
    }
}
