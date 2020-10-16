<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CsvRequest;
use App\Imports\CsvImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use App\Services\MatchingService;
use Illuminate\Support\Facades\Auth;

class MentoringController extends Controller
{
    private $matchingService;

    public function __construct(MatchingService $service)
    {
        $this->matchingService = $service;
    }

    public function create (){
        return redirect('/home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CsvRequest $request)
    {
        // check the first row number
        $firstRow = $request->header ? 2 : 1;

        // csv data validation
        try {
            Excel::import(new CsvImport($firstRow), $request->file('file'),'public',\Maatwebsite\Excel\Excel::CSV);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            Log::error($failures);
            $error = '';
            foreach ($failures as $failure) {
                $error .= $failure->errors()[0] . ' on row ' .  $failure->row() . '.<br>';
            }
            return redirect()->back()->withErrors(['file' => $error]);
        }

        // csv data read
        $data = Excel::toArray(new CsvImport($firstRow), $request->file('file'),'public',\Maatwebsite\Excel\Excel::CSV);
        $data = $data[0];

        // check column count
        if(count($data[0]) < $this->matchingService->columnCount)
            return redirect()->back()->withErrors(['file' => 'The file must contain 5 columns.']);

        // check the matches
        $data = $this->matchingService->getListOfMatches($data);

        // log the user and the results
        Log::info(Auth::user());
        Log::info($data);

        return view('results', ['data' => $data['data'], 'average' => $data['average'], 'count' => $data['count']  ]);

    }

}
