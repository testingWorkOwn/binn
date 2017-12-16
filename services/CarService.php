<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 15.12.17
 * Time: 23:49
 */

namespace app\services;


use app\models\Car;
use app\models\CarRepository;
use app\models\CarType;
use Yii;
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
     * @var CarRepository
     */
    private $carRepository;

    /**
     * CarService constructor.
     * @param BaseService $baseService
     * @param CarRepository $carRepository
     */
    public function __construct(
        BaseService $baseService,
        CarRepository $carRepository
    )
    {
        $this->baseService = $baseService;
        $this->carRepository = $carRepository;
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
     * @param int $id
     * @param CarType $type
     * @return Car|null
     */
    public function update($id, CarType $type)
    {
        $model = $this->carRepository->findOne($id);
        $this->baseService->createNotFoundHttpException($model);
        $model->edit($type);
        if ($type->image instanceof UploadedFile) {
            $oldImage = $model->image;
            $model->image = $this->uploadImage($type->image);
            $this->removeImage($oldImage);
        }
        $this->baseService->save($model);
        return $model;
    }


    /**
     * @param $id
     */
    public function delete($id)
    {
        $model = $this->carRepository->findOne($id);
        $this->baseService->createNotFoundHttpException($model);
        $this->baseService->delete($model);
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function uploadImage(UploadedFile $file): string
    {
        $name = md5(uniqid()) . '.' . $file->getExtension();
        $path = Yii::getAlias('@webroot') . Car::PATH_UPLOAD_PHOTO;
        FileHelper::createDirectory($path);
        $file->saveAs($path . '/' . $name);
        return $name;
    }

    /**
     * @param string $image
     */
    public function removeImage(string $image): void
    {
        $path = Yii::getAlias('@webroot') . Car::PATH_UPLOAD_PHOTO . '/' . $image;
        if (is_file($path)) {
            unlink($path);
        }
    }

    /**
     * @param Car $model
     * @return CarType|object
     */
    public function createType(Car $model)
    {
        return Yii::createObject(CarType::class, [$model]);
    }
}