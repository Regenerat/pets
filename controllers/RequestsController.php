<?php

namespace app\controllers;

use app\models\Requests;
use app\models\RequestsSearch;
use app\models\Role;
use app\models\Status;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RequestsController implements the CRUD actions for Requests model.
 */
class RequestsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Requests models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RequestsSearch();
        
        $searchModel = new RequestsSearch();

        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (Yii::$app->user->identity->role_id == Role::ADMIN_STATUS_ID) {
            $dataProvider = $searchModel->search($this->request->queryParams, Yii::$app->user->identity->id);
        }
        else {
            $dataProvider = $searchModel->search($this->request->queryParams);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Requests model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Requests();

        if (Yii::$app->user->isGuest || Yii::$app->user->identity->role_id == Role::ADMIN_STATUS_ID) {
            return $this->goHome();
        }

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->user_id = Yii::$app->user->identity->id;
                $model->status_id = Status::NEW_STATUS_ID;
                $model->admin_message = null;
                if($model->save()) {
                    return $this->redirect(['index', 'id' => $model->id]);
                }    
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Requests model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->load($this->request->post());

        if ($this->request->isPost && $model->load($this->request->post())) {
            if (in_array($model->dirtyAttributes['status_id'], [Status::FIND_STATUS_ID, Status::NOT_FIND_STATUS_ID]) && !$model->admin_message) {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Requests model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Requests the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Requests::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
