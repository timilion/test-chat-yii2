<?php

use yii\helpers\Html;

/** @var \app\models\LoginForm $model */

$this->title = 'Авторизация';
?>
<div class="card">
    <div class="card-body login-card-body">

        <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'login', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('login')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
        <?= $form->field($model, 'error')->label(false)->textInput(['hidden' => 'hidden']) ?>
        <div class="row">

            <div class="col-4">
                <?= Html::submitButton('Войти', [
                    'class' => 'btn btn-primary btn-block',
                    'name' => 'login'
                ]) ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton('Зарегистрировать', [
                    'class' => 'btn btn-info btn-block',
                    'name' => 'registr'
                ]) ?>
            </div>
        </div>

        <?php \yii\bootstrap4\ActiveForm::end(); ?>
    </div>
    <!-- /.login-card-body -->
</div>