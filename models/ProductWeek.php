<?php

namespace app\models;

use Yii;
use app\models\AppHelper;

/**
 * This is the model class for table "product_week".
 *
 * @property int $id
 * @property int $product_id
 * @property int $week_start
 * @property int $week_end
 *
 * @property Product $product
 */
class ProductWeek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_week';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id'], 'required'],
            [['product_id', 'week_start', 'week_end'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'week_start' => 'Week Start',
            'week_end' => 'Week End',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }


    public static function generateWeeklyList() {

        $week = AppHelper::getCurrentWeekDates();
        
        $products = ProductWeek::find()->where(['week_start' => $week['start']])->all();
        
        $html = ''; 

        if($products) {

            $html .= '<ul class="weekly-product-list">';
            foreach ($products as $product) {                
                $html .= '<li>'.$product->product->name.'</li>';
            }
            $html .= '</ul>';
            return $html;

        } else {
            return '
                <p>Please check back with us to view this weeks haul</p>
                <p>You can also enter your email to receive notifications of events, weekly harvest updates, and more.</p>';
        }
    }

    public static function getWeeklyAddons() {
        $week = AppHelper::getCurrentWeekDates();        
        $products = ProductWeek::find()->joinWith(['product'])->where(['week_start' => $week['start'], 'product.type' =>'addon'])->all();
        return $products;
    }

}
