<?php

use common\models\Restaurant;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * @var $searchModel \common\models\search\RestaurantSearch;
 */
if (isset($model) && $model) :
    $center = [
        'lat' => $model->lat,
        'lng' => $model->lng
    ];
else:
    $center = [
        'lat' => 55.03425,
        'lng' => 82.9187
    ];
endif;


?>

<script>
    var center = <?= Json::encode($center) ?>;

</script>


<style>
    .wrapper {
        width: 100%;
        height: 100%;
    }


    .map-search-results {

    }

    .map-search-results {
        margin-top: 5rem;
        position: absolute;
        width: 250px;
        max-height: 600px;
        left: 100px;
        z-index: 2;
        background: white;
        border: 1px solid #ff9400;
        /*border-radius: 5px;*/
    }

    .map-search-form {
        margin-top: 5rem;
        position: absolute;
        width: 250px;
        max-height: 600px;
        right: 100px;
        z-index: 2;
        background: white;
        border: 1px solid #ff9400;
        /*border-radius: 5px;*/
    }
</style>


<div class="fluid-container map-search" style="height: 100%;">


<!--    ajax load rest info block-->
    <div class="rest-info d-none"> </div>
    <div class="map-search-results  collapse-parent   ">
        <div class=" p-2 bg-light">
            <?= Html::a('<i class="fa fa-arrows-alt  "></i>', '#', ['class' => 'draggable-item']) ?>
            <?= Html::a('<i class="fas fa-minus  "></i>', '#', ['class' => 'collapse-item float-right', 'data-toggle' => 'collapse', 'data-target' => '#map-filter-results-collapse']) ?>

        </div>

        <div class="px-3">
            <h3>Результаты:</h3>
            <div class="collapse show" id="map-filter-results-collapse">
                <div class="search-results   " id="search-results">
                    <div class="text-center">
                        <i class="fa fa-spinner fa-pulse"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="map-search-form  collapse-parent   ">
        <div class=" px-3">
            <?= Html::a('<i class="fa fa-arrows-alt  "></i>', '#', ['class' => 'draggable-item']) ?>
            <?= Html::a('<i class="fas fa-minus  "></i>', '#', ['class' => 'collapse-item float-right', 'data-toggle' => 'collapse', 'data-target' => '#map-filter-form-collapse']) ?>

        </div>
        <hr class="mt-md-1 mb-md-1">

        <div class="px-3 pb-3">


            <div class="collapse show" id="map-filter-form-collapse">

                <?php $form = ActiveForm::begin([
                    'id' => 'search-form'
                ]); ?>

                <?= \common\widgets\checkbox\MultipleCheckboxWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'price_category',
                    'list' => Restaurant::$_price_category,
                    'label' => true
                ]) ?>

                <?= \common\widgets\checkbox\MultipleCheckboxWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'type',
                    'list' => Restaurant::$_type,
                    'label' => true
                ]) ?>

                <?= Html::activeHiddenInput($searchModel, 'minLat') ?>
                <?= Html::activeHiddenInput($searchModel, 'minLng') ?>
                <?= Html::activeHiddenInput($searchModel, 'maxLng') ?>
                <?= Html::activeHiddenInput($searchModel, 'maxLat') ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>

    </div>
    <div class="maps">
        <div id="map"></div>
    </div>


</div>

<style>

</style>
<script id="rest-_view" type="text/x-jsrender">
{{for items}}
<div class="item" data-lat="{{:lat}}" data-lng="{{:lng}}" data-id="{{:id}}" data-title="{{:title}}" data-icon="">
    <a href="{{:url}}">{{:title}}</a> <br>{{:address}}{{if phone}}<br><i class="fa fa-phone"></i> {{:phone}}{{/if}}
</div>
{{else}}
  <div class=" p-3">Нет результатов!</div>
{{/for}}


</script>


<?= $this->registerJs(
    <<<JS
  $('.collapse')
                .on('shown.bs.collapse', function() {
                    $(this)
                        .parent('.collapse-parent') 
                        .find(".collapse-item .fa-plus")
                        .removeClass("fa-plus")
                        .addClass("fa-minus");
                })
                .on('hidden.bs.collapse', function() {
                    $(this)
                        .parent('.collapse-parent') 
                        .find(".collapse-item .fa-minus")
                        .removeClass("fa-minus")
                        .addClass("fa-plus");
                });

$( ".map-search-results" ).draggable({
  handle: ".draggable-item"
});


$( ".map-search-form" ).draggable({
  handle: ".draggable-item"
});
$( ".rest-info" ).draggable();
JS

    , \yii\web\View::POS_READY) ?>
