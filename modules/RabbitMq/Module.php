<?php
namespace app\modules\RabbitMq;

use Yii;
use yii\base\Module AS ModuleBase;

class Module extends ModuleBase
{
    public $moduleName = 'RabbitMq';

    public function init()
    {
        Yii::$container->set('RabbitMqProducerBuilder', [
            'class' => 'app\modules\RabbitMq\components\RabbitMqProducerBuilder',
        ]);

        return parent::init();
    }
}