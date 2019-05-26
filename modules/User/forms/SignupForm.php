<?php

namespace app\modules\User\forms;

use app\files\JsonFileEnum;
use Nahid\JsonQ\Jsonq;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class SignupForm extends Model
{
    public $firstname;
    public $lastname;
    public $nickname;
    public $age;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [

            ['firstname', 'string', 'max' => 255],
            ['firstname', 'required'],

            ['lastname', 'string', 'max' => 255],
            ['lastname', 'required'],

            ['nickname', 'string', 'max' => 255],
            ['nickname', 'required'],
            ['nickname', 'match', 'pattern' => '/^[A-Za-z0-9]+$/'],
            ['nickname', function ($attribute) {
                $jsonq = new Jsonq(Yii::$app->basePath . JsonFileEnum::USERS);
                $exists = $jsonq->from('users')
                    ->where('nickname', '=', $this->nickname)
                    ->exists();
                if ($exists) {
                    $this->addError($attribute, 'Nickname already exists.');
                }
            }],

            ['age', 'integer'],
            ['age', 'required'],

            ['password', 'string', 'min' => 4, 'max' => 32],
            ['password', 'required'],
        ];
    }
}
