<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

// use Faker\Provider\ru_RU\Company;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Employee::paginate(10);;
        $employees=Employee::with('company')->get();
        $companies=Company::with('employees')->get();
        // dd($company);
      
    
        return view('employees.index',compact('data','companies','employees'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies=Company::all();
        // dd($companies);
        return view('employees.create',compact('companies'));
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
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|string|email:filter|max:255',
            // 'company' => Rule::exists('companies.name'),
            'phone'=>'nullable',
        ]);
        // $image=$request->file('logo')->store('public/companylogo');
        // Company::create([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'website'=>$request->website,
        //     'logo'=>$image
        // ]);

        $employee=new Employee;
  
        $employee->fname=$request->fname;
        $employee->lname=$request->lname;
        $employee->email=$request->email;
        $employee->phone=$request->phone;
        $employee->company_id=$request->company;
        $employee->save(); 
     
        return redirect()->route('employees.index')
                        ->with('success','Employee created successfully.');
    }

 /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        return view('employees.show',compact('employee'));
    }
   /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies=Company::all();
        return view('employees.edit',compact('employee','companies'));
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
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|string|email:filter|max:255',
            // 'company' => Rule::exists('companies.name'),
            'phone'=>'nullable',
        ]);
        // $image=$request->file('logo')->store('public/companylogo');
        // Company::create([
        //     'name'=>$request->name,
        //     'email'=>$request->email,
        //     'website'=>$request->website,
        //     'logo'=>$image
        // ]);

        $employee=new Employee;
  
        $employee->fname=$request->fname;
        $employee->lname=$request->lname;
        $employee->email=$request->email;
        $employee->phone=$request->phone;
        $employee->company_id=$request->company;
        $employee->save(); 
     
        return redirect()->route('employees.index')
                        ->with('success','Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
    
        return redirect()->route('employees.index')
                        ->with('success','Employee deleted successfully');
    }
}
