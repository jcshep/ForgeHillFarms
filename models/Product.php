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

    public $imageFile;

    public function rules()
    {
        return [
            [['category_id'],'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 90],
            [['name'],'required'],
            [['type'], 'string', 'max' => 11],
            [['allow_prepayment','price','in_store'],'number'],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/products/image-' . $this->id . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }


    public function getPrice()
    {
        return number_format($this->price, 2);
    }


    public function getImage() {

        if (file_exists('uploads/products/image-'.$this->id.'.png')) {
            return 'uploads/products/image-'.$this->id.'.png';
        }

        if (file_exists('uploads/products/image-'.$this->id.'.jpg')) {
            return 'uploads/products/image-'.$this->id.'.jpg';
        }

        return 'uploads/products/default-product.jpg';

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
