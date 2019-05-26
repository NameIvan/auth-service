<?php

namespace app\modules\Log\forms;

use yii\base\Model;

class LogForm extends Model
{
    public $id;
    public $id_user;
    public $source_label;
    public $date_created;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['id_user', 'integer'],

            ['source_label', 'string'],
            ['source_label', 'required'],
        ];
    }
}
