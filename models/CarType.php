<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class CarType
 * @package models\car
 */
class CarType extends Model
{
    /**
     * @var int
     */
    public $status;
    /**
     * @var int
     */
    public $categoryId;
    /**
     * @var string
     */
    public $title;

    /**
     * @var string|UploadedFile
     */
    public $image;
    /**
     * @var int
     */
    public $year;
    /**
     * @var int
     */
    public $price;
    /**
     * @var string
     */
    public $url;


    /**
     * @var Car
     */
    public $model;

    /**
     * CarType constructor.
     * @param Car $model
     * @param array $config
     */
    public function __construct(
        Car $model, array $config = []
    )
    {
        parent::__construct($config);
        if (!$model->isNewRecord) {
            $this->status = $model->status;
            $this->categoryId = $model->categoryId;
            $this->title = $model->title;
            $this->image = $model->image;
            $this->price = $model->price;
            $this->year = $model->year;
            $this->url = $model->url;
        }
        $this->model = $model;
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'status', 'categoryId', 'price', 'year'], 'required'],
            [['status', 'categoryId', 'price'], 'integer'],
            ['year', 'date', 'format' => 'php:Y'],
            [['title', 'url'], 'string', 'max' => 255],
            ['image', 'image', 'skipOnEmpty' => !$this->model->isNewRecord],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return $this->model->attributeLabels();
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->image = UploadedFile::getInstance($this, 'image');
        return parent::beforeValidate();
    }
}
