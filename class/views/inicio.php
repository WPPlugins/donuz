<div class="wrap">

    <?php
    $tab = (!empty($_GET['tab'])) ? esc_attr($_GET['tab']) : 'configuracoes';
    $this->page_tabs($tab);

    if ($tab == 'configuracoes'):
        ?>

        <div id="dnzMsgForm"></div>

        <br/><h1>Insira abaixo as informações fornecidas pela plataforma Donuz</h1>

        <form method="post" action="?page=integrador_donuz&action=save_options" class="initial-form hide-if-no-js"
              id="form-save-options">
            <div id="dashboard-widgets-wrap">
                <div id="dashboard-widgets" class="metabox-holder">

                    <div id="postbox-container-1" class="postbox-container">
                        <div id="normal-sortables" class="meta-box-sortables ui-sortable">
                            <div id="dashboard_right_now" class="postbox">
                                <h2 class="hndle ui-sortable-handle"><span>Dados Donuz</span></h2>
                                <div class="inside">
                                    <div class="main">

                                        <div class="input-text-wrap" id="title-wrap">
                                            <label>ID do estabelecimento</label><br>
                                            <input name="id_estabelecimento" id="title" style="width: 100%" type="text"
                                                   value="<?php
                                                   echo (empty($estabelecimentoID))
                                                       ? ''
                                                       : $estabelecimentoID
                                                   ?>">
                                        </div>

                                        <br class="clear">

                                        <div class="input-text-wrap" id="title-wrap">
                                            <label>Token de acesso a API</label><br>
                                            <input name="token_donuz" id="title" style="width: 100%" type="text"
                                                   value="<?php
                                                   echo (empty($tokenDonuz))
                                                       ? ''
                                                       : $tokenDonuz
                                                   ?>">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" class="button button-primary" value="Salvar" id="dnzBtnForm">
        </form>

        <?php //else:
        ?>

    <?php endif; ?>
</div>