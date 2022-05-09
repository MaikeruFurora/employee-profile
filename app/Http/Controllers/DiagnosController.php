<?php

namespace App\Http\Controllers;

use App\Models\Diagnos;
use App\Models\Employee;
use Illuminate\Http\Request;

class DiagnosController extends Controller
{
    public function index(Employee $employee){
        return view('admin/diagnosis',compact('employee'));
    }

    public function list(Request $request,$id){
        $columns = array( 
            1 =>'created_at',
            0 =>'diagnos', 
            1 =>'recommendation',
            5 =>'id',
        );
        
        $totalData = Diagnos::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {          
            $posts = Diagnos::select('diagnos.id','diagnos.created_at','diagnos.recommendation','diagnos.diagnos')
            ->join('employees','diagnos.employee_id','employees.id')->where('employee_id',$id)->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();
         } else {
            $search = $request->input('search.value'); 

            $posts =  Diagnos::select('diagnos.id','diagnos.created_at','diagnos.recommendation','diagnos.diagnos')
            ->join('employees','diagnos.employee_id','employees.id')->where('employee_id',$id)->where('diagnos', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->latest()
                            ->get();

            $totalFiltered =Diagnos::select('diagnos.id','diagnos.created_at','diagnos.recommendation','diagnos.diagnos')
            ->join('employees','diagnos.employee_id','employees.id')->where('employee_id',$id)->where('diagnos', 'LIKE',"%{$search}%")
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy($order,$dir)
                                ->latest()
                                ->count();
        }

    $data = array();
    if(!empty($posts)) {
        foreach ($posts as $post) {

            $nestedData['created_at'] = $post->created_at->format('F j, Y');
        $nestedData['diagnos'] = $post->diagnos;
        $nestedData['recommendation'] = $post->recommendation;
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

    public function store(Request $request){
        return Diagnos::updateorcreate(['id'=>$request->id],[
            'employee_id'=>$request->employee_id,
            'diagnos'=>$request->diagnos,
            'recommendation'=>$request->recommendation
        ]);
    }

    public function edit(Diagnos $diagnos)
    {
        return response()->json($diagnos);
    }

    public function print(Diagnos $diagnos){
        $data = $diagnos->employee()->first();
        return view('admin/modal/print',compact('data'));
    }
}
