<?php
if (!defined('ABSPATH')) exit;

add_action('wp_footer', function () {

    if (!is_cart()) {
        return;
    }

    $wp_user = wp_get_current_user();

    if (!$wp_user || !$wp_user->exists()) {
        return;
    }

    $user_email = strtolower(trim($wp_user->user_email));

    $coupons = get_posts([
        'post_type'      => 'shop_coupon',
        'post_status'    => 'publish',
        'posts_per_page' => -1
    ]);

    $coupon_codes = [];

    foreach ($coupons as $coupon) {

        $allowed_emails = get_post_meta(
            $coupon->ID,
            'customer_email',
            true
        );

        $allowed_emails = maybe_unserialize($allowed_emails);

        if (!empty($allowed_emails)) {

            $allowed_emails = array_map(
                function ($email) {
                    return strtolower(trim($email));
                },
                (array)$allowed_emails
            );

            if (!in_array($user_email, $allowed_emails, true)) {
                continue;
            }
        }

        $coupon_codes[] = $coupon->post_title;
    }

    ?>

    <script>
    jQuery(function($){

        const coupons = <?php echo wp_json_encode($coupon_codes); ?>;

        const timer = setInterval(function(){

            const panel = document.querySelector(
                '.wc-block-components-totals-coupon'
            );

            if(!panel){
                return;
            }

            clearInterval(timer);

            let html = `
                <div class="auth-voucher-list">

                    <strong>Voucher của bạn</strong>
                    <br><br>

                    <select
                        id="auth-coupon-select"
                        style="
                            width:100%;
                            padding:10px;
                            margin-bottom:10px;
                            border:1px solid #ddd;
                            border-radius:6px;
                        "
                    >
                        <option value="">
                            -- Chọn voucher --
                        </option>
            `;

            coupons.forEach(code => {

                html += `
                    <option value="${code}">
                        ${code}
                    </option>
                `;

            });

            html += `

                    </select>

                    <button
                        class="button"
                        id="apply-auth-coupon"
                        style="width:100%;"
                    >
                        Áp dụng
                    </button>

                </div>
            `;

            panel.innerHTML = html;

        },300);

        $(document).on(
            'click',
            '#apply-auth-coupon',
            function(){

                const code = $('#auth-coupon-select').val();

                if(!code){
                    alert('Vui lòng chọn voucher');
                    return;
                }

                $.ajax({

                    url: '<?php echo admin_url('admin-ajax.php'); ?>',

                    type: 'POST',

                    data: {
                        action: 'apply_coupon',
                        coupon_code: code,
                        nonce: '<?php echo wp_create_nonce('apply_coupon_nonce'); ?>'
                    },

                    success: function(res){

                        if(res.success){

                            location.reload();

                        }else{

                            alert(
                                res.data?.message ||
                                'Không áp dụng được coupon'
                            );

                        }

                    },

                    error: function(){

                        alert('Lỗi kết nối');

                    }

                });

            }
        );

    });
    </script>

    <?php
});