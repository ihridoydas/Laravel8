<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Crud;
use Session;

class CrudController extends Controller

{
    //Data Show in Crud Application
   
    public function showData(){

        //$showData = Crud::all();

        $showData = Crud::simplePaginate(5);
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

        return redirect('/crud');
    }
    public function editData($id=null){

        $editData = Crud::find($id);

        return view('crud/edit_data',compact('editData'));
    }

    //Update Data in Crud Application

    public function updateData(Request $request,$id){

        $rules =[

            'name'=>'required|max:20',
            'email'=>'required|email',
        ];
    $this->validate($request,$rules);

    $crud =Crud::find($id);

    $crud->name = $request->name;
    $crud->email= $request->email;
    $crud->save();

    Session::flash('msg','Data successfully Updated');

        return redirect('/crud');
    }

    public function deleteData($id){
        $deleteData= Crud::find($id);

        $deleteData->delete();

        Session::flash('msg','Data successfully Deleted');
        return redirect('/crud');

    }
}
