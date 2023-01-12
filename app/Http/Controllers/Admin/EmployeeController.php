<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Job;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'employees' => Employee::all()
        ];

       

        return view('admin.employees.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'departments' => Department::all(),
            'jobs' => Job::all()
        ];
        return view('admin.employees.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'job_id' => 'required',
            'join_date' => 'required',
            'department_id' => 'required',
            'salary' => 'required|numeric',
            'email' => 'required|email',
            'photo' => 'image|nullable',
        ]);
       
        // $employeeRole = Role::where('name', 'employee')->first();
        // $user->roles()->attach($employeeRole);
        $employeeDetails = [
            
            'first_name' => $request->first_name, 
            'last_name' => $request->last_name,
            'job_id' => $request->job_id,
            'phone_number' => $request->phone_number, 
            'hire_date' => $request->join_date,
            'department_id' => $request->department_id, 
            'salary' => $request->salary,
            'manager_id' => 1,
            'photo'  => 'user.png'
        ];


        //print_r($employeeDetails);exit;

         // Photo upload
         if ($request->hasFile('photo')) {
           // GET FILENAME
            $filename_ext = $request->file('photo')->getClientOriginalName();
            // GET FILENAME WITHOUT EXTENSION
            $filename = pathinfo($filename_ext, PATHINFO_FILENAME);
            // GET EXTENSION
            $ext = $request->file('photo')->getClientOriginalExtension();
            //FILNAME TO STORE
            $filename_store = $filename.'_'.time().'.'.$ext;

            $path = public_path('img/employee'.$filename_store);
            
            // UPLOAD IMAGE
            // add new file name
            // $image = $request->file('photo');
            // $image_resize = Image::make($image->getRealPath());              
            // $image_resize->resize(300, 300);
            // $image_resize->save($path);

        // $fileName = $request->file('photo')->getClientOriginalName();
        // $filePath = 'uploads/' . $fileName;

        $path = Storage::disk('s3')->put($filename_store, fopen($request->file('photo'),'r+'),'public');
        //$path = Storage::disk('s3')->url($path);

         //print_r($path);exit;

            $employeeDetails['photo'] = $filename_store;
        }

        
        Employee::create($employeeDetails);
        $request->session()->flash('success', 'Employee has been successfully saved');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($employee_id)
    {

        $employee = Employee::where('employee_id', $employee_id)->first();
       $data = [
            'departments' => Department::all(),
            'jobs' => Job::all(),
            'employee' => $employee
        ];
       
        return view('admin.employees.edit')->with($data,['employee' => $employee]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $employee_id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'job_id' => 'required',
            'join_date' => 'required',
            'department_id' => 'required',
            'salary' => 'required|numeric',
            'email' => 'required|email',
            'photo' => 'image|nullable',
        ]);
       
        
        $employee = Employee::where('employee_id',$employee_id)->first();

            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->email = $request->email;
            $employee->job_id = $request->job_id;
            $employee->phone_number = $request->phone_number;
            $employee->hire_date = $request->join_date;
            $employee->department_id = $request->department_id;
            $employee->salary = $request->salary;
            $employee->manager_id = 1;
            $employee->photo  = 'user.png';

        if ($request->hasFile('photo')) {
            // Deleting the old image
            if ($employee->photo != 'user.png') {
                $old_filepath = public_path('img/employee'.$employee->photo);
                if(file_exists($old_filepath)) {
                    unlink($old_filepath);
                }    
            }
            // GET FILENAME
            $filename_ext = $request->file('photo')->getClientOriginalName();
            // GET FILENAME WITHOUT EXTENSION
            $filename = pathinfo($filename_ext, PATHINFO_FILENAME);
            // GET EXTENSION
            $ext = $request->file('photo')->getClientOriginalExtension();
            //FILNAME TO STORE
            $filename_store = $filename.'_'.time().'.'.$ext;
            // UPLOAD IMAGE
            $path = public_path('img/employee'.$filename_store);
            
            // UPLOAD IMAGE
            // add new file name
            $image = $request->file('photo');
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(300, 300);
            $image_resize->save($path);
            $employee->photo = $filename_store;

        }
        $employee->save();
        $request->session()->flash('success', 'Your profile has been successfully updated!');
        return redirect()->route('admin.employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
