<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "content_block".
 *
 * @property integer $id
 * @property integer $title
 * @property string $slug
 * @property string $instructions
 * @property string $content
 */
class ContentBlock extends \yii\db\ActiveRecord
{

    public $image;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content_block';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'integer'],
            [['instructions', 'content'], 'string'],
            [['slug','meta_value_1'], 'string', 'max' => 150],
            [['image'], 'file'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'instructions' => 'Instructions',
            'content' => 'Content',
        ];
    }

    public static function getContent($slug) {
        
        $model = ContentBlock::findOne(['slug'=>$slug]);

        if($model)
            return $model;

        return false;
    }
}
