<?php

namespace App\Services;

class MatchingService
{
    /* add new column name to the array with the relevant value */
    //  score of each condition
    private $scores = [
        'division' => 30,
        'ageDifference' => 30,
        'timezone' => 40
    ];
    //  position of each condition
    private $mapping = [
        'division' => 2,
        'ageDifference' => 3,
        'timezone' => 4
    ];
    //  condition action
    //  0 => both must be the same or equal
    //  other numbers will be the difference between them
    private $rules = [
        'division' => 0,
        'ageDifference' => 5,
        'timezone' => 0
    ];
    // name position
    private $nameMapping = 0;
    /* add new item to the array with the name of new column */


    public function getListOfMatches($data)
    {
        $finalData = [];
        $total = 0;

        for($i = 0; $i < count($data); $i++) {
            for ($j = $i + 1; $j < count($data); $j++) {
                $score = $this->calculate($data[$i], $data[$j]);
                $finalData[] = [
                    'text' => $data[$i][$this->nameMapping] . ' will be matched with ' . $data[$j][$this->nameMapping],
                    'score' => $score
                ];
                $total += $score;
            }
        }

        // get highest average
        $finalData[] = [
            'text' => 'Employees the highest average match score ',
            'score' => round($total / count($finalData))
        ];

        return $finalData;
    }

    public function calculate($employeeFirst, $employeeSecond)
    {
        $employeeScore = 0;

        foreach ($this->rules as $column => $action){
            if($action){
                if( abs($employeeFirst[$this->mapping[$column]] - $employeeSecond[$this->mapping[$column]]) <= $action )
                    $employeeScore += $this->scores[$column];
            }
            else{
                if(strtolower(trim($employeeFirst[$this->mapping[$column]])) == strtolower(trim($employeeSecond[$this->mapping[$column]])) )
                    $employeeScore += $this->scores[$column];
            }
        }

        return $employeeScore;

    }

}
