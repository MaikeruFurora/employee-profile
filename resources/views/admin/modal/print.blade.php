<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @csrf
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <title>Medical Diagnosis</title>
  </head>
  <body onload="window.print()">
      
    <!-- Begin page content -->
  <div class="container-fluid mt-3">
    <div class="row">
        <div class="col-md-10 offset-md-1 text-center ">
            <h5><img src="{{ asset('img/download.png') }}" width="6%">&nbsp;&nbsp;CAMARINES SUR ELECTRIC COOPERATIVE, INC</h5>
            <h5>(CASURECO III)</h5>
            <h6>San Isidro, Iriga City</h6>
            <small><em>Email Adddress: <u>casureco3c@yahoo.com</u> Web Site: <u>www.casureco.com</u></em></small><br>
            <small>02992382 (GM); 2995700 (FINANCE); 2995707 (ADMIN); 2992287 (MSD); 2992283 (COMED); 299565 (AUDIT); 2992382</small>
        </div>
      </div>
      @php
      $currentDate = date("d-m-Y");
      $age = date_diff(date_create(date('d-m-Y',strtotime($data->birthday))), date_create($currentDate));
      @endphp
      <div class="row">
        <div class="col-md-5 offset-md-1 ">
            <table class="mt-4" width="100%">
                <tr>
                    <td width="40%">NAME: </td>
                    <td width="60%" style="border-bottom:1px solid black">{{ $data->name }}</td>
                </tr>
                <tr>
                    <td width="40%">ADDRESS: </td>
                    <td width="60%" style="border-bottom:1px solid black">{{ $data->address }}</td>
                </tr>
                <tr>
                    <td width="40%">AGE: </td>
                    <td width="60%" style="border-bottom:1px solid black">{{ $age->format("%Y") }}</td>
                </tr>
                <tr>
                    <td width="40%">SEX: </td>
                    <td width="60%" style="border-bottom:1px solid black">{{ $data->sex }}</td>
                </tr>
                <tr>
                    <td width="40%">BIRTHDATE: </td>
                    <td width="60%" style="border-bottom:1px solid black">{{ $data->birthday }}</td>
                </tr>
            </table>
        </div>
      </div>
    
      <div class="row mt-5">
        <div class="col-md-10 offset-md-1 text-center ">
          <table class="table table-bordered">
              <thead>
                  <tr>
                      <th width="20%">DATE</th>
                      <th width="40%">DIAGNOSIS</th>
                      <th width="40%">RECOMMENDATION</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>
                          {{ $data->created_at->format('F m, Y') }}
                      </td>
                      <td>
                          @php
                              echo html_entity_decode($data->diagnos[0]['diagnos'])
                          @endphp
                      </td>
                      <td>
                        @php
                              echo html_entity_decode($data->diagnos[0]['recommendation'])
                          @endphp
                      </td>
                  </tr>
              </tbody>
          </table>
        </div>
      </div>
  </div>

  </body>
</html>