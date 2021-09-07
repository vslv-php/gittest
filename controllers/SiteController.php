<?php

namespace app\controllers;

use app\models\Repo;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Repo::find()->orderBy(['last_update' => SORT_DESC])->limit(Repo::LAST_N),
                'pagination' => false,
            ]
        );
        
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
