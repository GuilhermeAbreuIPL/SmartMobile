<?php
namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Userprofile;


class UserSearch extends User
{
    public $nome;
    public $nif;
    public $telemovel;


    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'verification_token', 'nome', 'nif', 'telemovel'], 'safe'],
        ];
    }

    public function search($params)
    {

        //$query = User::find()->with('userprofile');
        $query= User::find()->joinWith('userprofile',);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);


        if (!$this->load($params) || !$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token])
            ->andFilterWhere(['like', 'userprofile.nome', $this->nome])
            ->andFilterWhere(['like', 'userprofile.nif', $this->nif])
            ->andFilterWhere(['like', 'userprofile.telemovel', $this->telemovel]);

        return $dataProvider;
    }


}