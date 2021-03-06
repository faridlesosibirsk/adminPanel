<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use app\models\Studentarticles;
use app\models\Studentarticlescreate;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentarticlesController implements the CRUD actions for Studentarticles model.
 */
class StudentarticlesController extends Controller
{
    public $layout = 'studentarticles';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * Lists all Studentarticles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $userid = \Yii::$app->user->identity->id;
        $dataProvider = new ActiveDataProvider([
            'query' => Studentarticles::find()->where(['userid' => $userid]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Studentarticles model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = Studentarticles::find()->where(['id' => $id])->limit(1)->one();
        $filename = $dataProvider->filename;
        $i = \Yii::$app->user->identity->id;
        $file = \Yii::$app->params['pathUploads'] . $i . '/' . 'studentarticles_' . $filename;
        header('Content-Description: File Transfer');
        //header('Content-Type: application/octet-stream');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    /**
     * Creates a new Studentarticles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Studentarticlescreate();
        $userid= \Yii::$app->user->identity->id;
        if(Yii::$app->request->post()) {
          $model->filename = UploadedFile::getInstance($model, 'filename');
            if ($model->validate()) {
              $path = Yii::$app->params['pathUploads'] . $userid . '/';
              $model->filename->saveAs( $path . 'studentarticles_' . $model->filename);
              $model->save($model->filename);
              return $this->redirect(['studentarticles/index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Studentarticles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userid= \Yii::$app->user->identity->id;
        if (!($model->userid == $userid)) {
            return $this->redirect(['index']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Studentarticles::find()->where(['userid' => $userid]),
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Studentarticles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $userid= \Yii::$app->user->identity->id;
        $path = \Yii::$app->params['pathUploads'] . $userid . '/';
        unlink( $path . 'studentarticles_' . $this->findModel($id)->filename );
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionSave($id)
    {
        \Yii::$app->db->createCommand()
             ->update('studentarticles', ['status' => 1], ['id' => $id])
             ->execute();
        return $this->redirect(['index']);
    }   

    /**
     * Finds the Studentarticles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Studentarticles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Studentarticles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
