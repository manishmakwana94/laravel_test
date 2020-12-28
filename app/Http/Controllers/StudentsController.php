<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Students;
use App\Countries;
use App\Cities;
use DataTables;
use File;
use DB;


class StudentsController extends Controller
{

    public function getCityData(Request $request){
        $citydata   = Cities::where('country_id',$request->country_id)->get()->toArray();
        $city_id    = $request->city_id;
        $html = '';
        
        $html .= '<option value="">Select City</option>';

        foreach ($citydata as $key => $city) {
            if($city_id != 0){
                $select = 'selected';
            }else{
                $select = '';
            }
            $html .= '<option value="'.$city['id'].'" '.$select.'>'.$city['name'].'</option>';
        }

         return response()->json($html); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStudentList(Request $request)
    {
        if ($request->ajax()) {
            $students = Students::select('*');
            return DataTables::of($students)
            ->editColumn('date_of_birth', function ($students) {
                $date_of_birth = $students->date_of_birth;
                return date("d-m-Y", strtotime($date_of_birth));
                
           })
            ->addColumn('actions', function ($row) {
               
                $editicon = '<a href="' . route('student.editstudents', encrypt($row->id)) . '" class="btn btn-primary" >
                    <i class="far fa-edit" ></i>
                </a>';
                $deleteicon = '<a href="javascript:void(0);" class="btn btn-danger" onclick="deletestudents('.$row->id.')" data-id="' . $row->id . '"">
                    <i class="far fa-trash-alt"></i>
                </a>';
                return $action = $editicon."  ".$deleteicon;
            })
            ->rawColumns(['actions'])
            ->make();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('students/studentslist');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Countries::get();
        return view('students/add_edit_student')->with(['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student_name   = $request->student_name;
        $grade          = $request->grade;
        $address        = $request->address;
        $country_name   = $request->country_name;
        $city           = $request->city_name;
        $date_of_birth  = $request->date_of_birth;
        $pro_photo      = $request->pro_photo;

        $profile_img='';

        if($request->hasfile('pro_photo')) {
            $profile_img = "profile".time().'.'.request()->pro_photo->getClientOriginalExtension();
            $request->pro_photo->storeAs('Studentsprofile',$profile_img);
            $data['pro_photo'] = $profile_img;
        }


        Students::create([
            'student_name'  =>  $student_name,
            'address'       =>  $address,
            'grade'         =>  $grade,
            'photo'         =>  $profile_img,
            'date_of_birth' =>  date("Y-m-d", strtotime($date_of_birth)),
            'city_id'       =>  $city,
            'country_id'    =>  $country_name
        ]);
        return redirect()->route('student.studentslist')->with(['type'=>'success','icon'=>'success','message'=>'New Student Profile Created in Successfully.']);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $edit_id        = decrypt($id);

        $countries      = Countries::get();
        $student_data   = Students::where('id',$edit_id)->first();

        return view('students/add_edit_student')->with(['data' => $student_data ,'countries' => $countries]);
       
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
        //
        $edit_id        = $request->edit_id;
        $student_name   = $request->student_name;
        $grade          = $request->grade;
        $address        = $request->address;
        $country_name   = $request->country_name;
        $city           = $request->city_name;
        $date_of_birth  = $request->date_of_birth;
        $pro_photo      = $request->pro_photo;
        $old_pro_photo  = $request->hiddenphoto;
        $profile_img='';

        if($request->hasfile('pro_photo')) {
             // Delete old file
            Storage::delete('Studentsprofile/'.$product->image_path);

            $profile_img = "profile".time().'.'.request()->pro_photo->getClientOriginalExtension();
            $request->pro_photo->storeAs('Studentsprofile',$profile_img);
            $data['pro_photo'] = $profile_img;
        }

        if(isset($profile_img) && $profile_img != ''){
            $profile_img = $profile_img;
        }else{
            $profile_img = $request->hiddenphoto;
        }

        Students::where('id',$edit_id)->update([
            'student_name'  =>  $student_name,
            'address'       =>  $address,
            'grade'         =>  $grade,
            'photo'         =>  $profile_img,
            'date_of_birth' =>  date("Y-m-d", strtotime($date_of_birth)),
            'city_id'       =>  $city,
            'country_id'    =>  $country_name
        ]);

     
        return redirect()->route('student.studentslist')->with(['type'=>'success','icon'=>'success','message'=>'Successfully Update Student Profile.']);

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
