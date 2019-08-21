<?php
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
        'lat' =>  55.0415,
        'lng' =>82.9346
    ];
endif;


use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\ActiveForm; ?>

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

    <div class="map-search-results  collapse-parent   ">
        <div class=" px-3">
            <?= Html::a('<i class="fa fa-arrows-alt  "></i>', '#', ['class' => 'draggable-item']) ?>
            <?= Html::a('<i class="fas fa-minus  "></i>', '#', ['class' => 'collapse-item float-right', 'data-toggle' => 'collapse', 'data-target' => '#map-filter-form-collapse']) ?>

        </div>
        <hr class="mt-md-1 mb-md-1">
        <div class="px-3">
            <h3>Результаты:</h3>
            <div class="collapse show" id="place-filter-collapse">
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
        <h3>Поиск </h3>

        <div class="collapse show" id="place-filter-form-collapse">

            <?php $form = ActiveForm::begin([
                'id' => 'search-form'
            ]); ?>
<!--            --><?//= $form->field($searchModel, 'category_id')->checkboxList(\app\models\Place::$_category_id, ['class' => 'vertical']) ?>
            <?= Html::activeHiddenInput($searchModel, 'minLat') ?>
            <?= Html::activeHiddenInput($searchModel, 'minLng') ?>
            <?= Html::activeHiddenInput($searchModel, 'maxLng') ?>
            <?= Html::activeHiddenInput($searchModel, 'maxLat') ?>
            <?php ActiveForm::end(); ?>
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
  <div style="    padding: 5px 20px;">No places found!</div>
{{/for}}

</script>

