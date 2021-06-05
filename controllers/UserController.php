<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\UserForm;
use app\models\search\UserSearsh;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for UserForm model.
 */
class UserController extends Controller
{

    /**
     * @return array[]
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index','update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]
        ];
    }


    /**
     * Lists all UserForm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearsh();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Updates an existing UserForm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = new UserForm();
        $model->setModel($this->findModel($id));
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
