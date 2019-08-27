<?php

namespace frontend\controllers;

use common\components\BaseController;
use common\models\Restaurant;
use common\models\search\RestaurantSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Site controller
 */
class RestaurantsController extends BaseController
{


    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','view','ajax-search','info'],
                        'allow' => true,
                        'roles' => ['@', '?'],
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


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->registerJsFile('/js/autocomplete.js');
        $this->view->registerJsFile('/js/places.js', ['depends' => 'yii\web\JqueryAsset']);
////        $this->view->registerJsFile('https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js');  // TODO clusters for place's markers
        $this->view->registerJsFile('//maps.googleapis.com/maps/api/js?key=' . \Yii::$app->params['GoogleJsAPI'] . '&libraries=visualization,places');


        $searchModel = new RestaurantSearch();
        return $this->render('index', ['searchModel' => $searchModel]);
    }


    public function actionAjaxSearch()
    {
        $searchModel = new RestaurantSearch();
        $query = $searchModel->search(\Yii::$app->request->post());
        return $this->asJson([
            'success' => true,
            'items' => array_values(ArrayHelper::map($query->limit(100)->all(), 'id', function ($model) {
                /** @var $model Restaurant */
                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'desc' => $model->desc,
                    'url' => Url::to($model->url),
                    'lng' =>  $model->lng,
                    'lat' =>  $model->lat,
                    'phone' =>  null,
                    'price_category' =>  $model->price_category,
                    'address' =>  $model->address,

                ];
            }))
        ]);

    }


    public function actionAdd()
    {
        $model = new Restaurant();

        $model->load(\Yii::$app->request->post());
        if ($model->validate()) {
            if ($model->save()) {
                return $this->redirect($model->url);
            }
        }

        return $this->render('add', ['model' => $model]);
    }

    public function actionView($id)
    {
        $model = Restaurant::find()->andWhere(['id' => $id])->one();

        return $this->render('view', ['model' => $model]);
    }

    public function actionInfo(){
        $id = \Yii::$app->request->post('id');

        \Yii::$app->response->format = 'json';
        if (!$id) {
            return self::returnError(self::ERROR_NOTFOUND);
        }
        $model = Restaurant::findOne(['id'=>$id,'status'=>Restaurant::STATUS_ACTIVE]);

        if (!$model){
            return self::returnError(self::ERROR_NOTFOUND);
        }

        return [
          'html'=>$this->renderPartial('_view',['model'=>$model]),
            'location'=>$model->location
        ];



    }

}