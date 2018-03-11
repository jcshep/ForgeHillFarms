<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newsletter".
 *
 * @property integer $id
 * @property string $email
 */
class Newsletter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'newsletter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['email'], 'email'],
            [['email'], 'required'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
        ];
    }
}
