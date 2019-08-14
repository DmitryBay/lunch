<?php

namespace frontend\controllers;

use common\models\Restaurant;
use yii\web\Controller;

/**
 * Site controller
 */
class RestaurantsController extends Controller
{

//    public $layout = 'main_with_menu';
    public $defaultAction = 'map';
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionMap()
    {
//        $this->view->registerJsFile('/js/autocomplete.js');
//        $this->view->registerJsFile('/dist/js/places.js', ['depends' => 'yii\web\JqueryAsset']);
////        $this->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');  // TODO clusters for place's markers
//        $this->view->registerJsFile('//maps.googleapis.com/maps/api/js?key=' . Yii::$app->params['GoogleJsAPI'] . '&libraries=visualization,places');


        return $this->render('index');
    }


    public function actionAdd(){
        $model = new Restaurant();

        $model->load(\Yii::$app->request->post());
        return $this->render('add',['model'=>$model]);
    }

}