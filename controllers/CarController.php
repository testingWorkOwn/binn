<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 15:37
 */

namespace app\controllers;


use app\models\CarRepository;
use app\models\CarSearch;
use app\services\BaseService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class CarController
 * @package app\controllers
 */
class CarController extends Controller
{
    /**
     * @var CarRepository
     */
    private $carRepository;

    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * CarController constructor.
     * @param string $id
     * @param Module $module
     * @param CarRepository $carRepository
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CarRepository $carRepository,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->carRepository = $carRepository;
        $this->baseService = $baseService;
    }


    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->searchOnfrontend(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $model = $this->carRepository->findOne($id);
        $this->baseService->createNotFoundHttpException($model);

        return $this->render('view', ['model' => $model]);
    }
}