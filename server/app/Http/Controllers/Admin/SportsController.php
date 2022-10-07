<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SportResource;
use App\Models\Sport;
use Illuminate\Http\Request;

class SportsController extends Controller
{
    public function index()
    {
        return SportResource::collection(Sport::all());
    }
}
