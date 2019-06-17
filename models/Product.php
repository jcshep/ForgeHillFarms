<?php

namespace app\models;

use Yii;


class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['name'], 'string', 'max' => 90],
            [['name'],'required'],
            [['type'], 'string', 'max' => 11],
            [['allow_prepayment','price'],'number']
        ];
    }


    public function getPrice()
    {
        return number_format($this->price, 2);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
        ];
    }
}
