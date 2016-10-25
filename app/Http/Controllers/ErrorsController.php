<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ErrorsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function show($id)
    {
        return view('errors.'.$id);
    }


}
