<?php

namespace frontend\controllers;

use common\models\Restaurant;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 */
class RestaurantsController extends Controller
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => ['@' ],
                    ],
                    [
                        'actions' => ['map'],
                        'allow' => true,
                        'roles' => ['@','?'],
                    ],
                ],
            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'delete' => ['post'],
//                ],
//            ],
        ];
    }


    public $defaultAction = 'map';
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionMap()
    {
        $this->view->registerJsFile('/js/autocomplete.js');
        $this->view->registerJsFile('/dist/js/places.js', ['depends' => 'yii\web\JqueryAsset']);
////        $this->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');  // TODO clusters for place's markers
        $this->view->registerJsFile('//maps.googleapis.com/maps/api/js?key=' . \Yii::$app->params['GoogleJsAPI'] . '&libraries=visualization,places');


        return $this->render('map');
    }


    public function actionAdd(){
        $model = new Restaurant();

        $model->load(\Yii::$app->request->post());
        if ($model->validate()){
            if ($model->save()){
                return $this->redirect($model->url);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

    public function actionView($id){
        $model = Restaurant::find()->andWhere(['id'=>$id])->one();

        return $this->render('view',['model'=>$model]);
    }

}