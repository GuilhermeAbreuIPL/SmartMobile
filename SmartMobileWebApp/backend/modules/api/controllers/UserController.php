<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\LoginForm;
use common\models\UserForm;
use common\models\Userprofile;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\User;
use yii\rest\Controller;
use yii\web\Response;


class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(), //Antes era queryparam
            'except' => ['register' , 'login']
        ];

        return $behaviors;
    }

    public function actionShow()
    {
        //TODO: Try to understand if this is actually it.
        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));
        $userProfile = $user->getUserProfile()->one();

        return[
            'user' =>$user,
            'userProfile'=>$userProfile,
        ];
    }



    public function actionUpdate(){



    }

    //TODO: Desenvolver outras funcionalidades.
}