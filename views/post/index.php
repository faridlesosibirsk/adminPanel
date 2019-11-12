<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            
            //'id',
            'title:ntext',
            //'text:ntext',
            [   
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Действия', 
                'headerOptions' => ['width' => '80'],
                'template'=>'{view} {update} {delete}',
                'buttons' => [
                'view' => function ($url,$model) {
                    return Html::a(
                    '<span class=" glyphicon glyphicon-eye-open ">Просмотреть</span>', 
                    $url);
                },
                'update' => function ($url,$model) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-pencil">Обновить</span>', 
                    $url);
                },
                'delete' => function ($url,$model) {
                    return Html::a(
                    '<span class="glyphicon glyphicon-trash">Удалить</span>', 
                    $url);
                },
            ],
            ],
        ],
    ]); ?>


</div>
