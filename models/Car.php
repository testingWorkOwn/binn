<?php

namespace app\models;

use DomainException;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * Автомобили.
 *
 * @property integer $id         Id
 * @property integer $status     Статус видимости (0 - не опубликован, 1-опубликован)
 * @property integer $categoryId Модельный ряд
 * @property string  $title      Название
 * @property string  $image      Изображение
 * @property integer $price      Цена
 * @property integer $year       Год
 * @property string  $url        Ссылка на автомобиль
 * @property integer $created_at Дата создания
 * @property integer $updated_at Дата обновления
 *
 */
class Car extends \yii\db\ActiveRecord
{
    /**
     *
     */
    const STATUS = [
        1 => 'не опубликован',
        2 => 'опубликован',
    ];


    /**
     *
     */
    const CATEGORY_ID = [
        1 => 'Ниссан',
        2 => 'Вольво',
        3 => 'Форд'
    ];

    /**
     * Количество отображаемых элементов в списке.
     */
    public $pageSize = 5;

    /**
     * Путь к папке с загруженными фото.
     */
    const PATH_UPLOAD_PHOTO = '/upload/car/img';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%car}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'status' => Yii::t('app', 'Статус'),
            'title' => Yii::t('app', 'Название'),
            'image' => Yii::t('app', 'Изображение'),
            'categoryId' => Yii::t('app', 'Модельный ряд'),
            'price' => Yii::t('app', 'Цена'),
            'url' => Yii::t('app', 'Ссылка на страницу'),
            'year' => Yii::t('app', 'Год выпуска'),
            'created_at' => Yii::t('app', 'Дата создания'),
            'updated_at' => Yii::t('app', 'Дата обновления'),
        ];

    }

    /**
     * @inheritdoc
     * @return CarQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CarQuery(get_called_class());
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
        ];
    }


    /**
     * @param CarType $type
     * @return static
     */
    public static function create(CarType $type)
    {
        $model = new static();
        $model->status = $type->status;
        $model->title = $type->title;
        $model->categoryId = $type->categoryId;
        $model->price = $type->price;
        $model->updateUrl($type->url);
        $model->year = $type->year;
        return $model;
    }

    /**
     * @param CarType $type
     */
    public function edit(CarType $type): void
    {
        $this->status = $type->status;
        $this->title = $type->title;
        $this->categoryId = $type->categoryId;
        $this->price = $type->price;
        $this->updateUrl($type->url);
        $this->year = $type->year;
    }

    /**
     * @param string $url
     */
    public function updateUrl(string $url): void
    {
        $this->url = $url;
        if ($this->isAttributeChanged('url')) {
            $repository = new CarRepository();
            if ($repository->existsUrl($this->url)) {
                throw new DomainException(sprintf('Url "%s" has already been taken', $this->url));
            }
        }
    }

    /**
     * @return string
     */
    public function getUrlImage(): string
    {
        return static::PATH_UPLOAD_PHOTO . '/' . $this->image;
    }
}
