<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 11:18
 */

namespace app\models;


/**
 * Class CarRepository
 * @package app\models
 */
/**
 * Class CarRepository
 * @package app\models
 */
class CarRepository
{

    /**
     * @param $id
     * @return null|Car
     */
    public function findOne($id)
    {
        return Car::findOne($id);
    }

    /**
     * @param string $url
     * @return bool
     */
    public function existsUrl(string $url): bool
    {
        return (bool)Car::find()->url($url)->exists();
    }
}