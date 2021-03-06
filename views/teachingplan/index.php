<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Учебный план';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teachingplan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('_formsave', [
        'dataProvider' => $dataProvider,
    ]) ?>

</div>
