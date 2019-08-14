<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model \frontend\models\ResetPasswordForm */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Resend verification email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="regular-page clear-filter page-header-small">
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 border-left border-right">
                <h1><?= Html::encode($this->title) ?></h1>

                <p>Пожалуйста, заполните следующую форму.</p>


                <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
