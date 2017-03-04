<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests;

class GamesController extends Controller
{
    public function next()
    {
    	return [
    		['teamB' => 'Express Kindness', 'logoB' => 'logo.png', 'date' => '21:30 01-02-2017', 'place' => 'Politeh', 'round' => '3rd Round'],
    		['teamB' => 'Energy', 'logoB' => 'logo.png', 'date' => '19:30 05-02-2017', 'place' => 'Politeh', 'round' => '4rd Round']
    	];
    }

    public function last()
    {
    	return [
    		[
    			'teamB' => 'Express Kindness', 'logoB' => 'logo.png', 'date' => '21:30 01-02-2017', 'place' => 'Politeh', 'round' => '3rd Round', 
    			'teamA' => 'MightyDucks', 'goalsA' => '4', 'goalsB' => '5', 'logoA' => 'logo.png', 'championship' => 'Winter Championship',
    			'scorers' => ['Yaromenko', 'Ovchinnikov'], 'assistants' => ['Ovchinnikov', 'Kuharenko']
    		],
    		[
    			'teamB' => 'Energy', 'logoB' => 'logo.png', 'date' => '19:30 05-02-2017', 'place' => 'Politeh', 'round' => '4rd Round',
    			'teamA' => 'MightyDucks', 'goalsA' => '4', 'goalsB' => '5', 'logoA' => 'logo.png', 'championship' => 'Winter Championship',
    			'scorers' => ['Yaromenko', 'Ovchinnikov'], 'assistants' => ['Ovchinnikov', 'Kuharenko'], 'ycs' => ['Ovchinnikov', 'Kuharenko']
    		]
    	];
    }    
}
