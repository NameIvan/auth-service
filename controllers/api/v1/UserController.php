<?php

namespace app\controllers\api\v1;

use app\files\JsonFileEnum;
use app\modules\User\forms\SignupForm;
use Yii;
use yii\rest\Controller;
use Nahid\JsonQ\Jsonq;

class UserController extends Controller
{

    /**
     * @OA\Post(
     *    path="/api/v1/user/signup",
     *    @OA\Parameter(
     *        name="firstname",
     *        in="path",
     *        required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="lastname",
     *        in="path",
     *        required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="nickname",
     *        in="path",
     *        required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="password",
     *        in="path",
     *        required=true,
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="age",
     *        in="path",
     *        required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              example={
     *                  "firstname":"Artem", "lastname":"Art","nickname":"art20", "password":"pass123", "age":20,
     *              }
     *           )
     *       )
     *    ),
     *    @OA\Response(
     *      response=201,
     *      description="Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              example={
     *                  "id": 1,
     *                  "firstname": "Artem",
     *                  "lastname": "Art",
     *                  "nickname": "art20",
     *                  "age": 20,
     *              }
     *           )
     *       )
     *    ),
     *    @OA\Response(
     *      response=400,
     *      description="Request data is not valid",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              example={
     *                  "firstname": {"Firstname cannot be blank."},
     *                  "nickname": {"Nickname already exists."}
     *              }
     *           )
     *       )
     *    )
     * )
     */
    public function actionSignup()
    {
        /* @var $signupForm SignupForm */
        $signupForm = new SignupForm();
        $signupForm->setAttributes(Yii::$app->request->getBodyParams());
        if (!$signupForm->validate()) {
            Yii::$app->response->statusCode = 400;
            return $signupForm->errors;
        }

        /** @var \app\modules\User\factories\UserFactory $userFactory */
        $userFactory = Yii::$container->get("UserFactory");
        $user = $userFactory->create($signupForm);
        unset($user->password);

        Yii::$app->response->statusCode = 201;

        return $user;
    }

    /**
     * @OA\Post(
     *    path="/api/v1/user/signin",
     *    @OA\Parameter(
     *        name="nickname",
     *        in="path",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\Parameter(
     *        name="password",
     *        in="path",
     *        @OA\Schema(type="string")
     *    ),
     *    @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              example={"nickname": "art20", "password": "pass123"}
     *           )
     *       )
     *    ),
     *    @OA\Response(
     *      response=200,
     *      description="Ok",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              example={
     *                  "id": 1,
     *                  "firstname": "Artem",
     *                  "lastname": "Art",
     *                  "nickname": "art20",
     *                  "age": 20,
     *              }
     *           )
     *       )
     *    ),
     *    @OA\Response(
     *      response=403,
     *      description="Nickname or password is incorrect",
     *    )
     * )
     */
    public function actionSignin()
    {
        if (Yii::$app->request->post('nickname')) {
            $nickname = trim(htmlspecialchars(Yii::$app->request->post('nickname')));

            $jsonq = new Jsonq(Yii::$app->basePath . JsonFileEnum::USERS);
            $user = $jsonq->from('users')
                ->where('nickname', '=', $nickname)
                ->first();

            if ($user && md5(Yii::$app->request->post('password')) === $user->password) {
                unset($user->password);
                return $user;
            }
        }

        Yii::$app->response->statusCode = 403;
    }
}