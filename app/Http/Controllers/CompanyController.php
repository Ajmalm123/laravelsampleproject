<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $data = Company::latest()->paginate(10);
        // dd($data);
        $data = Company::paginate(10);
        $companies=Company::all();
        return view('companies.index',compact('data','companies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
            'name' => 'required',
            'email' => 'required|string|email:filter|max:255',
            'website' => 'nullable|string|regex:/^(https?:\/\/)?([\da-zA-Z\.-]+)\.([a-zA-Z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'logo'=>'nullable',
        ]);
        // $image=$request->file('logo')->store('public/companylogo');
        // Company::create([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'website'=>$request->website,
        //     'logo'=>$image
        // ]);

        $company=new Company;
        $company->name=$request->name;
        $company->email=$request->email;
        $company->website=$request->website;
        if($request->hasFile('logo')){
            $file=$request->file('logo');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('companylogo',$filename);
            $company->logo=$filename;
        }
        $company->save();
     
        return redirect()->route('companies.index')
                        ->with('success','Company created successfully.');
    }

 /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        return view('companies.show',compact('company'));
    }
   /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('companies.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         $request->validate([
            'name' => 'required',
            'email' => 'required|string|email:filter|max:255',
            'website' => 'nullable|string|regex:/^(https?:\/\/)?([\da-zA-Z\.-]+)\.([a-zA-Z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'logo'=>'nullable',
        ]);
        // $image=$request->file('logo')->store('public/companylogo');
        // Company::create([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'website'=>$request->website,
        //     'logo'=>$image
        // ]);

        $company=new Company;
        $company->name=$request->name;
        $company->email=$request->email;
        $company->website=$request->website;
        if($request->hasFile('logo')){
            $file=$request->file('logo');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('companylogo/',$filename);
            $company->logo=$filename;
        }
        $company->save();
     
        return redirect()->route('companies.index')
                        ->with('success','Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->delete();
    
        return redirect()->route('companies.index')
                        ->with('success','Company deleted successfully');
    }
}
