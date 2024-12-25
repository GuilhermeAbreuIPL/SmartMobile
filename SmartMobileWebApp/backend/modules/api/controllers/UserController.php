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
use common\models\Morada;
use yii\rest\Controller;
use yii\web\Response;


class UserController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(), //Antes era queryparam
            //'except' => ['register' , 'login']
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
        //TODO: Descobrir como fazer os updates
    }

    public function actionCreateMorada(){
        $request = Yii::$app->request;
        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));
        $moradasUser = Morada::find()->where(['user_id' => $user->id])->all();
        $count = count($moradasUser);

        if($count >= 3)
        {
            $request = YII::$app->response->statusCode = 409;
            //Proibir não é possivel adicionar uma nova morada.
            return[
                'erro' => 'Só são permitidas 3 moradas.'
            ];
        }

        $morada  = new Morada();
        $morada->load($request->post(), '');
        $morada->user_id = $user->id;

        if(!$morada->save()){
            $request = YII::$app->response->statusCode = 400;
            return [
                'errors' => $morada->getErrors(),
            ];
        }


        return [
            'success' => true,
            'morada' => $morada
        ];



    }

    public function actionMoradas(){
        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));
        $moradasUser = Morada::find()->where(['user_id' => $user->id])->all();

        return [
            'success' => true,
            'moradas' => $moradasUser,

        ];
    }

    public function actionUpdateMorada(){
        $request = Yii::$app->request;
        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));
        $morada = Morada::find()->where(['user_id' => $user->id])->one();
        $morada->load($request->post(), '');
        if(!$morada->save()){
            $request = YII::$app->response->statusCode = 400;
            return [
                'errors' => $morada->getErrors(),
            ];
        }
        return [
            'success' => true,
            'morada' => $morada
        ];
    }
}