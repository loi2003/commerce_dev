<?php
class LCS_Admin {

    private $logger;

    public function __construct() {
        $this->logger = new LoginLogger();
    }

    public function handle_view_log() {
        if (isset($_GET['page']) && $_GET['page'] === 'simple-auth' &&
            isset($_GET['action']) && $_GET['action'] === 'view_log' &&
            isset($_GET['email'])) {

            $email = sanitize_email($_GET['email']);
            $logs = $this->logger->get_logs_by_email($email);

            include LCS_PLUGIN_DIR . 'views/admin-log.php';
            exit;
        }
    }

    public function add_check_log_buttons() {
        if (!isset($_GET['page']) || $_GET['page'] !== 'simple-auth') {
            return;
        }
        ?>
        <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('table.wp-list-table tbody tr').each(function() {
                var $row = $(this);
                var email = $row.find('td:eq(2)').text().trim();
                if (email) {
                    var $actionsCell = $row.find('td:last-child');
                    if ($actionsCell.find('.check-log-btn').length === 0) {
                        var logUrl = '<?php echo admin_url('admin.php?page=simple-auth&action=view_log&email='); ?>' + encodeURIComponent(email);
                        var btn = $('<a href="' + logUrl + '" class="button button-small check-log-btn" style="margin-top:5px; display:inline-block;">Check Log</a>');
                        $actionsCell.append(btn);
                    }
                }
            });
        });
        </script>
        <?php
    }
}