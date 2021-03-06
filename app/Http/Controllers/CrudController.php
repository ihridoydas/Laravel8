<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Crud;
use Session;
use Illuminate\Support\Facades\Validator;


class CrudController extends Controller

{
    //Data Show in Crud Application

    public function showData()
    {

        //$showData = Crud::all();

        $showData = Crud::simplePaginate(5);
        return view('crud.show_data', compact('showData'));
    }

    public function addData()
    {
        return view('crud.add_data');
    }

    public function storeData(Request $request)
    {

        $rules = [

            'name' => 'required|max:20',
            'email' => 'required|email',
        ];
        $this->validate($request, $rules);

        $crud = new Crud();

        $crud->name = $request->name;
        $crud->email = $request->email;
        $crud->save();

        Session::flash('msg', 'Data successfully added');

        return redirect('/crud');
    }
    public function editData($id = null)
    {

        $editData = Crud::find($id);

        return view('crud/edit_data', compact('editData'));
    }

    //Update Data in Crud Application

    public function updateData(Request $request, $id)
    {

        $rules = [

            'name' => 'required|max:20',
            'email' => 'required|email',
        ];
        $this->validate($request, $rules);

        $crud = Crud::find($id);

        $crud->name = $request->name;
        $crud->email = $request->email;
        $crud->save();

        Session::flash('msg', 'Data successfully Updated');

        return redirect('/crud');
    }

    public function deleteData($id)
    {
        $deleteData = Crud::find($id);

        $deleteData->delete();

        Session::flash('msg', 'Data successfully Deleted');
        return redirect('/crud');
    }

    //End Crud Application






    // Start API practise for Crud Table


     // Get Method in API 
    public function GetCrudApi()
    {
         //this Crud is Model name
        // return Crud::all();
       
        try {
             //this Crud is Model name
            $cruds = Crud::all();
            return \response([

                'cruds' => $cruds,
                'message' => 'success'
            ]);
        } catch (execption $ex) {
            return \response ([
                'messege'=>$ex->getMessage(),

            ]);
        }
       
    }

         //POST Method in API (Crud table in database)
    public function PostCrudApi(Request $request){

     
        //Valitor form api //use Validator

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:12',
            'email' => 'required|email',
            
        ]);

        if($validator->fails()){

            return \response([
                'message'=> $validator->errors()->all(),
            ]);

        }

        try{
            $cruds = new Crud();

            $cruds->name=$request-> name;
            $cruds->email=$request->email;
          
            $cruds->save();

            return \response([

               'message'=>'Data Created Sucessfully',
               'Crud'=>$cruds,

            ]);

        }catch(Exception $ex){

            return \response([
                'message'=>$ex->getMessage(),
            ]);
        }
            
    }

    //Put / Update Method API

    public function PutCrudApi(Request $request,$id){

        try{
            $cruds = Crud::find($id);


            $cruds->name=$request-> name;
            $cruds->email=$request->email;
            $cruds->update();

            return \response([

                'Message'=>'Data Update Sucessfully',
                'Cruds'=>$cruds,
            ]);
             

        }catch(\Throwable $th){
            return \response([

                'Message'=> $th->getMessage(),
            ]);

        }

    }

    //Delete resposne in API

    public function DeleteCrudApi(Request $request,$id){

        try{
            $deleteCrud = Crud::find($id);
            $deleteCrud->delete();
    
            return \response([
    
                'message'=>'Data Sucessfully Deleted'
            ]);

        }catch(Exception $ex){
                return \response([

                // 'message'=> $ex->getMessage(),

                'message'=>'ERROR Please check information',
                ]);


        }
        
       
    }


    //End API Practise 
}
