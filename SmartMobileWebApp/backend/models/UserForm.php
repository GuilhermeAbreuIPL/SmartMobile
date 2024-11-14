<?php

namespace backend\models;

use common\models\Userprofile;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $role;
    public $nome;
    public $nif;
    public $telemovel;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
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

            //Rules Do UserProfile
            [['nif', 'telemovel'], 'integer'],
            [['nome'], 'string', 'max' => 45],
            [['telemovel'], 'string', 'max' => 9],
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */


    public function createUser()
    {
        if ($this->validate()) {

            $auth = Yii::$app->authManager;

            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();



            $user->save();

            //UserProfile data
            $userProfile = new Userprofile();
            $userProfile->id = $user->id;
            $userProfile->nome = $this->nome;
            $userProfile->nif = $this->nif;
            $userProfile->telemovel = $this->telemovel;
            $userProfile->save();


            $gestor = $auth->getRole('gestor');
            $funcionario = $auth->getRole('funcionario');
            $cliente = $auth->getRole('cliente');

            if (Yii::$app->request->isPost) {
                $role = Yii::$app->request->post('UserForm')['role'];


                if($role == 'gestor'){
                    $auth->assign($gestor, $user->getId());
                }else if($role == 'funcionario'){
                    $auth->assign($funcionario, $user->getId());
                }else if($role == 'cliente'){
                    $auth->assign($cliente, $user->getId());
                }
            }


            if (!$user->save() || !$userProfile->save()) {
                Yii::$app->session->setFlash('error', 'Erro ao criar utilizador ou perfil.');
                return false;
            }




            return true;
            //return $this->sendEmail($user);
        }

        return null;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    /*
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }
    */
}
