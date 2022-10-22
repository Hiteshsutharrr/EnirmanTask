<?php

namespace App\Http\Controllers;

use App\Models\IfscCode;
use Illuminate\Http\Request;
use Yajra\Datatables\DataTables;
use Session;
use Illuminate\Validation\Rule; 
class IfscCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ifsc_codes.index');
    }

    public function DataTable()
    {
        $data = IfscCode::all();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action',function($data){
            $str = '<a href='.route('ifsc_codes.edit',$data->id).' title="edit" class="btn text-secondary"><i class="fa fa-edit"></i></a>';
            $str .= '<button onclick="destroy('.$data->id.')" class="btn text-danger" title="delete"><i class="fa fa-trash"></i></button>';
            return $str;
        })
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ifsc_codes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'Ifsc_Code'=>[
                            'required',
                            Rule::unique('ifsc_codes')->where(function($query) {
                                $query->where('deleted_at', null);
                            })
                        ],
            'Name'=>'required',
            'PinCode'=>'required',
            'City'=>'required',
            'State'=>'required',
            'PhoneNumber'=>'nullable|min:10|max:10',
        ]);

        IfscCode::create([
            'ifsc_code' =>  $request->Ifsc_Code,
            'name'  =>  $request->Name,
            'city'  =>  $request->City,
            'state' =>  $request->State,
            'pincode' =>  $request->PinCode,
            'phone_number'  =>  $request->PhoneNumber??null,
            'address'   =>  $request->Address??null,
        ]);
        Session::flash('message','Ifsc Code Registered Successfully');
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IfscCode  $ifscCode
     * @return \Illuminate\Http\Response
     */
    public function check_ifsc(Request $request)
    {
        return IfscCode::where('ifsc_code',$request->ifsc_code)
                        ->when($request->id,function($query)use($request){
                            $query->where('id','!=',$request->id);
                        })
                        ->get()
                        ->count();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IfscCode  $ifscCode
     * @return \Illuminate\Http\Response
     */
    public function edit(IfscCode $IfscCode)
    {
        return view('ifsc_codes.edit',compact('IfscCode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IfscCode  $ifscCode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IfscCode $ifscCode)
    {
        $request->validate([
            'Ifsc_Code'=>'required',
            'Name'=>'required',
            'PinCode'=>'required',
            'City'=>'required',
            'State'=>'required',
            'PhoneNumber'=>'nullable|min:10|max:10',
        ]);

        $ifscCode->update([
            'ifsc_code' =>  $request->Ifsc_Code,
            'name'  =>  $request->Name,
            'city'  =>  $request->City,
            'state' =>  $request->State,
            'pincode' =>  $request->PinCode,
            'phone_number'  =>  $request->PhoneNumber??null,
            'address'   =>  $request->Address??null,
        ]);
        Session::flash('message','Ifsc Code Updated Successfully');
        return redirect('/');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IfscCode  $ifscCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(IfscCode $ifscCode)
    {
        if($ifscCode->delete())
        {
            return response()->json('success');
        }else{
            return response()->json('fail');
        }

    }
}
