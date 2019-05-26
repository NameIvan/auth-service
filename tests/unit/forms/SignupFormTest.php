<?php

namespace app\tests\unit\forms;

use app\modules\User\forms\SignupForm;

class SignupFormTest extends \Codeception\Test\Unit
{
    /**
     * @param array $data
     * @param bool $expected
     *
     * @dataProvider logFormProvider
     */
    public function test(array $data, bool $expected)
    {
        /** @var SignupForm $model */
        $model = new SignupForm();
        $model->setAttributes($data);
        expect($model->validate())->equals($expected);
    }


    /**
     * @return array
     */
    public function logFormProvider()
    {
        return [
            [
                "data" => [
                    "firstname" => "test",
                    "lastname" => "testLastname",
                    "nickname" => "testNickname1",
                    "password" => "pass123",
                    "age" => 25
                ],
                "expected" => true
            ],
            [
                "data" => [
                    "nickname" => "testNickname2",
                    "password" => "pass123",
                    "age" => 20
                ],
                "expected" => false
            ],
            [
                "data" => [
                    "firstname" => "test",
                    "lastname" => "testLastname",
                    "nickname" => "testNickname3",
                    "password" => "",
                    "age" => 20
                ],
                "expected" => false
            ],
        ];
    }
}
