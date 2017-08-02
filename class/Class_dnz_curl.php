<?php

/**
 * Classe que envia as vendas para a API da Donuz via Curl
 *
 * @class           Class_dnz_curl
 * @package         Donuz
 * @author          Robson Alves
 * @copyright       Copyright © 2015
 *
 */
class Class_dnz_curl
{
    protected $urlApi;
    protected $token;
    protected $id;

    public function __construct()
    {
        $this->urlApi = Class_dnz_util::URL_API;
    }

    protected function exec($url, $headers = null, $dados = null)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        if (!is_null($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if (!is_null($dados)) {
            if (is_array($dados) || is_object($dados)) {
                $dados = json_encode($dados);
            }

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $output = json_decode(curl_exec($ch));

        curl_close($ch);

        return $output;
    }
}