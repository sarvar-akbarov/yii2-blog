<?php

namespace app\controllers;

use Yii;
use app\models\Blog;
use yii\helpers\Html;
use \yii\web\Response;
use yii\web\Controller;
use app\models\Language;
use yii\web\UploadedFile;
use app\models\BlogSearch;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new BlogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function beforeAction($action)
    {            
        if ($action->id == 'image-upload') {
            $this->enableCsrfValidation = false;
        }
    
        return parent::beforeAction($action);
    }

    public function actionImageUpload()
    {
        $funcNum = $_REQUEST['CKEditorFuncNum'];
        Yii::$app->response->format = Response::FORMAT_JSON;

        if($_FILES['upload']) {

            $message = '';
            if (($_FILES['upload'] == "none") OR (empty($_FILES['upload']['name']))) {
                $message = Yii::t('app', "Please Upload an image.");
            }

            elseif ($_FILES['upload']["size"] == 0 OR $_FILES['upload']["size"] > 5*1024*1024)
            {
                $message = Yii::t('app', "The image should not exceed 5MB.");
            }

            elseif ( ($_FILES['upload']["type"] != "image/jpg") 
                    AND ($_FILES['upload']["type"] != "image/jpeg") 
                    AND ($_FILES['upload']["type"] != "image/png"))
            {
                $message = Yii::t('app', "The image type should be JPG , JPEG Or PNG.");
            }

            elseif (!is_uploaded_file($_FILES['upload']["tmp_name"])){
                $message = Yii::t('app', "Upload Error, Please try again.");
            }

            else {
                //you need this (use yii\db\Expression;) for RAND() method 
                $random = rand(123456789, 9876543210);

                $extension = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);

                //Rename the image here the way you want
                $name = date("m-d-Y-h-i-s", time())."-".$random.'.'.$extension; 

                // Here is the folder where you will save the images
                $folder = 'uploads/ckeditor_images/';  

                $url = Yii::$app->urlManager->createAbsoluteUrl($folder.$name);

                move_uploaded_file( $_FILES['upload']['tmp_name'], $folder.$name );
                // $data = [
                //     "uploaded" => 1,
                //     "fileName"=> $name,
                //     'url' => $url
                // ];
                // return $data;
            }

            // if($message != ''){
            //     return [
            //         'error' => [
            //             'message' => $message,
            //         ],
            //     ];
            // }
            // echo '<script type="text/javascript">console.log("'.$url.'", "'.$message.'" );</script>';
            echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$funcNum.'", "'.$url.'", "'.$message.'" );</script>';
        }
    }
    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    /**
     * Displays a single Blog model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $languages = Language::getLanguageList();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'languages' => $languages 
        ]);
    }

    /**
     * Creates a new Blog model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($category_id = 0)
    {
        $request = Yii::$app->request;
        $user = Yii::$app->user->identity;
        $model = new Blog();  
        if($category_id){
            $model->category_id = $category_id;
        }
        $model->user_id = $user->id;

        $languages = Language::getLanguageList();
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->validate()) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if($model->uploadImage()){
                $model->save(false);
                return $this->redirect(['index']);
            }else{
                $model->image = '';
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        } else {
            $model->image = '';
            return $this->render('create', [
                'model' => $model,
                'languages' => $languages 
            ]);
        }
    }

    /**
     * Updates an existing Blog model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $languages = Language::getLanguageList();
        
        /*
        *   Process for non-ajax request
        */
        if ($model->load($request->post()) && $model->save()) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if($model->uploadImage()){
                return $this->redirect(['index']);
            }else{
                return $this->render('update', [
                    'model' => $model,
                    'languages' => $languages
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'languages' => $languages
            ]);
        }
        
    }

    /**
     * Delete an existing Blog model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Blog model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
       
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('app','The requested page does not exist.'));
        }
    }
}
