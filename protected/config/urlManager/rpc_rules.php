<?php

$rpcActions = array(
    'like',
    'create_order',
    'create_pay_request',
    'check_payment_details',
    'ipn_notification'
);

$rpcRoutes = array();

foreach ($rpcActions as $rpcAction) {
    $rpcMethodParts = explode('_', $rpcAction);
    $rpcMethod      = $rpcMethodParts[0];
    for ($i = 1; $i < count($rpcMethodParts); $i++) {
        $rpcMethod .= ucfirst($rpcMethodParts[$i]);
    }

    $rpcRoutes[] = array(
        'api/rpc/' . $rpcAction,
        'pattern'       => 'api/' . $rpcMethod,
        'urlSuffix'     => false,
        'caseSensitive' => true,
        'parsingOnly'   => true,
    );
}
return $rpcRoutes;