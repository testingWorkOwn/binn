<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 16:40
 */

namespace app\rules;


use app\models\Car;
use yii\caching\TagDependency;
use yii\helpers\ArrayHelper;
use yii\web\UrlRule;

/**
 * Class CarRule
 * @package app\rules
 */
class CarRule extends UrlRule
{
    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {
        if (!preg_match($this->pattern, $request->getPathInfo(), $matches)) {
            return false;
        }

        $matches = $this->substitutePlaceholderNames($matches);

        $id = ArrayHelper::getValue(static::getMapKeyUrl(), $matches['url']);

        if (is_null($id)) {
            return false;
        }

        return ['car/view', ['id' => $id]];
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|string
     */
    public function createUrl($manager, $route, $params)
    {
        if ($route != 'car/view') {
            return false;
        }
        if (!isset($params['id']) && !is_numeric($params['id'])) {
            return false;
        }

        $url = ArrayHelper::getValue(static::getMapKeyId(), $params['id']);

        if (is_null($url)) {
            return false;
        }

        return '/car/' . $url;
    }

    /**
     * @return mixed
     */
    public static function list()
    {
        static $list;

        if (is_null($list)) {
            $key = [
                __CLASS__,
                __METHOD__,
                __LINE__
            ];

            $dependency = new TagDependency([
                'tags' => [
                    Car::class,
                ]
            ]);

            $list = \Yii::$app->cache->getOrSet($key, function () {
                return Car::find()->asArray()->all();
            }, null, $dependency);

        }

        return $list;
    }

    /**
     * @return array
     */
    public static function getMapKeyUrl()
    {
        static $map;
        if (is_null($map)) {
            $map = ArrayHelper::map(static::list(), 'url', 'id');
        }
        return $map;
    }

    /**
     * @return array
     */
    public static function getMapKeyId()
    {
        static $map;
        if (is_null($map)) {
            $map = ArrayHelper::map(static::list(), 'id', 'url');
        }
        return $map;
    }
}