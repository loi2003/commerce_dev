<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div class="wrap">
    <h1>Audit Log</h1>

    <form method="get">
        <input type="hidden" name="page" value="audit-log-service" />
        <table class="form-table">
            <tr>
                <th><label for="user_email">User (Email)</label></th>
                <td>
                    <select name="user_email" id="user_email">
                        <option value="">Tất cả</option>
                        <?php foreach ( $auth_users as $id => $email ) : ?>
                            <option value="<?php echo esc_attr( $email ); ?>" <?php selected( $filters['user_email'], $email ); ?>>
                                <?php echo esc_html( $email ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="action">Hành động</label></th>
                <td>
                    <select name="action" id="action">
                        <option value="">Tất cả</option>
                        <?php foreach ( $actions as $act ) : ?>
                            <option value="<?php echo esc_attr( $act ); ?>" <?php selected( $filters['action'], $act ); ?>>
                                <?php echo esc_html( $act ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="from_date">Từ ngày</label></th>
                <td><input type="date" name="from_date" id="from_date" value="<?php echo esc_attr( $filters['from_date'] ); ?>" /></td>
            </tr>
            <tr>
                <th><label for="to_date">Đến ngày</label></th>
                <td><input type="date" name="to_date" id="to_date" value="<?php echo esc_attr( $filters['to_date'] ); ?>" /></td>
            </tr>
        </table>
        <?php submit_button( 'Lọc', 'primary', 'filter' ); ?>
    </form>

    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Email</th>
                <th>Hành động</th>
                <th>Đối tượng</th>
                <th>ID đối tượng</th>
                <th>Chi tiết</th>
                <th>IP</th>
                <th>Thời gian</th>
            </tr>
        </thead>
        <tbody>
            <?php if ( $logs ) : ?>
                <?php foreach ( $logs as $log ) : ?>
                    <tr>
                        <td><?php echo esc_html( $log->id ); ?></td>
                        <td><?php echo esc_html( $log->user_id ); ?></td>
                        <td><?php echo esc_html( $log->user_email ); ?></td>
                        <td><?php echo esc_html( $log->action ); ?></td>
                        <td><?php echo esc_html( $log->object_type ); ?></td>
                        <td><?php echo esc_html( $log->object_id ); ?></td>
                        <td><?php echo esc_html( $log->details ); ?></td>
                        <td><?php echo esc_html( $log->ip_address ); ?></td>
                        <td><?php echo esc_html( $log->created_at ); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="9">Không có log nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if ( $total_pages > 1 ) : ?>
        <div class="tablenav">
            <div class="tablenav-pages">
                <?php
                echo paginate_links( array(
                    'base'    => add_query_arg( 'paged', '%#%' ),
                    'format'  => '',
                    'prev_text' => '&laquo;',
                    'next_text' => '&raquo;',
                    'total'   => $total_pages,
                    'current' => $page,
                ) );
                ?>
            </div>
        </div>
    <?php endif; ?>
</div>