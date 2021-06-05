<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */

$this->title = 'Обновить пользователя: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="user-form-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
