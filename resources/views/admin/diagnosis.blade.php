@extends('layout.app')
@section('content')
    @include('admin.modal.createDiagnosis')
    <div class="row">
       <div class="col-lg-12 col-md-12 col-12">
        <div class="card">
            <div class="card-header bg-white">
                <div class="float-right">
                    <a href="{{ route('admin.index') }}" class="btn btn-dark btn-sm"><i class="fas fa-arrow-left"></i> Back</a>&nbsp;
                    <button class="btn btn-primary btn-sm btnNew"><i class="fas fa-folder-open"></i> New Diagnosis</button>
                </div>
                <h6><i class="fas fa-folder-open"></i> Record of <b>{{$employee->fullname}}</b></h6>
            </div>
            <div class="card-body">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-folder-open"></i> Record</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="far fa-images"></i> Previous Record (Images)</a>
                    </li>
                  </ul>
                  <div class="tab-content mt-4" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table id="datatable" class="table table-striped table-bordered mt-3" style="font-size: 12px">
                            <thead>
                                <tr>
                                    <th width="10%">Date</th>
                                    <th width="30%">Diagnosis</th>
                                    <th width="30%">Recommendation</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <form id="imageForm">@csrf
                            <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                  <input type="file" multiple name="image[]" class="custom-file-input" id="inputGroupFile02">
                                  <label class="custom-file-label" for="inputGroupFile02" aria-describedby="inputGroupFileAddon02">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                </div>
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </form>
                        <div class="row row-cols-1 row-cols-md-3" id="imageShow"></div>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
@endsection

@section('js')

    <script>
        "use strict"
        
        $(".alert-success").hide();
        $(".btnNew").on('click',function(){
            $('#diagnosisForm input[name="id"]').val("")
            $("#diagnosisForm")[0].reset()
            $("#staticBackdropLabel").text('New Diagnosis')
            $(".inputDate").show();
            $("#staticBackdrop").modal("show")
        })

        
    let id = `<?=$employee->id?>`;
    let datatTable = $("#datatable").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: `/employee/diagnosis/${id}/list`,
            dataType: "json",
            type: "POST",
            data: { _token: $('input[name="_token"]').val() }
        },
        columns: [
            { data: "created_at" },
            { data: "diagnos" },
            { data: "recommendation" },
          
            {
                data: null,
                render: function(data) {
                    return `
                    <button name="print" class="btn btn-secondary btn-sm" value="${data.id}"><i class="fas fa-print"></i> Print</button>
                    <button name="edit" class="btn btn-warning btn-sm pl-3 pr-3" value="${data.id}"><i class="fas fa-edit"></i> Edit</button>
                    `
                }
            },

        ]
    });

    
    $(document).on('click',"button[name='print']",function(){
            let myurl = `/employee/diagnosis/${$(this).val()}/print`
                 popupCenter({
                    url: myurl,
                    title: "Expenses",
                    w: 1400,
                    h: 800,
                });
        })

    $(document).on('click','button[name="edit"]',function(){
        $("#staticBackdropLabel").text('Edit Diagnosis')
        $("#diagnosisForm button[type='submit']").text("Update");
        $.ajax({
                url:`/employee/diagnosis/${$(this).val()}/edit`,
                type:'GET'
            }).done(function(data){
                
                $('#diagnosisForm input[name="id"]').val(data.id)
                $('textarea[name="diagnos"]').val(data.diagnos)
                $('textarea[name="recommendation"]').val(data.recommendation)
                $('input[name="employee_id"]').val(data.employee_id)
                $(".inputDate").hide();
                $("#staticBackdrop").modal("show")
            }) .fail(function (jqxHR, textStatus, errorThrown) {
                $("#diagnosisForm button[type='submit']").text("Update").attr("disabled", false);
            });
       })


    $('#diagnosisForm').on('submit',function(e){
            e.preventDefault()
            $.ajax({
                url:'/employee/diagnosis/store',
                type:'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                cache: false,
                beforeSend: function(){
                    $("#diagnosisForm button[type='submit']").html(` 
                    Saving... <div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>
                    `).attr("disabled", true);
                }
           }) .done(function (data) {
                datatTable.ajax.reload()
                let textMsg = $("#diagnosisForm input[name='id']").val()==''?'Successfully saved!':'Updated successfully!'
                $(".alert-success").show().text(textMsg).fadeOut(4000)
                $("#diagnosisForm button[type='submit']").text("Create").attr("disabled", false);
                $("#staticBackdrop").modal("hide")
                $("#diagnosisForm")[0].reset()
            })
            .fail(function (jqxHR, textStatus, errorThrown) {
                $("#diagnosisForm button[type='submit']").text("Create").attr("disabled", false);
            });
       })

    let computeAge = (data) => {
        let dayt = data.split("/")
        let formalDate = dayt[1] + '/' + dayt[0] + '/' + dayt[2]
        let dob = new Date(formalDate);
        //calculate month difference from current date in time  
        let month_diff = Date.now() - dob.getTime();

        //convert the calculated difference in date format  
        let age_dt = new Date(month_diff);

        //extract year from date      
        let year = age_dt.getUTCFullYear();

        //now calculate the age of the user  
        let age = Math.abs(year - 1970);

        return age + " years old";
    }
    let getImages = (id) =>{
     let htmls=``;
    $.ajax({
        url:`/employee/images/${id}/list`,
        type:'GET'
    }).done(function(data){
        data.forEach((element,i) => {
            htmls+=`<div class="col mb-4">
                        <div class="card">
                            <a href="<?=asset('img/${element.images}')?>" target="_blank">
                                <img src="<?=asset('img/${element.images}')?>" class="card-img-top" alt="...">
                            </a>
                        <div class="card-body p-0">
                            <button type="button" class="btn btn-danger btn-block btn-sm" name="delete" id="delete_${element.id}" value="${element.id}"><i class="far fa-trash-alt"></i> Delete</button>
                        </div>
                        </div>
                    </div>`;
        });
        $("#imageShow").html(htmls)
    }) .fail(function (jqxHR, textStatus, errorThrown) {
        $("#diagnosisForm button[type='submit']").text("Update").attr("disabled", false);
    });
 }

 getImages(id)

    $("#imageForm").on('submit',function(e){
    e.preventDefault()
    $.ajax({
        url:'/employee/images/store',
        type:'POST',
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function(){
            $("#imageForm button[type='submit']").html(` 
            Saving... <div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>
            `).attr("disabled", true);
        }
    }) .done(function (data) {
        $("#imageForm button[type='submit']").text("Create").attr("disabled", false);
        $("#staticBackdrop").modal("hide")
        $("#imageForm")[0].reset()
        getImages(id)
    }).fail(function (jqxHR, textStatus, errorThrown) {
        $("#imageForm button[type='submit']").text("Create").attr("disabled", false);
    });
 })


 $(document).on('click','button[name="delete"]',function(){
     let deletedId = $(this).val();
    $.ajax({
            url:`/employee/images/${$(this).val()}/delete`,
            type:'DELETE',
            data: { _token: $('input[name="_token"]').val() },
            beforeSend: function(){
            $("#delete_"+deletedId).html(` 
            Deleting... <div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only">Loading...</span> </div>
            `).attr("disabled", true);
        }
        }).done(function(data){
            getImages(id)
        }) .fail(function (jqxHR, textStatus, errorThrown) {
            alert(textStatus)
        });
    })
 
 

 </script>
@endsection