<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\LinhaCarrinho;
use common\models\LoginForm;
use common\models\UserForm;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\User;
use yii\rest\Controller;
use yii\web\Response;

/*
 * O AuthController dá extend do Controller em vez do Active porque não são necessárias
  as funcionalidades do activeController.
*/
class AuthController extends Controller
{


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

        $user->create();
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

        YII::$app->response->statusCode = 401;
        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }

}