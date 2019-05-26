<?php

namespace app\modules\RabbitMq\components;

use Yii;

class RabbitMqProducerBuilder
{
    public function __construct()
    {
        Yii::$app->rabbitmq->load();
    }

    /**
     * @param string $producerName
     * @param array $attributes
     * @param string $routingKey
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function send(string $producerName, array $attributes, string $routingKey)
    {
        /** @var \mikemadisonweb\rabbitmq\components\Producer $producer */
        $producer = Yii::$container->get('rabbit_mq.producer.' . $producerName);
        $producer->disableAutoSetupFabric();
        $producer->publish(json_encode($attributes), $routingKey);
    }
}