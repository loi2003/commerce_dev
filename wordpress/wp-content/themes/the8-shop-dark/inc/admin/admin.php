<?php
/**
 * Theme admin notifications / welcome page
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'The8Shop_Notify_Admin' ) ) :
class The8Shop_Notify_Admin{
	/**
	 * Theme name.
	 *
	 * @var string
	 */
	protected $theme_name;
	/**
	 * Pro version URL.
	 *
	 * @var string
	 */
	protected $pro_url;
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->theme_name = apply_filters(
			'the8_theme_name',
			'The8 shop'
		);
		$this->pro_url = apply_filters(
			'the8_pro_url',
			'https://athemeart.com/downloads/the8-shop-pro/'
		);
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 5 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ), 99 );
		add_action(
			'wp_ajax_the8_shop_dismiss_notice',
			array( $this, 'dismiss_nux' )
		);
		add_action(
			'after_switch_theme',
			array( $this, 'the8_shop_setup_options' )
		);
	}

	/**
	 * Reset notice on theme activation.
	 */
	public function the8_shop_setup_options() {
		update_option(
			'the8_admin_notice_dismissed',
			false
		);
	}

	/**
	 * Enqueue admin assets.
	 */
	public function enqueue_scripts() {
		global $wp_customize;

		if ( isset( $wp_customize ) ) {
			return;
		}
		wp_enqueue_style(
			'the8-shop-admin',
			get_template_directory_uri() . '/assets/admin/admin.css',
			array(),
			'1.0.0'
		);
		wp_enqueue_script(
			'the8-shop-admin',
			get_template_directory_uri() . '/assets/admin/admin.js',
			array( 'jquery', 'updates' ),
			'1.0.0',
			true
		);
		wp_localize_script(
			'the8-shop-admin',
			'the8ShopNUX',
			array(
				'nonce' => wp_create_nonce(
					'the8_shop_notice_dismiss'
				),
			)
		);
	}

	/**
	 * Show admin notice.
	 */
	public function admin_notices() {
		global $pagenow;
		if (
			'themes.php' !== $pagenow ||
			get_option(
				'the8_admin_notice_dismissed'
			)
		) {
			return;
		}
		if (
			! current_user_can( 'install_plugins' ) ||
			! current_user_can( 'activate_plugins' )
		) {
			return;
		}
		?>

		<div class="notice notice-info sf-notice-nux is-dismissible">
			<div class="notice-content">
				<h4>
					<?php esc_html_e(
						'Thank you for choosing The8 Shop! To enjoy all features, please install and activate the recommended plugins.',
						'the8-shop-dark'					); ?>
				</h4>

				<p class="submit">
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=welcome' ) ); ?>" class="button button-primary">
						<?php esc_html_e( 'Get Started', 'the8-shop-dark'); ?>
					</a>

					<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-secondary">
						<?php esc_html_e( 'Install Plugins', 'the8-shop-dark'); ?>
					</a>
				</p>
			</div>
		</div>

		<?php
	}

	/**
	 * Dismiss notice via AJAX.
	 */
	public function dismiss_nux() {
		$nonce = ! empty( $_POST['nonce'] )
			? sanitize_text_field( wp_unslash( $_POST['nonce'] ) )
			: '';

		if (
			! $nonce ||
			! wp_verify_nonce(
				$nonce,
				'the8_shop_notice_dismiss'
			) ||
			! current_user_can( 'manage_options' )
		) {
			wp_die();
		}

		if (
			empty( $_POST['action'] ) ||
			'the8_shop_dismiss_notice' !== $_POST['action']
		) {
			wp_die();
		}

		update_option(
			'the8_admin_notice_dismissed',
			true
		);

		wp_die();
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		add_theme_page(
			esc_html__( 'The8 Shop', 'the8-shop-dark'),
			esc_html__( 'The8 Shop', 'the8-shop-dark'),
			'activate_plugins',
			'welcome',
			array( $this, 'welcome_screen' )
		);
	}

	/**
	 * Welcome page.
	 */
	public function welcome_screen() {
		?>
		<div class="the8-header">
			<h1><?php echo esc_html( $this->theme_name ); ?></h1>

			<a class="the8-upgrade" target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( $this->pro_url ); ?>">
				<?php esc_html_e( 'Upgrade Now', 'the8-shop-dark'); ?>
			</a>

			<div class="clearfix"></div>
		</div>

		<div class="the8-row-container">
			<div class="the8-row">

				<div class="the8-col-3">
					<div class="the8-box">
						<div class="the8-box-top">
							<?php esc_html_e( 'Theme Customizer', 'the8-shop-dark'); ?>
						</div>

						<div class="the8-box-content">
							<p><?php esc_html_e( 'All free theme options are available in the Customizer, while Pro options and settings are located in the Theme Options panel..', 'the8-shop-dark'); ?></p>

							<p>
								<a href="<?php echo esc_url( admin_url( 'customize.php' ) ); ?>" class="button action-btn">
									<?php esc_html_e( 'Customize', 'the8-shop-dark'); ?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="the8-col-3">
					<div class="the8-box">
						<div class="the8-box-top">
							<?php esc_html_e( 'Ready to Import Sites', 'the8-shop-dark'); ?>
						</div>

						<div class="the8-box-content">
							

							<?php if ( is_plugin_active( 'athemeart-theme-helper/athemeart-theme-helper.php' ) ) : ?>
								<p><?php esc_html_e( 'Import your favorite starter site demo content with just one click.', 'the8-shop-dark'); ?></p>
								<p>
									<a href="<?php echo esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) ); ?>" class="button action-btn">
										<?php esc_html_e( 'See Library', 'the8-shop-dark'); ?>
									</a>
								</p>

							<?php else : ?>
								<p>
									<p><?php esc_html_e( 'Make sure you have installed and activated the recommended plugins, especially aThemeArt Demo Import, so you can access all demo websites.', 'the8-shop-dark'); ?></p>
								</p>

							<?php endif; ?>
						</div>
					</div>
				</div>

				<div class="the8-col-3">
				<div class="the8-box">
					<div class="the8-box-top">
						<?php esc_html_e( 'Recommended Plugins', 'the8-shop-dark'); ?>
					</div>

					<div class="the8-box-content">

						<?php
						$has_plugins = false;

						if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
							$plugins = $GLOBALS['tgmpa']->plugins;

							if ( ! empty( $plugins ) ) {
								foreach ( $plugins as $plugin ) {

									$slug = isset( $plugin['slug'] ) ? $plugin['slug'] : '';

									if ( ! empty( $slug ) && ! is_plugin_active( $slug . '/' . $slug . '.php' ) ) {
										$has_plugins = true;
										break;
									}
								}
							}
						}
						?>

						<?php if ( $has_plugins ) : ?>

							<p><?php esc_html_e( 'Install the recommended plugins to unlock all features.', 'the8-shop-dark'); ?></p>

							<p>
								<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button action-btn">
									<?php esc_html_e( 'Install Plugins', 'the8-shop-dark'); ?>
								</a>
							</p>

						<?php else : ?>

							<p><?php esc_html_e( 'Thank you for installing the recommended plugins.', 'the8-shop-dark'); ?></p>

						<?php endif; ?>

					</div>
				</div>
				</div>

				<div class="clearfix"></div>
			</div>

			<div class="the8-row">

				<div class="the8-col-3" style="width:62%;">
					<div class="the8-box">
						<div class="the8-box-top">
							<?php esc_html_e( 'Changelog', 'the8-shop-dark'); ?>
						</div>

						<div class="the8-box-content">
							<code class="cd-box-content cd-modules">
								<?php
								global $wp_filesystem;

								$changelog_file = apply_filters(
									'athemeart_changelog_file',
									get_template_directory() . '/readme.txt'
								);

								if (
									$changelog_file &&
									is_readable( $changelog_file )
								) {
									WP_Filesystem();

									$changelog = $wp_filesystem->get_contents(
										$changelog_file
									);

									echo wp_kses_post(
										$this->parse_changelog( $changelog )
									);
								}
								?>
							</code>
						</div>
					</div>
				</div>

				<div class="the8-col-3">
					<div class="the8-box">
						<div class="the8-box-top">
							<?php esc_html_e( 'Need More Features?', 'the8-shop-dark'); ?>
						</div>

						<div class="the8-box-content">
							<p><?php esc_html_e( 'Get the Pro version for more demos, elements, and theme options.', 'the8-shop-dark'); ?></p>

							<p>
								<a target="_blank" rel="noopener noreferrer" href="<?php echo esc_url( $this->pro_url ); ?>" class="button action-btn">
									<?php esc_html_e( 'Upgrade to PRO', 'the8-shop-dark'); ?>
								</a>
							</p>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
			</div>
		</div>
		<?php
	}

	/**
	 * Parse changelog text.
	 *
	 * @param string $content File content.
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}
}

endif;

return new The8Shop_Notify_Admin();