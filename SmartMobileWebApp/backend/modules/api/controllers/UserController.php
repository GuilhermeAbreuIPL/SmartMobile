<?php
namespace backend\modules\api\controllers;
use backend\modules\api\components\CustomAuth;
use common\models\LoginForm;
use common\models\UserForm;
use common\models\Userprofile;
use Yii;
use yii\debug\models\search\Profile;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use common\models\User;
use common\models\Morada;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
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
        //Mostra um user e seu respetivo profile através do token.
        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));
        $userProfile = $user->getUserProfile()->one();

        return[
            'user' =>$user,
            'userProfile'=>$userProfile,
        ];
    }



    public function actionUpdateUserProfile(){
        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));



        $profile = Userprofile::findOne(['id'=>$user->id]);

        $request = Yii::$app->request;

        $data = $request->post();
        if (isset($data['user'])) {
            $user->load($data['user'], '');
        }

        if (isset($data['profile'])) {
            $profile->load($data['profile'], '');
        }


        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($user->validate() && $profile->validate()) {
                $user->save(false); // Save user without re-validating
                $profile->save(false); // Save profile without re-validating
                $transaction->commit();

                return [
                    'status' => 'success',
                    'message' => 'User and profile updated successfully.',
                    'data' => [
                        'user' => $user,
                        'profile' => $profile,
                    ],
                ];
            } else {
                $transaction->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => [
                        'user' => $user->errors,
                        'profile' => $profile->errors,
                    ],
                ];
            }
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new BadRequestHttpException("An error occurred while updating: " . $e->getMessage());
        }


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

    public function actionUpdateMorada($id){

        $user = User::findIdentityByAccessToken(Yii::$app->request->getQueryParam('access-token'));
        $morada = Morada::findOne($id);
        if (!$morada) {
            //TODO: Resposta a dizer que a morada não foi encontrada
            return [
                'success' => false,
                'message' => 'Morada não encontrada.'
            ];
        }


        if ($morada->user_id !== $user->id) {
            //TODO: Resposta a dizer que o utilizador só pode mudar as suas moradas.
            return [
                'success' => false,
                'message' => 'O utilizador apenas pode atualizar as suas moradas.'
            ];
        }

        // Load the data and validate
        $data = \Yii::$app->request->post();
        if (isset($data['id']) || isset($data['user_id'])) {
            //TODO: Resposta a dizer que o id e o user_id não podem ser alterados.
            return[
                'success' => false,
                'message' => 'O id e o user_id não podem ser alterados'
            ];
        }


        $morada->load($data, '');

        if ($morada->validate()) {
            if ($morada->save()) {
                return [
                    'success' => 'success',
                    'message' => 'Morada atualizada com sucesso.',
                    'data' => $morada,
                ];
            }
        }


        return [
            'success' => false,
            'message' => 'Erro a atualizar a morada.',
            'errors' => $morada->errors,
        ];

    }

}