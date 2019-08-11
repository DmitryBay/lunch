<?php

namespace frontend\controllers;

use yii\web\Controller;

/**
 * Site controller
 */
class RestaurantsController extends Controller
{

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionMap()
    {
        $this->view->registerJsFile('/js/autocomplete.js');
        $this->view->registerJsFile('/dist/js/places.js', ['depends' => 'yii\web\JqueryAsset']);
//        $this->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');  // TODO clusters for place's markers
        $this->view->registerJsFile('//maps.googleapis.com/maps/api/js?key=' . Yii::$app->params['GoogleJsAPI'] . '&libraries=visualization,places');


        return $this->render('index');
    }

}