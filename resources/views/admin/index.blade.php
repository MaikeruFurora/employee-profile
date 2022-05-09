@extends('layout.app')
@section('content')
    <div class="row">
       <div class="col-lg-12 col-md-12 col-12">
        <div class="card" style="font-size: 12px">
            <div class="card-header bg-white">
                <div class="float-right">
                    <a href="{{ route('admin.create') }}" class="btn btn-primary btn-sm text-white"><i class="fas fa-user"></i> Create Employee</a>
                </div>
                <h5 class="">
                    <i class="fas fa-users"></i> Employee
                    <span class="badge badge-secondary">Total: <span class="badge badge-light">{{ $count }}</span></span>
                </h5>
            </div>
            <div class="card-body">
               {{-- <div class="table-responsive"> --}}
                <table id="datatable" class="table table-bordered table-striped" >
                    <thead>
                        <tr>
                            <th>Emp No.</th>
                            <th>Fullname</th>
                            <th>Sex</th>
                            <th>Age</th>
                            <th>Contact no.</th>
                            <th>Birthdate</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
               {{-- </div> --}}
            </div>
        </div>
       </div>
    </div>
@endsection
@section('js')
<script src="{{ asset('js/script.js') }}"></script>
@endsection