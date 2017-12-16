<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 15:37
 */

namespace app\controllers;


use app\models\CarSearch;
use Yii;
use yii\web\Controller;

/**
 * Class CarController
 * @package app\controllers
 */
class CarController extends Controller
{

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
}