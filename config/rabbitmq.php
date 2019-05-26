<?php
require_once dirname(__DIR__) . '/modules/RabbitMq/enums/RabbitMqRoutingKeyEnum.php';
require_once dirname(__DIR__) . '/modules/RabbitMq/enums/RabbitMqQueueNameEnum.php';


use app\modules\RabbitMq\enums\RabbitMqRoutingKeyEnum;
use app\modules\RabbitMq\enums\RabbitMqQueueNameEnum;

$connections = [
    'default' => [
        'host' => 'rabbitmq',
        'port' => '5672',
        'user' => 'guest',
        'password' => 'guest',
        'vhost' => '/',
        'heartbeat' => 0,
    ],
];

$defaultExchangeOptions = [
    'type' => 'direct',
    'durable' => true,
    'auto_delete' => false,
    'name' => 'amq.direct'
];

$defaultQueueOptions = [
    'durable' => true,
    'auto_delete' => false,
];

if (file_exists(__DIR__.'/rabbitmq-local.php'))
    $connections =  \yii\helpers\ArrayHelper::merge($connections, require __DIR__.'/rabbitmq-local.php');

return [
    'class' => 'mikemadisonweb\rabbitmq\Configuration',
    'logger' => [
        'category' => 'YiiRabbitMq'
    ],
    'connections' => $connections,
    'producers' => [
        'ms_analytics_log' => [
            'connection' => 'default',
            'exchange_options' => array_merge($defaultExchangeOptions),
            'queue_options' => array_merge($defaultQueueOptions, [
                'name' => RabbitMqQueueNameEnum::MS_ANALYTICS_LOG,
                'routing_keys' => [RabbitMqRoutingKeyEnum::ADD_LOG],
            ]),
        ],
    ],
    'consumers' => [
    ]
];
