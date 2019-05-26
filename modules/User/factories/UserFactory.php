<?php

namespace app\modules\User\factories;

use app\files\JsonFileEnum;
use app\modules\User\forms\SignupForm;
use Nahid\JsonQ\Jsonq;
use Yii;

class UserFactory
{
    /**
     * @param SignupForm $signupForm
     * @return \stdClass
     * @throws \Nahid\JsonQ\Exceptions\ConditionNotAllowedException
     * @throws \Nahid\JsonQ\Exceptions\FileNotFoundException
     * @throws \Nahid\JsonQ\Exceptions\InvalidJsonException
     * @throws \Nahid\JsonQ\Exceptions\NullValueException
     */
    public function create(SignupForm $signupForm) : \stdClass
    {
        $file = Yii::$app->basePath . JsonFileEnum::USERS;
        $data = json_decode(file_get_contents($file), true);

        $id = $this->getLastId($data['users']);
        array_push($data['users'],
            [
                "id" => $id,
                "firstname" => $signupForm->firstname,
                "lastname" => $signupForm->lastname,
                "nickname" => $signupForm->nickname,
                "age" => $signupForm->age,
                "password" =>  md5($signupForm->password)
            ]
        );

        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

        $jsonq = new Jsonq(Yii::$app->basePath . JsonFileEnum::USERS);
        $user = $jsonq->from('users')
            ->where('id', '=', $id)
            ->first();

        return $user;
    }

    private function getLastId($users)
    {
        if (empty($users)) {
            return 1;
        }

        $lastUser = array_pop($users);

        return ((int) $lastUser['id'] + 1);
    }
}