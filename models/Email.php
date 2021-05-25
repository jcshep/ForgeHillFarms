<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

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
    public $attachment;

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
            [['attachment'], 'file', 'skipOnEmpty' => true],
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


    public function upload()
    {
        if ($this->validate()) {
            $this->attachment->saveAs('uploads/attachment-' . $this->id . '.' . $this->attachment->extension);
            return true;
        } else {
            return false;
        }
    }


    public function getAttachment() {

        if (file_exists('uploads/attachment-'.$this->id.'.docx')) {
            return 'uploads/attachment-'.$this->id.'.docx';
        }

        if (file_exists('uploads/attachment-'.$this->id.'.pdf')) {
            return 'uploads/attachment-'.$this->id.'.pdf';
        }

        if (file_exists('uploads/attachment-'.$this->id.'.jpg')) {
            return 'uploads/attachment-'.$this->id.'.jpg';
        }

        if (file_exists('uploads/attachment-'.$this->id.'.png')) {
            return 'uploads/attachment-'.$this->id.'.png';
        }

        return false;

    }



    public function send($test = NULL) 
    {

        $users = User::find()->select('email')->where(['membership_type'=>$this->send_to])->asArray()->all();
        
        // Combine with newsletter group
        if(in_array('all', $this->send_to)) {
            $users_model = User::find()->select(['email'])->asArray()->all();
            $newsletter = Newsletter::find()->select(['email'])->asArray()->all();
            $users = array_merge($users_model, $newsletter);
            $users = array_map('unserialize', array_unique(array_map('serialize', $users)));
        }
             


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
                // $messages[] = Yii::$app->mailer->compose('/mail/email-template', [
                //     'model'=>$this
                // ])
                //     ->setFrom([Yii::$app->params['adminEmail'] => 'Forge Hill Farms'])
                //     ->setSubject($subject)
                //     ->setTo($user['email']);

                // $email = new \SendGrid\Mail\Mail(); 
                $email = Yii::$app->mailer->compose();
                $email->setFrom(Yii::$app->params['adminEmail']);
                $email->setTo($user['email']);
                $email->setSubject($subject);
                $email->setHtmlBody(Yii::$app->controller->renderPartial('/mail/email-template', ['model'=>$this]));
                $sendgrid = new \SendGrid(Yii::$app->params['sendgridApiKey']);
                try {
                    $response = $email->send();
                } catch (Exception $e) {            
                    // Yii::$app->session->setFlash('error', $e->getMessage());  
                }


            } //end foreach

            // Yii::$app->mailer->sendMultiple($messages);
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
