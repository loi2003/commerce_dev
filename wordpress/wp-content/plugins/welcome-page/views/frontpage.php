<?php
function sa_home_shop_full()
{
    $categories = get_terms([
        'taxonomy'   => 'product_cat',
        'hide_empty' => true,
    ]);

    if (empty($categories) || is_wp_error($categories)) {
        return '<div>No categories found</div>';
    }

    ob_start();
    ?>

    <div class="sa-home">

        <?php foreach ($categories as $cat): ?>

            <?php
            $products = wc_get_products([
                'limit'   => 20,
                'status'  => 'publish',
                'category'=> [$cat->slug],
            ]);

            if (!is_array($products) || count($products) === 0) {
                continue;
            }
            ?>

            <section class="sa-block">

                <h2 class="sa-title">
                    <?php echo esc_html($cat->name); ?>
                </h2>

                <div class="sa-slider">

                    <?php foreach ($products as $product): ?>

                        <div class="sa-card">

                            <a href="<?php echo esc_url($product->get_permalink()); ?>">

                                <div class="sa-img">
                                    <?php echo $product->get_image('medium'); ?>
                                </div>

                                <div class="sa-info">

                                    <div class="sa-name">
                                        <?php echo esc_html($product->get_name()); ?>
                                    </div>

                                    <div class="sa-price">
                                        <?php echo wp_kses_post($product->get_price_html()); ?>
                                    </div>

                                </div>

                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>

            </section>

        <?php endforeach; ?>

    </div>

    <?php
    return ob_get_clean();
}

add_action('init', function () {
    add_shortcode('sa_home', 'sa_home_shop_full');
});

