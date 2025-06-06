<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DirectionCourse;

/**
 * DirectionCourseSearch represents the model behind the search form of `common\models\DirectionCourse`.
 */
class DirectionCourseSearch extends DirectionCourse
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'edu_direction_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_deleted'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $eduDirection)
    {
        $query = DirectionCourse::find()->where([
            'edu_direction_id' => $eduDirection->id,
            'is_deleted' => 0
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'course_id' => $this->course_id,
            'edu_direction_id' => $this->edu_direction_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'is_deleted' => $this->is_deleted,
        ]);

        return $dataProvider;
    }
}
