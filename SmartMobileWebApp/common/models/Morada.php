<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "moradas".
 *
 * @property int $id
 * @property string|null $localidade
 * @property string|null $codpostal
 * @property int|null $user_id
 *
 * @property User $id0
 */
class Morada extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moradas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['localidade'], 'string', 'max' => 100],
            [['codpostal'], 'string', 'max' => 8],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'localidade' => 'Localidade',
            'codpostal' => 'Codpostal',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
