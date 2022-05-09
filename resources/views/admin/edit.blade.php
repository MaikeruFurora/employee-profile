@extends('layout.app')
@section('content')
    
    <div class="row">
       <div class="col-lg-12 col-md-12 col-12">
        @if (session()->has('msg'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('msg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        @endif
        <div class="card my-5" >
            <div class="card-header bg-white">
                <div class="float-right">
                    <a href="{{ route('admin.index') }}" class="btn btn-dark btn-sm">Back</a>
                </div>
                    <h5>Update employee</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.store') }}">@csrf
                  <input type="hidden" name="id" value="{{ $employee->id }}">
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputEmail4">First name</label>
                      <input type="text" class="form-control" id="inputEmail4" name="first_name" value="{{ $employee->first_name }}" required>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputEmail4">Middle name</label>
                      <input type="text" class="form-control" id="inputEmail4" name="middle_name" value="{{ $employee->middle_name }}">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputEmail4">Last name</label>
                      <input type="text" class="form-control" id="inputEmail4" name="last_name" value="{{ $employee->last_name }}" required>
                    </div>
                  </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputEmail4">Employee ID NO.</label>
                        <input type="text" class="form-control" id="inputEmail4" name="id_no" value="{{ $employee->id_no }}" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputPassword4">Birthdate</label>
                        <input type="text" class="form-control" id="inputPassword4" name="birthdate" value="{{ $employee->birthday }}" required>
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputCity">Contact no.</label>
                          <input type="number" class="form-control" id="inputCity" name="contact_no" value="{{ $employee->contact_no }}">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputState">Sex</label>
                          <select id="inputState" class="form-control" name="sex" required>
                              <option {{ $employee->sex=='Male'?'selected':'' }} value="Male">Male</option>
                              <option {{ $employee->sex=='Female'?'selected':'' }} value="Female">Female</option>
                          </select>
                        </div>
                       
                      </div>
                    <div class="form-group">
                      <label for="inputAddress">Address</label>
                      <textarea id="my-textarea" class="form-control" name="address" rows="3" required>{{ $employee->address }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
            </div>
        </div>
       </div>
    </div>
@endsection

@section('js')
    <script>
        $(".alert").fadeOut(5000)
    </script>
@endsection