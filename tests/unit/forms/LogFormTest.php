<?php

namespace app\tests\unit\forms;

use app\modules\Log\forms\LogForm;

class LogFormTest extends \Codeception\Test\Unit
{
    /**
     * @param $url
     * @param $title
     * @param $expected
     *
     * @dataProvider logFormProvider
     */
    public function test($url, $source_label, $expected)
    {
        /** @var \app\modules\Log\forms\LogForm $model */
        $model = new LogForm();
        $model->setAttributes(["id_user" => $url, "source_label" => $source_label]);
        expect($model->validate())->equals($expected);
    }


    /**
     * @return array
     */
    public function logFormProvider()
    {
        return [
            ["id_user" => 1, "source_label" => "search_page", "expected" => true],
            ["id_user" => null, "source_label" => "search_page", "expected" => true],
            ["id_user" => 1, "source_label" => "", "expected" => false],
            ["id_user" => 13212, "source_label" => "some_action", "expected" => true],
        ];
    }
}
