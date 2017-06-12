<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NoodEnvelop;

/**
 * NoodEnvelopSearch represents the model behind the search form about `app\models\NoodEnvelop`.
 */
class NoodEnvelopSearch extends NoodEnvelop
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nood_envelop_ID', 'event_ID', 'route_ID', 'nood_envelop_volgorde', 'score', 'create_user_ID', 'update_user_ID'], 'integer'],
            [['nood_envelop_name', 'coordinaat', 'opmerkingen', 'create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
    public function searchNotOpenedByGroup($params, $group_id = NULL)
    {
        if ($group_id === NULL) {
            // Get group id of current user.
            $group_id = DeelnemersEvent::find()
                ->select('group_ID')
                ->where('event_ID =:event_id and user_ID =:user_id')
                ->params([':event_id' => Yii::$app->user->identity->selected_event_ID, ':user_id' => Yii::$app->user->id])
                ->one();
            $group_id = $groupModel->group_ID;
        }
        $event = EventNames::find()
            ->where('event_ID =:event_id')
            ->addParams([':event_id' => Yii::$app->user->identity->selected_event_ID])
            ->one();

        // Get route id's for current day.
        $queryRoute = Route::find()
            ->select('route_ID')
            ->orderBy('route_volgorde');

        if($event->active_day == NULL) {
            $queryRoute->where('event_ID =:event_id and (day_date =:day_date OR day_date =:introductie)')
                ->params([
                    ':event_id' => Yii::$app->user->identity->selected_event_ID,
                    ':day_date' => $event->active_day,
                    ':introductie' => '0000-00-00'
                ]);
        } else {
            $queryRoute->where('event_ID =:event_id and day_date =:day_date')
                ->params([':event_id' => Yii::$app->user->identity->selected_event_ID, ':day_date' => $event->active_day]);
        }

        // Find all open hints for founr group id
        $queryOpenHints = OpenNoodEnvelop::find()
            ->select('nood_envelop_ID')
            ->where('event_ID=:event_id AND group_ID=:group_id AND opened=:opened')
            ->addParams([
                ':event_id' => Yii::$app->user->identity->selected_event_ID,
                ':group_id' => $group_id,
                ':opened' => OpenNoodEnvelop::STATUS_open
            ]);

        // Find all hinits NOT opened by found group id.
        $query = NoodEnvelop::find()
            ->where(['not in', 'tbl_nood_envelop.nood_envelop_ID', $queryOpenHints])
            ->andwhere(['in', 'tbl_nood_envelop.route_ID', $queryRoute])
            ->andWhere('event_ID=:event_id')
            ->addParams([
                ':event_id' => Yii::$app->user->identity->selected_event_ID
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'nood_envelop_ID' => $this->nood_envelop_ID,
            'event_ID' => $this->event_ID,
            'route_ID' => $this->route_ID,
            'nood_envelop_volgorde' => $this->nood_envelop_volgorde,
            'score' => $this->score,
            'create_time' => $this->create_time,
            'create_user_ID' => $this->create_user_ID,
            'update_time' => $this->update_time,
            'update_user_ID' => $this->update_user_ID,
        ]);

        $query->andFilterWhere(['like', 'nood_envelop_name', $this->nood_envelop_name])
            ->andFilterWhere(['like', 'coordinaat', $this->coordinaat])
            ->andFilterWhere(['like', 'opmerkingen', $this->opmerkingen]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchOpenedByGroup($params, $group_id = NULL)
    {
        if ($group_id === NULL) {
            // Get group id of current user.
            $group_id = DeelnemersEvent::find()
                ->select('group_ID')
                ->where('event_ID =:event_id and user_ID =:user_id')
                ->params([':event_id' => Yii::$app->user->identity->selected_event_ID, ':user_id' => Yii::$app->user->id])
                ->one();
            $group_id = $groupModel->group_ID;
        }
        // Find all open hints for founr group id
        $queryOpenHints = OpenNoodEnvelop::find()
            ->select('nood_envelop_ID')
            ->where('event_ID=:event_id AND group_ID=:group_id AND opened=:opened')
            ->addParams([
                ':event_id' => Yii::$app->user->identity->selected_event_ID,
                ':group_id' => $group_id,
                ':opened' => OpenNoodEnvelop::STATUS_open
            ]);

        // Find all hinits NOT opened by found group id.
        $query = NoodEnvelop::find()
            ->where(['in', 'tbl_nood_envelop.nood_envelop_ID', $queryOpenHints])
            ->andWhere('event_ID=:event_id')
            ->addParams([
                ':event_id' => Yii::$app->user->identity->selected_event_ID
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['create_time' => SORT_ASC]],
            'pagination' => [
                'pageSize' => 1,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'nood_envelop_ID' => $this->nood_envelop_ID,
            'event_ID' => $this->event_ID,
            'route_ID' => $this->route_ID,
            'nood_envelop_volgorde' => $this->nood_envelop_volgorde,
            'score' => $this->score,
            'create_time' => $this->create_time,
            'create_user_ID' => $this->create_user_ID,
            'update_time' => $this->update_time,
            'update_user_ID' => $this->update_user_ID,
        ]);

        $query->andFilterWhere(['like', 'nood_envelop_name', $this->nood_envelop_name])
            ->andFilterWhere(['like', 'coordinaat', $this->coordinaat])
            ->andFilterWhere(['like', 'opmerkingen', $this->opmerkingen]);

        return $dataProvider;
    }
}
