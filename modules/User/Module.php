<?php
namespace app\modules\User;

use Yii;
use yii\base\Module AS ModuleBase;

class Module extends ModuleBase
{
    public $moduleName = 'User';

    public function init()
    {
        Yii::$container->set('UserFactory', [
            'class' => 'app\modules\User\factories\UserFactory',
        ]);

        return parent::init();
    }
}