<?php

namespace frontend\controllers;

use app\models\MenuItems;
use app\models\MProfile;
use common\components\BaseController;
use common\models\Files;
use common\models\Restaurant;
use common\models\search\RestaurantSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['index', 'view', 'ajax-search', 'info'],
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
                    'lng' => $model->lng,
                    'lat' => $model->lat,
                    'phone' => null,
                    'price_category' => $model->price_category,
                    'address' => $model->address,

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

    public function actionAddMenuItem(){
        $model = new MenuItems();
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    public function actionInfo()
    {
        $id = \Yii::$app->request->post('id');

        \Yii::$app->response->format = 'json';
        $model = $this->findModel($id);

        // todo get from model
        $restFiles = Files::find()->joinWith('restaurantFiles')->andWhere(['status' => Files::STATUS_APPROVED, 'rest_id' => $model->id])->all();
        if (!\Yii::$app->user->isGuest) {
            $userRestFiles = Files::find()->joinWith('restaurantFiles')->andWhere(['rest_id' => $model->id])->andWhere(['<>', 'status', Files::STATUS_APPROVED])->all();
        }

        $item = new MenuItems();

        return [
            'html' => $this->renderPartial('_view', [
                'model' => $model,
                'item' => $item,
                'restFiles' => $restFiles,
                'userRestFiles'=> isset($userRestFiles)? $userRestFiles : null
            ]),
            'location' => $model->location,
            'id'=>$model->id
        ];


    }
    /**
     * Finds the MProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Restaurant the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = Restaurant::findOne(['id' => $id, 'status' => Restaurant::STATUS_ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}