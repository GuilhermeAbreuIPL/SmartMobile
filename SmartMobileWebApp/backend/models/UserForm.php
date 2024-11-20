<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use common\models\Userprofile;

class UserForm extends Model
{
    //Campos do user
    public $username;
    public $email;
    public $password;

    //Campos do userprofile
    public $nome;
    public $nif;
    public $telemovel;

    //Campo Role
    public $role;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //campos do user
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],


            //Campos do userprofile
            ['nome', 'required', 'message' => 'O nome é obrigatório'],
            ['nome', 'string', 'max' => 45],
            ['nif', 'required', 'message' => 'O NIF é obrigatório'],
            ['telemovel', 'required', 'message' => 'O numero de telemóvel é obrigatório'],

            //Campo Role
            ['role', 'required'],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        //$user->generateEmailVerificationToken();
        if (!$user->save()) {
            return null;
        }

        //Campos profile.
        $profile = new Userprofile();
        $profile->id = $user->id;
        $profile->nome = $this->nome;
        $profile->nif = $this->nif;
        $profile->telemovel = $this->telemovel;
        if (!$profile->save()) {
            return null;
        }

        //Atribuição da role funcional.

        $auth = \Yii::$app->authManager;
        $userRole = $auth->getRole($this->role);
        $auth->assign($userRole, $user->id);
        return true;
    }

}