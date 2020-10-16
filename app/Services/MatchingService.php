<?php

namespace App\Services;


class MatchingService
{
    private $columns = [
        ['name'=>'name', 'score'=>0, 'class'=>NULL, 'rule'=> 0],
        ['name'=>'email', 'score'=>0, 'class'=>NULL, 'rule'=> 0],
        ['name'=>'division', 'score'=>30, 'class'=>'App\Lib\CalculateEquality', 'rule'=> 0],
        ['name'=>'ageDifference', 'score'=>30, 'class'=>'App\Lib\CalculateDifference', 'rule'=> 5],
        ['name'=>'timezone', 'score'=>40, 'class'=>'App\Lib\CalculateEquality', 'rule'=>0]
    ];

    // name position
    private $nameMapping = 0;
    public $columnCount = 5;

    public function getListOfMatches($data)
    {
        $matchesArray = [];
        $arrayPointer = 0;
        $total = 0;
        $count = 0;

        // get the highest match for each employee separately
        for($i = 0; $i < count($data); $i++) {
            for ($j = $i + 1; $j < count($data); $j++) {
                $score = $this->calculate($data[$i], $data[$j]);
                // first match always add in $matchesArray
                if(!$arrayPointer){
                    $matchesArray[$arrayPointer++] = [
                        'firstSide' => $data[$i][$this->nameMapping],
                        'secondSide' => $data[$j][$this->nameMapping],
                        'score' => $score
                    ];
                }
                // if (the last firstside in $matchesArray is the same as the new firstside) and (the score is smaller than the new score) delete the last match in $matchesArray and add the new one
                else if( ($matchesArray[$arrayPointer-1]['firstSide'] == $data[$i][$this->nameMapping]) && ($matchesArray[$arrayPointer-1]['score'] < $score) ){
                    $matchesArray[$arrayPointer-1] = [
                        'firstSide' => $data[$i][$this->nameMapping],
                        'secondSide' => $data[$j][$this->nameMapping],
                        'score' => $score
                    ];
                }
                // if (the last firstside in $matchesArray is not the same as the new firstside) add the new one
                else if( ($matchesArray[$arrayPointer-1]['firstSide'] != $data[$i][$this->nameMapping])) {
                    $matchesArray[$arrayPointer++] = [
                        'firstSide' => $data[$i][$this->nameMapping],
                        'secondSide' => $data[$j][$this->nameMapping],
                        'score' => $score
                    ];
                }
            }
        }

        // delete duplications
        for($i = 0; $i < count($matchesArray); $i++){
            if ( $duplications = array_keys(array_column($matchesArray, 'secondSide'), $matchesArray[$i]['firstSide'])) {
                $max = $matchesArray[$i]['score'];
                foreach ($duplications as $duplication) {
                    if ( $matchesArray[$duplication]['score'] > $max) {
                        $max = $matchesArray[$duplication]['score'];
                    }
                }
                foreach ($duplications as $duplication) {
                    if ($matchesArray[$duplication]['score'] < $max) {
                        $matchesArray[$duplication]['score'] = 0;
                    }
                }
                if($matchesArray[$i]['score'] < $max){
                    $matchesArray[$i]['score'] = 0;
                }
            }
        }

        // calculate the average
        foreach ($matchesArray as $i => $match){
            if($match['score']){
                $total += $match['score'];
                $count++;
            }
        }

        return  [
            'data' => $matchesArray,
            'average' =>  $total/$count,
            'count' => $count
        ] ;

    }

    public function calculate($employeeFirst, $employeeSecond)
    {
        $employeeScore = 0;

        foreach ($this->columns as $index => $column){
            if($column['score']){
                $calculates = new $column['class'];
                $employeeScore += $calculates->calculate($employeeFirst, $employeeSecond, $index, $column['rule'], $column['score']);
            }
        }

        return $employeeScore;

    }

}

