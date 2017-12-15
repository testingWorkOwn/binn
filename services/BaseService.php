<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 0:47
 */

namespace app\services;


use yii\db\ActiveRecord;

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
}