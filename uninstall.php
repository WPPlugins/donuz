<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}

$qtdExec = get_option("dnz_log_exec");

foreach (range(0, $qtdExec) as $execution) {
    delete_option("dnz_log_" . $qtdExec);
}

delete_option("dnz_log_exec");
delete_option("dnz_date_start");
delete_option('dnz_id_estabelecimento');
delete_option('dnz_token_donuz');

register_deactivation_hook(__FILE__, 'dnzCronDeactivation');

function dnzCronDeactivation()
{
    wp_clear_scheduled_hook('dnz_event_task');
}
