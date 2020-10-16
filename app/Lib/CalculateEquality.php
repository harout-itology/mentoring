<?php

namespace App\Lib;

class CalculateEquality implements  CalculateInterface{

    public function calculate($employeeFirst, $employeeSecond, $index, $rule, $score)
    {
        $employeeScore = 0;

        if(strtolower(trim($employeeFirst[$index])) == strtolower(trim($employeeSecond[$index])) )
            $employeeScore = $score;

        return $employeeScore;
    }
}
