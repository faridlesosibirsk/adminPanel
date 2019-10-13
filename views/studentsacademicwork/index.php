<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебная работа студента';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="studentsacademicwork-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_formsave', [
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
