<?php

namespace app\controllers\api\v1;

use app\modules\Log\forms\LogForm;
use app\modules\RabbitMq\enums\RabbitMqQueueNameEnum;
use app\modules\RabbitMq\enums\RabbitMqRoutingKeyEnum;
use Yii;
use yii\rest\Controller;

class LogController extends Controller
{
    /**
     * @OA\Info(title="Authorization Service API", version="1")
     */

    /**
     * @OA\Post(path="/api/v1/log",
     *   @OA\Parameter(
     *     name="id_user",
     *     in="path",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(
     *     name="source_label",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\RequestBody(
     *       @OA\MediaType(
     *           mediaType="application/json",
     *           @OA\Schema(
     *              example={
     *                  "id_user":1, "source_label":"search_page",
     *              }
     *           )
     *       )
     *    ),
     *   @OA\Response(response=201,
     *     description="Created"
     *   ),
     *   @OA\Response(response=404,
     *     description="Not found action"
     *   ),
     *   @OA\Response(response=500,
     *     description="500 Internal Server Error"
     *   )
     * )
     */
    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            /* @var $logForm LogForm */
            $logForm = new LogForm();
            $logForm->setAttributes(Yii::$app->request->getBodyParams());
            if (!$logForm->validate()) {
                Yii::$app->response->statusCode = 400;
                return $logForm->errors;
            }

            $dataLog = [
                'id_user' => $logForm->id_user,
                'source_label' => $logForm->source_label,
                'date_created' => date("Y-m-d H:i:s"),
                // 'ip' use if user is not authorized
                'ip' => Yii::$app->getRequest()->getUserIP()
            ];

            /** @var \app\modules\RabbitMq\components\RabbitMqProducerBuilder $rabbitMqProducerBuilder */
            $rabbitMqProducerBuilder = Yii::$container->get("RabbitMqProducerBuilder");
            $rabbitMqProducerBuilder->send(
                RabbitMqQueueNameEnum::MS_ANALYTICS_LOG,
                $dataLog,
                RabbitMqRoutingKeyEnum::ADD_LOG
            );

            Yii::$app->response->statusCode = 201;
        } else {
            Yii::$app->response->statusCode = 404;
        }
    }
}