<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="regular-page clear-filter page-header-small" >
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 border-left border-right">
                <h3 class=" ">Добавление нового места.</h3>

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'desc')->textarea() ?>


                <?= $form->field($model, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha3::className(),
                    [
//            'siteKey' => 'your siteKey', // unnecessary is reCaptcha component was set up
                        'action' => 'homepage',
                    ]
                )->label(false) ?>

                <?= $form->field($model, 'address')->widget(\common\widgets\google\GoogleAutocompleteWidget::class) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>


    </div>
</div>
