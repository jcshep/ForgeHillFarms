<?php

namespace app\controllers;

use Yii;
use app\models\Page;
use app\models\SearchPage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;



/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends Controller
{

    public $layout = 'backend';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [   'actions' => ['admin', 'view', 'create', 'update', 'delete', 'get-content', 'set-content','remove-image'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                                                return \Yii::$app->user->identity->access_level == 'admin';                    
                                                }
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($slug = 'home')
    {

        $this->layout = 'frontend';

        // Get page by slug
        $model = Page::find()->where(['slug'=>$slug])->one();

        if(!$model)
            throw new NotFoundHttpException('The page does not exist.');


        // Get view file from slug
        $viewFile = $model->slug;
        if(!is_file('../views/page/'.$model->slug.'.php'))
            $viewFile = 'default';

        $filter = NULL;
        $dataProvider = NULL;
        $searchEvent = NULL;
        $rankings = NULL;




        // Set up filtering form for rankings page

        if($slug == 'rankings') {

            //Set up ranking for rankings page
            $args = [
                'gender' => NULL,
                'ageGroup' => NULL,
                'sortBy' => 'rankOverall',
                'sortDirection' => 'asc',
                'skip' => 0,
                'take' => 100,
                'birthYear' => NULL,
                'memberUsocrID' => NULL,
                'memberID' => NULL,
            ];
            $rankings = \app\models\User::GetOverallRankings($args)->results;

            // If filter submitted, replace rankings with filtered rankings
            $filter = new \app\models\RankingFilterForm();
            if($filter->load(Yii::$app->request->post()) && $filter->validate()) {
                
                // Get filtered rankings
                $args = [
                    "gender" => $filter->gender,
                    "ageGroup" => $filter->age_group,
                    "searchText" =>  $filter->fname.' '.$filter->lname,
                    "sortBy" => "rankOverall",
                    "sortDirection" => "ASC",
                    "skip" => 0,
                    "take" => 100
                ];

                $rankings = \app\models\User::GetFiltered($args);
                $rankings = $rankings->results;

                // echo '<pre>';
                // var_dump($rankings);
                // echo '</pre>';
                // $rankings = NULL;
            }
        
        } //end rankings



        // Load contact form on contact page
        $slug == 'contact' ? $contactForm = new \app\models\ContactForm() : $contactForm = NULL ;

        //Check if contact form is submitted
        if ($slug == 'contact' && $contactForm->load(Yii::$app->request->post()) && $contactForm->validate()) {
               
                Yii::$app->session->setFlash('contactFormSubmitted');

                return $this->redirect('/contact');
        }


        // Load events on event page
        if($slug == 'calendar') {
            $searchEvent = new \app\models\SearchEvent();
            $dataProvider = $searchEvent->search(Yii::$app->request->queryParams);
        } 




        // Load events for home page
        if($slug == 'home') {
            $searchEvent = new \app\models\SearchEvent();
            $dataProvider = $searchEvent->search(Yii::$app->request->queryParams, 5);
        } 


        return $this->render($viewFile, [
            'model' => $model,
            'rankings' => $rankings,
            'contactForm' => $contactForm,
            'calendar' => $dataProvider,
            'searchEvent' => $searchEvent,
            'filter' => $filter
        ]);
    }


    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionAdmin()
    {   
        

        $searchModel = new SearchPage();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Page model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Page model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/page/admin']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/page/admin']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Page model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionRemoveImage($slug)
    {   
            
        $model = \app\models\ContentBlock::findOne(['slug'=>$slug]);
        $model->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }



    public function actionSetContent()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        
        $slug = Yii::$app->request->post('slug');

        $model = \app\models\ContentBlock::findOne(['slug'=>$slug]);

        // If no model was found, create a new one
        if(!$model) {
            $model = new \app\models\ContentBlock();
            $model->type = Yii::$app->request->post('type');
            $model->slug = Yii::$app->request->post('slug');
        }
        
        // If model is image, upload and save content as filename
        if($model->type == 'image') {
            $model->image = \yii\web\UploadedFile::getInstanceByName('image');
            if($model->image) {

                $model->content = $model->slug.'.'.$model->image->extension;

                Image::getImagine()
                        ->open($model->image->tempName)
                        ->thumbnail(new Box(1500, 1500))
                        ->save('uploads/' . $model->slug . '.' . $model->image->extension);

            }
        }

        if($model->type == 'text')
            $model->content = Yii::$app->request->post('content');
        

        if($model->type == 'wysiwyg')
            $model->content = Yii::$app->request->post('content');

        $model->save();

        $redirect = Yii::$app->request->referrer;

        if($anchor = Yii::$app->request->post('anchor'))
            $redirect .= '#'.$anchor; 


        return $this->redirect($redirect);
    
    }


    public function actionGetContent()
    {
        $slug = Yii::$app->request->get('slug');
        $type = Yii::$app->request->get('type');
        $anchor = Yii::$app->request->get('anchor');

        if(!$slug)
            throw new NotFoundHttpException('No Slug.');
        
        // Get model
        $model = \app\models\ContentBlock::findOne(['slug'=>$slug]);
        

        // If no model was found, create a new one
        if(!$model) {
            $model = new \app\models\ContentBlock();
            $model->type = $type;
        }


        // Create form for update modal
        $form = Html::beginForm(['page/set-content'], 'post', ['enctype' => 'multipart/form-data']);
        
            switch ($model->type) {
                case 'text':
                    $form .= Html::textarea('content', $model->content, ['class' => 'form-control','rows'=>7]);
                    break;
                
                case 'wysiwyg':
                        $form .= Html::textarea('content', $model->content, ['class' => 'form-control wysiwyg','rows'=>7]);
                    break;

                case 'image':
                    $form .= Html::fileInput('image', $model->content, ['class' => 'form-control']);
                    break;
            }        
        $form .= '<div class="spacer30"></div>';
        $form .= Html::hiddenInput('type', $model->type);
        $form .= Html::hiddenInput('slug', $slug);
        $form .= Html::hiddenInput('anchor', $anchor);
        $form .= Html::submitButton('Submit', ['class' => 'btn btn-success submit']);
        $form .= Html::endForm();



        // $this->layout = 'editor';

        return $this->renderPartial('editor', [
            'form' => $form,
        ]);
    }




}
