<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class FrontendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/frontend.css?cache=5',
        'css/frontend-mediaqueries.css?cache=5',
        'js/trumbo/ui/trumbowyg.min.css',
        'https://fonts.googleapis.com/css?family=Roboto+Mono:400,500,700|Roboto:400,500,700',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',  
    ];
    public $js = [
        'js/trumbo/trumbowyg.min.js',
        'js/trumbo/plugins/cleanpaste/trumbowyg.cleanpaste.min.js',
        'js/frontend.js?cache=10',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
