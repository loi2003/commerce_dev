<?php $cart = WC()->cart->get_cart(); ?>

<h2>Cart</h2>

<?php foreach ($cart as $item): ?>
    <div>
        <?= esc_html($item['data']->get_name()); ?>
        x <?= (int) $item['quantity']; ?>
    </div>
<?php endforeach; ?>

<button type="button" onclick="createOrder()">
    Checkout
</button>

<script>
async function createOrder()
{
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
                    action: 'so_create_order'
                })
            }
        );

        const data = await response.json();

        if (data.success) {

            alert(
                'Order #' +
                data.data.order_id +
                ' created'
            );

            window.location.reload();

        } else {

            alert(
                data.data.message
            );

        }

    } catch (e) {

        console.error(e);
        alert('Server Error');

    }
}
</script>