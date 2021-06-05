<?php

namespace app\controllers;

use app\models\ChatMessage;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class IncorrectController extends \yii\web\Controller
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
                        'actions' => ['index','delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]
        ];
    }


    public function actionIndex()
    {
        $query = ChatMessage::find()->where(['status' => ChatMessage::STATUS_INCORRECT]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('index', compact('dataProvider'));
    }


    public function actionDelete($id) {
        $model = ChatMessage::findOne($id);
        if($model && $model->status === ChatMessage::STATUS_INCORRECT) {
            $model->status = ChatMessage::STATUS_CORRECTLY;
            $model->save();
        }
        return $this->redirect(['index']);
    }
}
