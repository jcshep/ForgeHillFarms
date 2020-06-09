<?php

namespace app\controllers;

use Yii;
use app\models\MenuCategory;
use app\models\SearchMenuCategory;
use app\models\MenuItem;
use app\models\MenuItemModifier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\MenuCategoryLocation;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;
use richardfan\sortable\SortableAction;

/**
 * MenuCategoryController implements the CRUD actions for MenuCategory model.
 */
class MenuCategoryController extends Controller
{

    public $layout = 'backend';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [   'actions' => ['index','create','update','delete','get-category-list','sortItem'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function() {
                                                    return Yii::$app->user->identity->access_level == 'admin';  
                                                }
                    ],
                    [
                        'actions' => ['view','pdf'],
                        'allow' => true,
                    ],

                ],
            ],
        ];
    }

    public function actions(){
        return [
            'sortItem' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => MenuCategory::className(),
                'orderColumn' => 'order',
            ],
            // your other actions
        ];
    }

    /**
     * Lists all MenuCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchMenuCategory();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    



    public function actionCreate()
    {
        $model = new MenuCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            Yii::$app->session->setFlash('success', 'Category created');
            return $this->redirect(['update', 'id'=>$model->id]);
        
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MenuCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            
            // Update menu category location info
            // if(!$this->updateMenuCategoryLocations(Yii::$app->request->post('location'), $model))
            //     return $this->redirect(['update', 'id' => $model->id]);


            if ($model->save()) 
                Yii::$app->session->setFlash('success', 'Category updated'); 

            return $this->redirect(['update', 'id'=>$model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MenuCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    public function actionPdf($id)
    {
       // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('_pdf', ['location'=>$id]);
        
        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '
                            h3 {font-size:22px; font-weight:bold; padding:30px 0 5px; margin:0;}
                            h5 {font-weight: bold; font-size:15px; padding:0 0 4px; margin:0; }
                            .description {margin:0 0 15px;}
                            .item {margin-bottom:15px; position: relative}
                            .item img {width:15px; height: auto; position:absolute; right:0}
                            .item p {margin:0; padding:0; display:inline}
                            .price {font-weight:bold; color:#33A04F; padding-left:20px;}
                            .details {font-size:12px; color:#777}
                            .logo {text-align:center}
                        ', 
             // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
             // call mPDF methods on the fly
            'methods' => [ 
                // 'SetHeader'=>['Krajee Report Header'], 
                // 'SetFooter'=>['{PAGENO}'],
                    // 'SetColumns'=>['2'],
            ]
        ]);

         // return the pdf output as per the destination setting
        return $pdf->render(); 
    }



    public function actionGetCategoryList() {

        // Get ajax post data
        $data = Yii::$app->request->post();
       
        if($data['type'] == 'category')
            return json_encode(MenuItem::find()->select(['title','price'])->where(['category_id'=>$data['id']])->asArray()->all());

        if($data['type'] == 'modifier')
            return json_encode(MenuItemModifier::find()->select(['title','price_adjust'])->where(['group'=>$data['id']])->asArray()->all());


    }





    function updateMenuCategoryLocations($post, $model) {


        // Loop through each enabled location and update database
            foreach ($post as $location => $menu_category_location) {

                if ($menu_category_location) {                   

                    // Search for existing item / location
                    $menu_category_location_model = MenuCategoryLocation::find()->where(['location'=>$location, 'menu_category'=>$model->id])->one();
                    if(!$menu_category_location_model) {
                        $menu_category_location_model = new MenuCategoryLocation;
                    }

                    // Save module
                    $menu_category_location_model->location = $location;
                    $menu_category_location_model->menu_category = $model->id;
                    $menu_category_location_model->availability = serialize($menu_category_location['hours']);
                    if(!$menu_category_location['hours'])
                        $menu_category_location_model->availability = NULL;            
                    
                    if(isset($menu_category_location['availability_inherit'])) {
                        $menu_category_location_model->availability_inherit = $menu_category_location['availability_inherit'];
                    } else {
                        $menu_category_location_model->availability_inherit = NULL;
                    }
                    

                    // If enabled, set model item to enabled
                    if(isset($menu_category_location['enabled'])) {
                        $menu_category_location_model->enabled = $menu_category_location['enabled'];
                    } 


                    if(isset($menu_category_location['enabled'])) {                
                        // Save
                        $menu_category_location_model->save();
                    } else {
                        // Delete
                        $menu_category_location_model->delete();
                    }

                    // echo '<pre>';
                    // var_dump($menu_category_location_model->errors);
                    // echo '</pre>';
                    // die();

                } //end if post item               
            } //end for each

            return true;
    }




}
