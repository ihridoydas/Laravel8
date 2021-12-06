<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Crud;
use Session;

class CrudController extends Controller
{
   
    public function showData(){

        $showData = Crud::all();
        return view('crud.show_data',compact('showData'));
    }

    public function addData(){
        return view('crud.add_data');
    }

    public function storeData(Request $request){

        $rules =[

            'name'=>'required|max:20',
            'email'=>'required|email',
        ];
    $this->validate($request,$rules);

    $crud = new Crud();

    $crud->name = $request->name;
    $crud->email= $request->email;
    $crud->save();

    Session::flash('msg','Data successfully added');

        return redirect()->back();
    }
}
