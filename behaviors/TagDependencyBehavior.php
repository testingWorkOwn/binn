<?php

// declare(strict_types=1);

namespace app\behaviors;

use yii;
use yii\base\Behavior;
use yii\caching\TagDependency;
use yii\db\BaseActiveRecord;

/**
 * Class TagDependencyBehavior
 *
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'TagDependencyBehavior' => TagDependencyBehavior::className(),
 *     ];
 * }
 * ```
 *
 * use
 *
 * ```php
 * $dependency = new TagDependency([
 *      'tags' =>
 *      [
 *          Model::className(),
 *      ],
 * ]);
 * ```
 *
 * @package app\modules\structuralUnit\behaviors
 */
class TagDependencyBehavior extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            BaseActiveRecord::EVENT_AFTER_INSERT => 'invalidate',
            BaseActiveRecord::EVENT_AFTER_UPDATE => 'invalidate',
            BaseActiveRecord::EVENT_AFTER_DELETE => 'invalidate',
        ];
    }

    /**
     * Invalidates all of the cached data item that are associated with model.
     */
    public function invalidate()
    {
        $owner = $this->owner;
        TagDependency::invalidate(Yii::$app->cache, [$owner::className()]);
    }
}
