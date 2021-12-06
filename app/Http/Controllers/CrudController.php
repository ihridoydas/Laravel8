<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Crud;

class CrudController extends Controller
{
   
    public function showData(){
        return view('crud.show_data');
    }

    public function addData(){
        return view('crud.add_data');
    }

    public function storeData(Request $request){

        $rules =[

            'name'=>'required|max:10',
            'email'=>'required|email',
        ];
    $this->validate($request,$rules);

    $crud = new Crud();

        return $request->all();
    }
}
