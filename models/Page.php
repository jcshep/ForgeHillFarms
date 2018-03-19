<?php

namespace app\models;

use Yii;


/**
 * This is the model class for table "page".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $show_in_menu
 */
class Page extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['show_in_menu'], 'integer'],
            [['slug', 'title'], 'string', 'max' => 150],
            [['page_title','meta_description'],'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'title' => 'Title',
            'show_in_menu' => 'Show In Menu',
        ];
    }


    public static function renderBlock($slug) {
        $data = \app\models\ContentBlock::getContent($slug);        
        if($data) {
            // $data->content .= '<a id="anchor-'.$slug.'></a>';
            return nl2br($data->content);
        }
    }

    public static function cacheBust() {
        if(User::isAdmin()) 
            return '?cachebust='.time();
    }


    public static function editBlock($slug, $type = NULL, $label = 'Edit', $class = NULL, $anchor = NULL) {
        $data = NULL;

        if(User::isAdmin()) 
            $data = '<a id="anchor-'.$slug.'" class="edit '.$class.'" data-slug="'.$slug.'" data-type="'.$type.'" data-anchor="'.$anchor.'">'.$label.'</a>';
        return $data;
    }


    public static function removeImage($slug) {
        $data = NULL;

        if(User::isAdmin()) 
            $data = '<a href="/page/remove-image/'.$slug.'" id="anchor-'.$slug.'" class="edit-link edit-image">x</a>';
        return $data;
    }


    public static function editBlockUrl($url) {
        $data = NULL;
        if(User::isAdmin()) 
            $data = '<a target="_blank" href="'.$url.'" class="edit">Edit</a>';
        return $data;
    }


    

    public static function instagramFeed(){

        $access_token = '1467229747.1677ed0.9f8a37d548484e99bd589f246759f7b2';
        $username = 'aioliwpb';
        
        // $api_url = "https://api.instagram.com/v1/users/search?q=" . $username . "&access_token=" . $access_token;
        $api_url = "https://api.instagram.com/v1/users/1467229747/media/recent/?access_token=1467229747.1677ed0.9f8a37d548484e99bd589f246759f7b2&count=10";

        $connection_c = curl_init(); // initializing
        curl_setopt( $connection_c, CURLOPT_URL, $api_url ); // API URL to connect
        curl_setopt( $connection_c, CURLOPT_RETURNTRANSFER, 1 ); // return the result, do not print
        curl_setopt( $connection_c, CURLOPT_TIMEOUT, 20 );
        $json_return = curl_exec( $connection_c ); // connect and get json data
        curl_close( $connection_c ); // close connection
       
        $user_search = json_decode( $json_return ); // decode and return

        // echo '';
        // var_dump($user_search);
        // echo '';
        if($user_search)
            return $user_search->data;

    }



    public static function nav() {     
   
        $html = '<ul>';
        foreach (Page::find()->where(['show_in_menu'=>1])->all() as $page) {
            $active = NULL;
            $current = Yii::$app->request->getQueryParam('slug');
            if($page->slug && $page->slug == $current)
                $active = 'active';
            $html .='<li class="'.$active.'"><a href="/'.$page->slug.'">'.$page->title.'</a></li>';
        }
        $html .= '</ul>';
        

        return $html;
    }



    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            
            $string = strtolower($this->title);
            $string = html_entity_decode($string);
            $string = str_replace(array('ä','ü','ö','ß'),array('ae','ue','oe','ss'),$string);
            $string = preg_replace('#[^\w\säüöß]#',null,$string);
            $string = preg_replace('#[\s]{2,}#',' ',$string);
            $string = str_replace(array(' '),array('-'),$string);
            
            $this->slug = $string;

            return true;
        } 
        return false;
        
    }




}
