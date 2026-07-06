<?php
$products = wc_get_products(['limit' => 20]);
?>

<h1>THIS IS MY SIMPLE ORDER PAGE</h1>
<?php foreach ($products as $p): ?>
    <div>
        <h3><?= esc_html($p->get_name()); ?></h3>
        <a href="<?= home_url('/simple-order/product/' . $p->get_slug()); ?>">View</a>
    </div>
<?php endforeach; ?>


<a href="<?= home_url('/simple-order/cart'); ?>">Go Cart</a>
<a href="<?php echo home_url('/?sa_logout=1'); ?>" 
   style="display:inline-block;margin-top:20px;padding:10px 15px;background:red;color:#fff;text-decoration:none;border-radius:6px;">
    Logout
</a>