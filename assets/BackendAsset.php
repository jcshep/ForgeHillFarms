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
class BackendAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [        
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css',        
        'js/trumbo/ui/trumbowyg.min.css',
        'css/backend.css?cache=6',
    ];
    public $js = [
        'js/trumbo/plugins/cleanpaste/trumbowyg.cleanpaste.min.js',
        'js/trumbo/trumbowyg.min.js',
        'js/trumbo/plugins/fontsize/trumbowyg.fontsize.min.js',
        'js/trumbo/plugins/upload/trumbowyg.upload.min.js',
        'js/trumbo/plugins/upload/trumbowyg.upload.min.js',
        'js/backend.js?cache=10',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
