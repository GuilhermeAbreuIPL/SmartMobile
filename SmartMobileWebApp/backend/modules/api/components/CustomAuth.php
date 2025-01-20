<?php

namespace backend\modules\api\components;

use Yii;
use yii\filters\auth\AuthMethod;
use common\models\User;
use yii\web\ForbiddenHttpException;

class CustomAuth extends AuthMethod
{

    /**
     * @inheritDoc
     */
    public function authenticate($user, $request, $response)
    {
        $token = $request->getQueryParam('access-token');
        $user = User::findIdentityByAccessToken($token);

        if(!$user){
            throw new ForbiddenHttpException('No Auth');
        }

        Yii::$app->params['id'] = $user->id;
        return $user;
        // TODO: Implement authenticate() method.

    }
}