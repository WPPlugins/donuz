<?php
/*
 * Plugin Name: Integrador Donuz Woocommerce
 * Plugin URI: http://www.donuz.co/
 * Description: Incremente seu ecommerce com uma plataforma de fidelização de clientes, este plugin permite a integração entre a plataforma woocomerce e a plataforma de fidelização de clientes Donuz
 * Version: 1.1
 * Author: Donuz
 * Author URI: http://www.donuz.co/
*/

require('class/Class_dnz_util.php');
require('class/Class_dnz_base_plugin.php');
require('class/Class_dnz_option.php');
require('class/Class_dnz_curl.php');
require('class/Class_dnz_cron.php');

if (is_admin()) {
    $plugin = new Class_dnz_base_plugin();
}

if (!wp_next_scheduled('dnz_event_task')) {
    wp_schedule_event(time(), 'hourly', 'dnz_event_task');
}

add_action('dnz_event_task', 'dnz_task_cron');

function dnz_task_cron()
{
    $dnz = new Class_dnz_cron();
    $dnz->getDateInDB();
    $sales = $dnz->getSales();
    if (count($sales) > 0) {
        return $dnz->insertPoint($sales);
    }
}
