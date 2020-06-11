<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "menu_category".
 *
 * @property integer $id
 * @property string $title
 */
class Category extends \yii\db\ActiveRecord
{   

    public function init()
    { 
        $this->display_menu = 1;
        $this->display_order_menu = 1;

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order'],'integer'],
            [['title','slug','highlight'], 'string', 'max' => 90],
            [['description','display_menu','display_order_menu'],'safe']
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
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            // Create Slug
            $this->slug = $this->sanitizeStringForUrl($this->title);

            //Adjust case
            $this->title = ucwords(strtolower($this->title));

            return true;
        } 
        return false;        
    }

    public function sanitizeStringForUrl($string){
        $string = strtolower($string);
        $string = html_entity_decode($string);
        $string = str_replace(array('ä','ü','ö','ß'),array('ae','ue','oe','ss'),$string);
        $string = preg_replace('#[^\w\säüöß]#',null,$string);
        $string = preg_replace('#[\s]{2,}#',' ',$string);
        $string = str_replace(array(' '),array('-'),$string);
        return $string;
    }

    public function getItems() {
        return $this->hasMany(Product::className(), ['category_id' => 'id'])->orderBy('order ASC');
    }




    public static function getCategoryList() {

        $categories = MenuCategory::find()->select(['id','title'])->asArray()->all();
        return ArrayHelper::map($categories, 'id', 'title');
    }



}
