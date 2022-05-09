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
        $data = Employee::create([
            'name' => $request->name, 
            'sex' => $request->sex,
            'contact_no' => $request->contact_no,
            'birthday' => $request->birthdate,
            'address' => $request->address
        ]);

        if($data){
            return back()->with('msg',ucwords($data['name']).' was successfully added!');
        }
        
    }

    public function list(Request $request){
        $columns = array( 
            0 =>'name', 
            1 =>'sex',
            2 =>'contact_no',
            3 =>'birthday',
            4 =>'address',
            5 =>'id',
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

        $posts =  Employee::where('name', 'LIKE',"%{$search}%")
                        ->orWhere('address', 'LIKE',"%{$search}%")
                        ->orWhere('birthday', 'LIKE',"%{$search}%")
                        ->orWhere('sex', 'LIKE',"%{$search}%")
                        ->orWhere('contact_no', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->latest()
                        ->get();

        $totalFiltered =Employee::where('name', 'LIKE',"%{$search}%")
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

            $nestedData['name'] = $post->name;
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
