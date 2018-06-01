<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pickup".
 *
 * @property int $id
 * @property int $user
 * @property int $week
 * @property string $day
 * @property string $addons
 *
 * @property User $user0
 */
class Pickup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pickup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'week'], 'integer'],
            [['addons'], 'safe'],
            [['day', 'size'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User',
            'week' => 'Week',
            'day' => 'Day',
            'addons' => 'Addons',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if($this->addons && is_array($this->addons)) {                
                $this->addons = json_encode($this->addons);
            } else {
                $this->addons = NULL;
            }

            return true;
        } 
        return false;        
    }
}
