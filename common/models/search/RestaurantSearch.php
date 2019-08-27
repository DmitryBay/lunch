<?php
namespace common\models\search;

use common\models\Restaurant;

class RestaurantSearch extends Restaurant {


    public $minLat;
    public $minLng;
    public $maxLng;
    public $maxLat;

    public function rules(){
        return [
            [['minLat','maxLat','minLng','maxLng'], 'number'],
            [['price_category','type'], 'each', 'rule' => ['integer']]
        ];
    }

    public function search($params){

        $query = Restaurant::find();
        // add conditions that should always apply here
        $this->load($params);

        if (!$this->validate()) {

            // uncomment the following line if you do not want to return any records when validation fails
//             $query->where('0=1');
            return $query;
        }


        $query->orderBy('id desc');




        if ($this->minLat && $this->maxLat && $this->minLng && $this->maxLng ){
            $query->andWhere("MBRWithin (lnglat,GeomFromText('POLYGON(($this->minLng $this->minLat, $this->minLng $this->maxLat, $this->maxLng $this->maxLat , $this->maxLng $this->minLat , $this->minLng $this->minLat ))') )");
        }




        $query
            ->andWhere(['status'=>Restaurant::STATUS_ACTIVE])
            ->andFilterWhere(['price_category'=>$this->price_category])
            ->andFilterWhere(['type'=>$this->type])
        ;

        return $query;
    }
}
