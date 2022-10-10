<?php

/**
 * Shopify Analytics
 *
 * @package     ShopifyAnalytics
 * @author      Henri Susanto
 * @copyright   2022 Henri Susanto
 * @license     GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Shopify Analytics
 * Plugin URI:  https://github.com/susantohenri
 * Description: Analyse shopify shop
 * Version:     1.0.0
 * Author:      Henri Susanto
 * Author URI:  https://github.com/susantohenri
 * Text Domain: shopifyAnalytics
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

add_shortcode('shopify-analytics', function () {
    wp_register_style('shopify-analytics', plugin_dir_url(__FILE__) . 'shopify-analytics.css');
    wp_enqueue_style('shopify-analytics');

    wp_register_script('shopify-analytics', plugin_dir_url(__FILE__) . 'shopify-analytics.js');
    wp_enqueue_script('shopify-analytics');
    wp_localize_script(
        'shopify-analytics',
        'shopify_analytics',
        array(
            'analytics_url' => site_url('wp-json/shopify-analytics/v1/analyse'),
        )
    );

    return "
        <div class='shopify-analytics'>
            <div class='container'>
                <div class='row search-form'>
                    <div class='col-sm-8'>
                        <input name='site-url' type='url' id='url' placeholder='Add a URL' class='form-control'>
                    </div>
                    <div class='col-sm-4'>
                        <button class='btn btn-warning btn-block form-submit' onclick='shopifyAnalyse()'>Analyse</button>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-sm-12'>
                        <div class='results error d-none'>
                            <h2 class='text-center resultMSG'>
                            </h2>
                        </div>

                        <div class='results not-shopify d-none'>
                            <h2 class='text-center resultMSG'>
                            </h2>
                        </div>

                        <div class='results success d-none'>
                            <h2 class='text-center resultMSG'>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    ";
});

add_action('rest_api_init', function () {
    register_rest_route('shopify-analytics/v1', '/analyse', array(
        'methods' => 'POST',
        'callback' => function () {
            $response = [];
            return json_encode($response);
        }
    ));
});