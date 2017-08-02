<?php

/**
 * Classe responsável por efetuar todas as configurações iniciais do plugin
 *
 * @class           Class_dnz_base_plugin
 * @package         Donuz
 * @author          Robson Alves
 * @copyright       Copyright © 2015
 *
 */
class Class_dnz_base_plugin
{
    function __construct()
    {
        $this->init();

        if (isset($_GET['action']) && !empty($_GET['action'])) {
            $this->router();
        }
    }

    public function init()
    {
        add_action('admin_init', array($this, 'add_scripts'));
        add_action('admin_menu', array($this, 'add_menu'));

        add_option("dnz_log_exec", 0);
        add_option("dnz_date_start", date('Y-m-d h:i:s'));
    }

    public function add_scripts()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-form');
        wp_enqueue_script(
            'dnz_request_js',
            plugins_url("/assets/js/requests.js", __FILE__),
            array('jquery', 'jquery-form'),
            '1.0.0',
            true
        );
    }

    public function add_menu()
    {
        if (function_exists('add_menu_page')) {
            add_submenu_page(
                'woocommerce',
                Class_dnz_util::PLUGIN_NAME,
                Class_dnz_util::PLUGIN_NAME,
                'manage_options',
                Class_dnz_util::PLUGIN_SLUG,
                array(&$this, 'home')
            );
        }
    }

    public function home()
    {
        $estabelecimentoID = get_option('dnz_id_estabelecimento');
        $tokenDonuz = get_option('dnz_token_donuz');
        include_once "views/inicio.php";
    }

    private function router()
    {
        $action = (isset($_GET['action']) && !empty($_GET['action'])) ? $_GET['action'] : null;

        switch ($action) {
            case 'save_options':
                $op = new Class_dnz_option();
                $op->save($_POST);
                break;
        }
    }

    private function page_tabs($current = 'configuracoes')
    {
        $tabs = array(
            'configuracoes' => __("Configurações", 'Configuracoes')
            // 'logs'  => __("Logs", 'logs')
        );
        $html = '<h2 class="nav-tab-wrapper">';
        foreach ($tabs as $tab => $name) {
            $class = ($tab == $current) ? 'nav-tab-active' : '';
            $html .= '<a class="nav-tab ' . $class . '" href="?page=integrador_donuz&tab=' . $tab . '">' . $name . '</a>';
        }
        $html .= '</h2>';
        echo $html;
    }
}