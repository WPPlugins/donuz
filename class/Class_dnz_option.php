<?php

/**
 * Classe de crud das informações do usuario
 *
 * @class           Class_dnz_option
 * @package         Donuz
 * @author          Robson Alves
 * @copyright       Copyright © 2015
 *
 */
class Class_dnz_option
{
    public function save($data)
    {
        if (
            isset($data['id_estabelecimento']) && !empty($data['id_estabelecimento'])
            && isset($data['token_donuz']) && !empty($data['token_donuz'])
        ) {
            $estabelecimentoID = get_option('dnz_id_estabelecimento');
            $tokenDonuz = get_option('dnz_token_donuz');

            if (empty($estabelecimentoID)) {
                add_option('dnz_id_estabelecimento', $data['id_estabelecimento']);
            } else {
                update_option('dnz_id_estabelecimento', $data['id_estabelecimento']);
            }

            if (empty($tokenDonuz)) {
                add_option('dnz_token_donuz', $data['token_donuz']);
            } else {
                update_option('dnz_token_donuz', $data['token_donuz']);
            }
        }
    }
}