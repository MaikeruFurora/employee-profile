<?php

namespace App\Http\Controllers;

use App\Models\Diagnos;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(){
        $count = Employee::count();
        return view('admin/index',compact('count'));
    }

    public function create(){
        return view('admin/create');
    }

    public function edit(Employee $employee){
        return view('admin/edit',compact('employee'));
    }

   


    public function store(Request $request){

        $count = Employee::where('id_no',$request->id_no)->where('first_name',$request->first_name)->count();
        if ($count>0) {
            $data = Employee::updateorcreate(['id'=>$request->id],[
                'first_name' => $request->first_name, 
                'middle_name' => $request->middle_name, 
                'last_name' => $request->last_name, 
                'id_no' => $request->id_no, 
                'sex' => $request->sex,
                'contact_no' => $request->contact_no,
                'birthday' => $request->birthdate,
                'address' => $request->address
            ]);
            if($data){
                return back()->with('msg',ucwords($data['name']).' was successfully Saved!');
            }
        }else{
            return back()->with('msg',strtoupper($request->first_name).' IS ALREADY EXIST!');
        }

        
    }

    public function list(Request $request){
        $columns = array( 
            0 =>'id_no', 
            1 =>'first_name', 
            2 =>'sex',
            3 =>'contact_no',
            4 =>'birthday',
            5 =>'address',
            6 =>'id',
        );
        
        $totalData = Employee::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
        $posts = Employee::offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->latest()
                        ->get();
        }
        else {
        $search = $request->input('search.value'); 

        $posts =  Employee::where('first_name', 'LIKE',"%{$search}%")
                        ->orWhere('middle_name', 'LIKE',"%{$search}%")
                        ->orWhere('id_no', 'LIKE',"%{$search}%")
                        ->orWhere('last_name', 'LIKE',"%{$search}%")
                        ->orWhere('address', 'LIKE',"%{$search}%")
                        ->orWhere('birthday', 'LIKE',"%{$search}%")
                        ->orWhere('sex', 'LIKE',"%{$search}%")
                        ->orWhere('contact_no', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->latest()
                        ->get();

        $totalFiltered =Employee::where('first_name', 'LIKE',"%{$search}%")
                            ->orWhere('id_no', 'LIKE',"%{$search}%")
                            ->orWhere('middle_name', 'LIKE',"%{$search}%")
                            ->orWhere('last_name', 'LIKE',"%{$search}%")
                            ->orWhere('birthday', 'LIKE',"%{$search}%")
                            ->orWhere('address', 'LIKE',"%{$search}%")
                            ->orWhere('sex', 'LIKE',"%{$search}%")
                            ->orWhere('contact_no', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->count();
        }

        $data = array();
        if(!empty($posts)) {
            foreach ($posts as $post) {

                $nestedData['id_no'] = $post->id_no;
            $nestedData['first_name'] = $post->first_name.' '.$post->middle_name.' '.$post->last_name;
            $nestedData['sex'] = $post->sex;
            $nestedData['contact_no'] = $post->contact_no;
            $nestedData['birthday'] = $post->birthday;
            $nestedData['address'] = $post->address;
            $nestedData['id'] = $post->id;
            $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        echo json_encode($json_data); 
}

   
}
