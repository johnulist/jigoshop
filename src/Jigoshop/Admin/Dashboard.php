<?php

namespace Jigoshop\Admin;

use Jigoshop\Core\Options;
use Jigoshop\Service\OrderServiceInterface;
use Jigoshop\Service\ProductServiceInterface;

/**
 * Jigoshop dashboard.
 *
 * @package Jigoshop\Admin
 * @author Jigoshop
 */
class Dashboard implements PageInterface
{
	/** @var \Jigoshop\Service\OrderServiceInterface */
	private $orderService;
	/** @var \Jigoshop\Service\ProductServiceInterface */
	private $productService;
	/** @var Options */
	private $options;

	public function __construct(Options $options, OrderServiceInterface $orderService, ProductServiceInterface $productService)
	{
		$this->options = $options;
		$this->orderService = $orderService;
		$this->productService = $productService;
	}

	/**
	 * @return string Title of page.
	 */
	public function getTitle()
	{
		return __('Dashboard', 'jigoshop');
	}

	/**
	 * @return string Required capability to view the page.
	 */
	public function getCapability()
	{
		return 'manage_jigoshop';
	}

	/**
	 * @return string Menu slug.
	 */
	public function getMenuSlug()
	{
		return 'jigoshop';
	}

	/**
	 * Displays the page.
	 */
	public function display()
	{
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');

		add_meta_box('jigoshop_dashboard_right_now', __('Right Now', 'jigoshop'), array($this, 'rightNow'), 'jigoshop', 'side', 'core');
		add_meta_box('jigoshop_dashboard_recent_orders', __('Recent Orders', 'jigoshop'), array($this, 'recentOrders'), 'jigoshop', 'side', 'core');
		if($this->options->get('manage_stock') == 'yes')
		{
			add_meta_box('jigoshop_dashboard_stock_report', __('Stock Report', 'jigoshop'), array($this, 'stockReport'), 'jigoshop', 'side', 'core');
		}
		add_meta_box('jigoshop_dashboard_monthly_report', __('Monthly Report', 'jigoshop'), array($this, 'monthlyReport'), 'jigoshop', 'normal', 'core');
		add_meta_box('jigoshop_dashboard_recent_reviews', __('Recent Reviews', 'jigoshop'), array($this, 'recentReviews'), 'jigoshop', 'normal', 'core');
		add_meta_box('jigoshop_dashboard_latest_news', __('Latest News', 'jigoshop'), array($this, 'latestNews'), 'jigoshop', 'normal', 'core');
		add_meta_box('jigoshop_dashboard_useful_links', __('Useful Links', 'jigoshop'), array($this, 'usefulLinks'), 'jigoshop', 'normal', 'core');

		/** @noinspection PhpUnusedLocalVariableInspection */
		global $submenu;
		include(JIGOSHOP_DIR.'/templates/admin/dashboard.php');
	}

	/**
	 * Displays "Right Now" meta box.
	 */
	public function rightNow()
	{
		$num_posts = wp_count_posts('product');
		/** @noinspection PhpUnusedLocalVariableInspection */
		$productCount = number_format_i18n($num_posts->publish);
		/** @noinspection PhpUnusedLocalVariableInspection */
		$categoryCount = 0;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$tagCount = 0;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$attributesCount = 0;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$pendingCount = 0;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$onHoldCount = 0;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$processingCount = 0;
		/** @noinspection PhpUnusedLocalVariableInspection */
		$completedCount = 0;

		include(JIGOSHOP_DIR.'/templates/admin/dashboard/rightNow.php');
	}

	/**
	 * Displays "Recent Orders" meta box.
	 */
	public function recentOrders()
	{
		/** @noinspection PhpUnusedLocalVariableInspection */
		$orders = $this->orderService->findByQuery(new \WP_Query(array(
			'numberposts' => 10,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post_type' => 'shop_order',
			'post_status' => 'publish'
		)));
		// TODO: Implement after finishing implementing Orders
//		include(JIGOSHOP_DIR.'/templates/admin/dashboard/recentOrders.php');
	}

	/**
	 * Displays "Stock Report" meta box.
	 */
	public function stockReport()
	{
		$lowStockAmount = $this->options->get('notify_low_stock_amount', 1);
		$notifyOufOfStock = $this->options->get('notify_out_of_stock', true);

		if($notifyOufOfStock)
		{
			/** @noinspection PhpUnusedLocalVariableInspection */
			$outOfStock = $this->productService->findOutOfStock();
		}

		/** @noinspection PhpUnusedLocalVariableInspection */
		$lowStock = $this->productService->findLowStock($lowStockAmount);

		include(JIGOSHOP_DIR.'/templates/admin/dashboard/stockReport.php');
	}

	/**
	 * Displays "Monthly Report" meta box.
	 */
	public function monthlyReport()
	{
		//
	}

	/**
	 * Displays "Recent Reviews" meta box.
	 */
	public function recentReviews()
	{
		//
	}

	/**
	 * Displays "Latest News" meta box.
	 */
	public function latestNews()
	{
		//
	}

	/**
	 * Displays "Useful Links" meta box.
	 */
	public function usefulLinks()
	{
		//
	}
}