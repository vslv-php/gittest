<?php

/* @var $this yii\web\View */

/* @var $dataProvider yii\data\ActiveDataProvider */

use app\models\Repo;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = Yii::$app->name;
?>
<div class="site-index">

    <h1>Last <?= Repo::LAST_N ?> repositories</h1>
    
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                
                [
                    'header' => 'User',
                    'format' => 'html',
                    'value' => function (Repo $repo) {
                        return Html::a($repo->account->username, 'https://github.com/' . $repo->account->username);
                    }
                ],
                [
                    'header' => 'Repository',
                    'format' => 'html',
                    'value' => function (Repo $repo) {
                        return Html::a($repo->repo_name, 'https://github.com/' . $repo->account->username . '/' . $repo->repo_name);
                    }
                ],
                [
                    'header' => 'Last update',
                    'attribute' => 'last_update',
                    'format' => 'datetime'
                ],
            ],
        ]
    ); ?>

</div>
