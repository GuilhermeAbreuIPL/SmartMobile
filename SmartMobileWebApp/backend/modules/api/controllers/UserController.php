<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\LoginForm;
use common\models\UserForm;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\User;
use yii\web\Response;


class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(), //Antes era queryparam
            'except' => ['register' , 'login']
        ];

        return $behaviors;
    }

    //TODO: Criar controlador separado para lidar com a logica do registo e do login.
    public function actionRegister(){
        //Link + endpoint: localhost/SmartMobile/SmartMobileWebApp/backend/web/api/user/register
        $request = Yii::$app->request;
        $rawbody = $request->rawBody;


        if(!$request->isPost){
            Yii::$app->response->statusCode = 405;
            return [
                'success' => false,
                'message' => 'O metodo tem de ser POST'
            ];
        }


        $user = new UserForm();
        $userData = $request->post();
        $user->load($userData,'');
        $user->role = 'Cliente';
        if(!$user->validate()){
            Yii::$app->response->statusCode = 400;
            return[
                'success' => true,
                'message' => 'Oops! algo correu mal!',
            ];
        }


        return[
            'success' => true,
            'model' => $user,
            'rawbody' => $rawbody,
        ];
   }

    /**
     * Endpoint relativo ao login.
     *
     * @return array
     *
     */
    public function actionLogin()
    {
        $model = new LoginForm();
        $model->load(Yii::$app->request->post(), '');

        if ($token = $model->loginApi()) {
            return [
                'success' => true,
                'access_token' => $token,
            ];
        }

        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }

    public function actionTest(){

    }
}