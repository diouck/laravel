<?php
namespace Modules\Webmap\Repositories;

class Helper
{
    public static function appreciation($content)
    {
            
        if ($content == 'Très satisfaisant' || $content == 'Assez satisfaisant')
        {
        	$value = 'success';
        } else if ($content == 'Peu satisfaisant') {
        	$value = 'warning';
        } else if ($content == 'Pas du tout satisfaisant') {
        	$value = 'warning';
        } else {
        	$value = 'info';
        }

        $label = '<span class="badge progress-bar-'.$value.'">'.$content.'</span>';

        echo $label;
    }

    public static function sum_cat($pattern, $array) {
        $sum=0;
        foreach($array as $key => $value) {
            if (preg_match($pattern,$key)){
                if ($value != null) {
                    $sum+=$value;
                }
            }
        }
        return $sum;
    }
}