<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $model \common\models\Restaurant
 */
?>
<div class="regular-page clear-filter page-header-small">
    <div class="container">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6 border-left border-right">
                <h3 class=" ">Добавление нового места.</h3>



                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'title')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'desc')->textarea() ?>

                <div>
                    <label class="control-label">Возможности</label>
                    <div>

                            <?= \common\widgets\checkbox\SingleCheckboxWidget::widget([
                                'model' => $model,
                                'attribute' => 'has_lunch'
                            ]) ?>



                            <?= \common\widgets\checkbox\SingleCheckboxWidget::widget([
                                'model' => $model,
                                'attribute' => 'has_menu'
                            ]) ?>


                            <?= \common\widgets\checkbox\SingleCheckboxWidget::widget([
                                'model' => $model,
                                'attribute' => 'has_alko'
                            ]) ?>



                    </div>

                </div>


                <div>


                    <label class="control-label">Типы питания</label>

                    <div>
                        <?= \common\widgets\checkbox\SingleCheckboxWidget::widget([
                            'model' => $model,
                            'attribute' => 'has_sportmenu'
                        ]) ?>
                        <?= \common\widgets\checkbox\SingleCheckboxWidget::widget([
                            'model' => $model,
                            'attribute' => 'has_healthmenu'
                        ]) ?>


                    </div>

                </div>


                <div>


                    <label class="control-label">Доставка</label>

                    <div>
                        <?= \common\widgets\checkbox\SingleCheckboxWidget::widget([
                            'model' => $model,
                            'attribute' => 'has_delivery'
                        ]) ?>

                    </div>

                </div>

                <?= $form->field($model, 'price_category')->dropDownList($model::$_price_category) ?>
                <?= $form->field($model, 'type')->dropDownList($model::$_type) ?>


                <?= $form->field($model, 'reCaptcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha3::className(),
                    [
//            'siteKey' => 'your siteKey', // unnecessary is reCaptcha component was set up
                        'action' => 'homepage',
                    ]
                )->label(false) ?>

                <?= $form->field($model, 'address')->widget(\common\widgets\google\GoogleAutocompleteWidget::class) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>


    </div>
</div>
