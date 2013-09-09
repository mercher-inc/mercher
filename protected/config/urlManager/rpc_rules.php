<?php

$rpcActions = array(

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