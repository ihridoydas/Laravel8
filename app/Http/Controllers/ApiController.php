<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function studentAPI(){
        return ['name'=>'Hridoy chandra das','status'=>'student'];
    }
}
