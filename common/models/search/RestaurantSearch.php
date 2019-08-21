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
        ];
    }

    public function search($params){

        $query = Restaurant::find();

        // add conditions that should always apply here
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $query;
        }


        $query->orderBy('id desc');




        if ($this->minLat && $this->maxLat && $this->minLng && $this->maxLng ){
            $query->andWhere("MBRWithin (place_location,GeomFromText('POLYGON(($this->minLng $this->minLat, $this->minLng $this->maxLat, $this->maxLng $this->maxLat , $this->maxLng $this->minLat , $this->minLng $this->minLat ))') )");

        }

        //@todo make MBR Contaions
//            $query->andWhere("x(place_location)>:minLat and x(place_location)<:maxLat ",['minLat'=>$this->minLat,'maxLat'=>$this->maxLat]);
//            $query->andWhere("y(place_location)>:minLng and x(place_location)<:maxLng ",['minLng'=>$this->minLng,'maxLng'=>$this->maxLng]);

        $query->andWhere(['status'=>Restaurant::STATUS_ACTIVE]);

        return $query;
    }
}
