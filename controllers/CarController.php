<?php

namespace app\controllers;

use app\models\CarRepository;
use app\services\BaseService;
use app\services\CarService;
use DomainException;
use Yii;
use app\models\Car;
use app\models\CarSearch;
use yii\base\Module;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
    /**
     * @var CarService
     */
    private $carService;
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
     * @param \yii\base\Module $id
     * @param Module $module
     * @param CarService $carService
     * @param CarRepository $carRepository
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        CarService $carService,
        CarRepository $carRepository,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->carService = $carService;
        $this->carRepository = $carRepository;
        $this->baseService = $baseService;
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Car model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $type = $this->carService->createType(new Car());

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = $this->carService->create($type);
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                $transaction->rollBack();
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            }
        }
        return $this->render('create', [
            'type' => $type,
        ]);
    }

    /**
     * Updates an existing Car model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->carRepository->findOne($id);
        $this->baseService->createNotFoundHttpException($model);
        $type = $this->carService->createType($model);
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model = $this->carService->update($id, $type);
                $transaction->commit();
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                $transaction->rollBack();
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            }
        }
        return $this->render('update', [
            'type' => $type,
        ]);
    }

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
