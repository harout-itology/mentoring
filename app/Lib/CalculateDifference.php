<?php

namespace App\Lib;

class CalculateDifference implements  CalculateInterface{

    public function calculate($employeeFirst, $employeeSecond, $index, $rule, $score)
    {
        $employeeScore = 0;

        if( abs($employeeFirst[$index] - $employeeSecond[$index]) <= $rule )
            $employeeScore = $score;

        return $employeeScore;

    }
}
