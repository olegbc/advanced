<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\InvitationsList;

/**
 * UserSearch represents the model behind the search form about `common\models\InvitationsList`.
 */
class InvitationsListSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role', 'status', 'sex', 'sent_date', 'registration_date', 'created_at', 'updated_at'], 'integer'],
            [['auth_key', 'password_hash', 'password_reset_token', 'account_registration_token', 'email', 'name', 'location', 'inviter'], 'safe'],
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
    public function search($params, $email)
    {
//        $query = User::find()->andWhere(['inviter' => $email]);
        $query = User::find()->andWhere(['not', ['sent_date' => 0]])->andWhere(['inviter' => $email]);
//        $query = User::find()->andWhere(
//            [
//                ['sent_date' => 0],
//                ['inviter' => null]
//            ]
//        );
//        $query = User::find()->andWhere(['not',['sent_date' => 0]]);

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
            'role' => $this->role,
            'status' => $this->status,
            'sex' => $this->sex,
            'sent_date' => $this->sent_date,
            'registration_date' => $this->registration_date,
            'inviter' => $this->inviter,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'account_registration_token', $this->account_registration_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'inviter', $this->inviter])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
