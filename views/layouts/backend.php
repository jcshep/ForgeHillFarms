<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\BackendAsset;
use yii\widgets\Menu;

BackendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<span>Forge Hill Farms | Site Administration</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                [
                    'label' => 'Logout',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],
        ],
    ]);
    NavBar::end();
    ?>

    
    <div class="container">

            <div class="row">

            <?php if (!\Yii::$app->user->isGuest) { ?>
            <div class="col-md-2">
                <?php  
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-stacked nav-pills'],
                        'activateParents' => 1,
                        'submenuTemplate' => "\n<ul class='dropdown-menu' role='menu'>\n{items}\n</ul>\n",
                        'items' => [
                            // ['label' => 'Dashboard', 'url' => ['site/dashboard']],
                            ['label' => 'Weekly Overview', 'url' => ['admin/weekly-overview']],
                            
                            ['label' => 'Scheduled Pickups', 'url' => ['admin/scheduled-pickups']],

                            ['label' => 'Pages', 
                                'options'=>['class'=>'dropdown'],
                                'url' => ['/page/admin'],
                                'items' => [
                                    ['label' => 'View All', 'url' => ['page/admin']],
                                    ['label' => 'View', 'url' => ['page/view']],
                                    ['label' => 'Update', 'url' => ['page/update']],
                                    ['label' => 'Create', 'url' => ['page/create']],
                                ]
                            ],
                            
                            

                            // ['label' => 'Membership Types', 'url' => ['order/export']],

                            ['label' => 'Users', 
                                'options'=>['class'=>'dropdown'],
                                'url' => ['/admin/users'],
                                'items' => [
                                    ['label' => 'View All', 'url' => ['admin/users']],
                                    ['label' => 'Create', 'url' => ['admin/user-create']],
                                ]
                            ],

                            ['label' => 'Emails', 
                                'url' => ['admin/emails'],
                                'options'=>['class'=>'dropdown'],
                                'items' => [
                                    ['label' => 'View All', 'url' => ['admin/email-generator']],
                                ]
                            ],

                            // ['label' => 'Export', 'url' => ['order/export']],

                        ],
                    ]);
                ?>
            </div>
            <?php } //end if guest ?>
            
            <div class="col-md-10">
                
                <?php if($flashMessage = Yii::$app->session->getFlash('error')): ?>
                    <div class="alert alert-danger"><?= $flashMessage ?></div>
                <?php endif; ?>

                <?php if($flashMessage = Yii::$app->session->getFlash('success')): ?>
                    <div class="alert alert-success"><?= $flashMessage ?></div>
                <?php endif; ?>

                <?= Breadcrumbs::widget([
                    'homeLink' => [
                        'label' => 'Dashboard',
                        'url' => '/dashboard',
                    ],
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= $content ?>
            </div>
        </div>
    </div>


</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Swine & Sons <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
