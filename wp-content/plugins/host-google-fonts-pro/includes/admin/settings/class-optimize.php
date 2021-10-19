<?php
defined('ABSPATH') || exit;

/**
 * @package   OMGF Pro
 * @author    Daan van den Bergh
 *            https://ffw.press
 *            https://daan.dev
 * @copyright © 2021 Daan van den Bergh
 * @license   BY-NC-ND-4.0
 *            http://creativecommons.org/licenses/by-nc-nd/4.0/
 */
class OmgfPro_Admin_Settings_Optimize
{
	const GREEN  = '#3D9970';
	const ORANGE = '#FF851B';
	const RED    = '#FF4136';

	/** @var string $plugin_text_domain */
	private $plugin_text_domain = 'omgf-pro';

	/** @var OMGF_Admin_Settings_Builder $builder */
	private $builder;

	/**
	 * OMGF_Admin_Settings_Optimize constructor.
	 */
	public function __construct()
	{
		$this->builder = new OMGF_Admin_Settings_Builder();

		$this->init();
	}

	/**
	 * Init filters and hooks to render Automatic Optimization Mode status screen.
	 * 
	 * @since v3.0.0
	 * 
	 * @return void 
	 */
	private function init()
	{
		add_filter('omgf_optimize_settings_content', [$this->builder, 'do_after'], 31);
		add_filter('omgf_optimize_settings_content', [$this, 'open_automatic_optimization_mode'], 32);
		add_filter('omgf_optimize_settings_content', [$this->builder, 'do_before'], 33);
		add_filter('omgf_optimize_settings_content', [$this, 'automatic_optimization_status'], 34);
		add_filter('omgf_optimize_settings_content', [$this, 'do_batch_size'], 35);
		add_filter('omgf_optimize_settings_content', [$this->builder, 'do_after'], 36);
		add_filter('omgf_optimize_settings_content', [$this, 'close_automatic_optimization_mode'], 37);
		add_filter('omgf_optimize_settings_content', [$this->builder, 'do_before'], 38);
	}

	/**
	 * Opens the Automatic Optimization Mode status screen container.
	 * 
	 * @return void 
	 */
	public function open_automatic_optimization_mode()
	{
?>
		<div class="omgf-automatic-optimization-mode welcome-panel" style="padding: 0 15px 5px; <?= OMGF_PRO_OPTIMIZATION_MODE == 'auto' ? '' : 'display: none;'; ?>">
			<h3><?= __('Automatic Optimization Mode (Pro) Task Manager', $this->plugin_text_domain); ?></h3>
		<?php
	}

	/**
	 * Content of the Automatic Optimization Mode container.
	 * 
	 * @return void 
	 */
	public function automatic_optimization_status()
	{
		$queue           = get_option(OmgfPro_OptimizationMode_Automatic::QUEUE);
		$processed_posts = $queue[OmgfPro_OptimizationMode_Automatic::QUEUE_PROCESSED][OmgfPro_OptimizationMode_Automatic::QUEUE_POSTS] ?? 0;
		$processed_terms = $queue[OmgfPro_OptimizationMode_Automatic::QUEUE_PROCESSED][OmgfPro_OptimizationMode_Automatic::QUEUE_TERMS] ?? 0;
		$total_posts     = $queue[OmgfPro_OptimizationMode_Automatic::QUEUE_TOTAL][OmgfPro_OptimizationMode_Automatic::QUEUE_POSTS] ?? 0;
		$total_terms     = $queue[OmgfPro_OptimizationMode_Automatic::QUEUE_TOTAL][OmgfPro_OptimizationMode_Automatic::QUEUE_TERMS] ?? 0;
		?>
			<tr valign="top">
				<th scope="row"><?= __('Cron Progress (Pro)', $this->plugin_text_domain); ?>
				<td>
					<p>
						<?php $color = $total_posts == 0 ? self::RED : ($processed_posts < $total_posts ? self::ORANGE : self::GREEN); ?>
						<?= __('Posts/Pages', $this->plugin_text_domain); ?>: <span style="color: <?= $color; ?>;"><?= $processed_posts; ?>/<?= $total_posts; ?></span>
					</p>
					<p>
						<?php $color = $total_posts == 0 ? self::RED : ($processed_terms < $total_terms ? self::ORANGE : self::GREEN); ?>
						<?= __('Archives', $this->plugin_text_domain); ?>: <span style="color: <?= $color; ?>;"><?= $processed_terms; ?>/<?= $total_terms; ?></span>
					</p>
					<p class="description">
						<?= __('When Optimization Mode is set to Automatic, all pages, posts and archives (e.g. categories, tags) are processed in batches and checked for the presence of Google Fonts. The cron task runs every two minutes. Refresh this page to check its progress.', $this->plugin_text_domain); ?>
					</p>
					<ul class="legend">
						<li class="red"><?= __('Cron task hasn\'t yet started.', $this->plugin_text_domain); ?> <a id="omgf-pro-run-cron" data-nonce="<?= wp_create_nonce(OmgfPro_Admin_Settings::OMGF_PRO_ADMIN_PAGE); ?>" href="#"><?= sprintf('Run now?', $this->plugin_text_domain); ?></a></li>
						<li class="orange"><?= __('Cron task has processed one or more batches, but isn\'t yet finished.', $this->plugin_text_domain); ?></li>
						<li class="green"><?= __('Cron task has finished processing all posts, pages and archives.', $this->plugin_text_domain); ?></li>
					</ul>
				</td>
			</tr>

			<?php
			// TODO: Move this to separate stylesheet. 
			?>
			<style>
				ul.legend li::before {
					content: "\2022";
					display: inline-block;
					width: .75em;
					margin-left: -.75em;
					font-size: 32px;
					line-height: 0px;
					vertical-align: -5px;
				}

				ul.legend li.red::before {
					color: <?= self::RED; ?>;
				}

				ul.legend li.orange::before {
					color: <?= self::ORANGE; ?>;
				}

				ul.legend li.green::before {
					color: <?= self::GREEN; ?>;
				}
			</style>
		<?php
	}

	/**
	 * @return void 
	 */
	public function do_batch_size()
	{
		$this->builder->do_number(
			__('Cron Batch Size (Pro)', $this->plugin_text_domain),
			OmgfPro_Admin_Settings::OMGF_OPTIMIZE_SETTING_BATCH_SIZE,
			OMGF_PRO_BATCH_SIZE,
			'Increase the batch size number, if you have a large site. Setting this number to a higher value will increase the load each cron task will put on your server. A too high value might cause timeouts and prevent the cron task to finish properly.',
			1
		);
	}

	/**
	 * Close the container.
	 * 
	 * @return void 
	 */
	public function close_automatic_optimization_mode()
	{
		?>
		</div>
<?php
	}
}
