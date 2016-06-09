<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use iConference\Roles\Speaker;

class SpeakersController extends Controller
{
    public function index()
    {
    	return (new Speaker)->all();
    }
}
