<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 16.12.17
 * Time: 14:01
 */

namespace app\helpers;

use DateInterval;
use DatePeriod;
use DateTime;


/**
 * Class CarHelper
 * @package app\helpers
 */
class CarHelper
{
    /**
     * @return array
     */
    public static function getYearDropDown()
    {
        $start = DateTime::createFromFormat('Y', '2000');
        $finish = DateTime::createFromFormat('Y', '2018');
        $interval = new DateInterval('P1Y');
        $list = [];
        foreach (new DatePeriod($start, $interval, $finish) as $date) {
            /** @var DateTime $date */
            $year = $date->format('Y');
            $list[$year] = $year;
        }
        return $list;
    }
}