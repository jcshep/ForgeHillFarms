<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property int $id
 * @property string $type
 * @property int $send_date
 * @property string $content_area_1
 * @property string $content_area_2
 * @property string $content_area_3
 * @property int $created
 * @property string $send_to
 */
class Email extends \yii\db\ActiveRecord
{

    public $test_email;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created'], 'integer'],
            [['send_to'], 'required'],
            [['test_email'], 'email'],
            [['content_area_1', 'content_area_2', 'content_area_3','send_date', 'status'], 'string'],            
            [['type'], 'string', 'max' => 11],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'send_date' => 'Send Date',
            'content_area_1' => 'Content Area 1',
            'content_area_2' => 'Content Area 2',
            'content_area_3' => 'Content Area 3',
            'created' => 'Created',
            'send_to' => 'Send To',
        ];
    }



    public function send($test = NULL) 
    {

        $users = User::find()->select('email')->where(['membership_type'=>$this->send_to])->asArray()->all();
        
        if(in_array('all', $this->send_to)) 
             $users = User::find()->select(['email'])->asArray()->all();

        if($test)
            $users = array(['email'=>$this->test_email]);

        // $users = array(['email'=>'jcshep@gmail.com']);
        
        // echo '<pre>';
        // var_dump($users);
        // echo '</pre>';
        // die();


        $subject = 'Forge Hill Farms | Weekly Pickup Notification';

        if($this->type == 'newsletter')
            $subject = 'A Message From Forge Hill Farms';

        $messages = [];

        if ($users) {
                    
            foreach ($users as $user) {
                $messages[] = Yii::$app->mailer->compose('/mail/email-template', [
                    'model'=>$this
                ])
                    ->setFrom([Yii::$app->params['adminEmail'] => 'Forge Hill Farms'])
                    ->setSubject($subject)
                    ->setTo($user['email']);
            }

            Yii::$app->mailer->sendMultiple($messages);
        }

    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if($insert) {
                $this->created = time();
            }

            if($this->send_to && is_array($this->send_to))
                $this->send_to = json_encode($this->send_to);

            if($this->send_date && !is_numeric($this->send_date))
                $this->send_date = strtotime($this->send_date);

            return true;
        } 
        return false;        
    }
}
