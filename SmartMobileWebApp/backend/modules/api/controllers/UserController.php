<?php
namespace backend\modules\api\controllers;
use common\models\UserForm;
use Yii;
use yii\rest\ActiveController;
use common\models\User;
use yii\web\Response;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

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


        $userData = $request->post();

        return[
            'success' => true,
            'userdata' => $userData,
            'rawbody' => $rawbody,
        ];
   }
}