<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class AppHelper extends Model
{
  

  public static function getCurrentWeekDates() {

    $first_day_of_the_week = 'Sunday';
    $start_of_the_week     = strtotime("Last $first_day_of_the_week");
    
    if (strtolower(date('l')) === strtolower($first_day_of_the_week) ) {
        $start_of_the_week = strtotime('today');
    }

    $end_of_the_week = $start_of_the_week + (60 * 60 * 24 * 7) - 1;
 
    $dates = [
        'start'=>$start_of_the_week,
        'end'=>$end_of_the_week,
        'start-formatted'=>date('F j',$start_of_the_week),
        'end-formatted'=>date('F j',$end_of_the_week),
    ];

    return $dates;
  }



}
