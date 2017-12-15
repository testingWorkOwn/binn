<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 15.12.17
 * Time: 23:49
 */

namespace app\services;


use app\models\Car;
use app\models\CarType;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class CarService
 * @package app\services
 */
class CarService
{
    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * CarService constructor.
     * @param BaseService $baseService
     */
    public function __construct(
        BaseService $baseService
    )
    {
        $this->baseService = $baseService;
    }


    /**
     * @param CarType $type
     * @return Car
     */
    public function create(CarType $type)
    {
        $model = Car::create($type);
        $model->image = $this->uploadImage($type->image);
        $this->baseService->save($model);
        return $model;
    }

    /**
     * @param CarType $type
     */
    public function update(CarType $type)
    {

    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function uploadImage(UploadedFile $file)
    {
        $name = md5(uniqid()) . '.' . $file->getExtension();
        $path = \Yii::getAlias('@webroot') . Car::PATH_UPLOAD_PHOTO;
        FileHelper::createDirectory($path);
        $file->saveAs($path . '/' . $name);
        return $name;
    }

    /**
     * @param Car $model
     * @return CarType|object
     */
    public function createType(Car $model)
    {
        return \Yii::createObject(CarType::class, [$model]);
    }
}