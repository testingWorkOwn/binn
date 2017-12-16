<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 0:47
 */

namespace app\services;


use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

/**
 * Class BaseService
 * @package app\services
 */
class BaseService
{
    /**
     * @param ActiveRecord $model
     */
    public function save(ActiveRecord $model)
    {
        if (!$model->save()) {
            throw new \RuntimeException('Saving error');
        }
    }

    /**
     * @param ActiveRecord|null $model
     * @throws NotFoundHttpException
     */
    public function createNotFoundHttpException(ActiveRecord $model = null)
    {
        if (is_null($model)) {
            throw new NotFoundHttpException('The required page does not exist');
        }
    }

    /**
     * @param ActiveRecord $model
     */
    public function delete(ActiveRecord $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Saving error');
        }
    }
}