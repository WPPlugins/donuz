<?php

/**
 * Classe que executa o cron
 *
 * @class           Class_dnz_cron
 * @package         Donuz
 * @author          Robson Alves
 * @copyright       Copyright © 2015
 *
 */
class Class_dnz_cron extends Class_dnz_curl
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getDateInDB()
    {
        $token = get_option('dnz_token_donuz');
        $id = get_option('dnz_id_estabelecimento');

        if ($id != false && $token != false) {
            $this->token = $token;
            $this->id = $id;
        }
    }

    public function getSales()
    {
        $data = get_option("dnz_date_start");
        global $wpdb;
        $sql = "
			SELECT meta.*
			from " . $wpdb->prefix . "posts as post
			inner join " . $wpdb->prefix . "postmeta as meta on post.ID = meta.post_id
			where post.post_type = 'shop_order'
			and post.post_status = 'wc-completed'
			and post.post_modified >= '$data'
		";
        $result = $wpdb->get_results($sql);

        $data = array();
        foreach ($result as $key => $value) {
            $data[$value->post_id][$value->meta_key] = $value->meta_value;
        }

        return $this->formatData($data);
    }

    private function formatData($data)
    {
        $sales = array();
        foreach ($data as $key => $value) {
            $sales[$key] = array();
            foreach ($value as $k => $v) {
                if ($k == "_billing_email")
                    $sales[$key]['cliente'] = $v;
                else if ($k == "_order_total")
                    $sales[$key]['valor'] = $v;
                else if ($k == "_payment_method_title")
                    $sales[$key]['descricao'] = "Id do pedido = {$key} - Forma de pagamento = {$v}";
            }
        }
        return $sales;
    }

    public function insertPoint($data)
    {
        foreach ($data as $key => $value) {

            $headers = array('Token: ' . $this->token);
            $sale['acao'] = 'inserir';
            $sale['estabelecimento'] = $this->id;
            $sale['cliente'] = $value['cliente'];
            $sale['valor'] = $value['valor'];
            $sale['descricao'] = $value['descricao'];

            $insert = $this->exec($this->urlApi, $headers, $sale);

            $log = '{"Status": "' . $insert->status;
            $log .= '", "Mensagem": "' . $insert->mensagem;
            $log .= '", "Data": "' . date("Y-m-d H:i:s") . '"}';

            $log_exec = get_option("dnz_log_exec");
            update_option("dnz_log_exec", $log_exec + 1);
            add_option("dnz_log_" . ($log_exec + 1), $log);
        }
    }
}