"use strict"

let datatableRule = $("#datatable").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/employee/list',
        dataType: "json",
        type: "POST",
        data: { _token: $('input[name="_token"]').val() }
    },
    columns: [
        { data: "id_no" },
        { data: "first_name" },
        { data: "sex" },
        {
            data: null,
            render: function(data) {
                return computeAge(data.birthday)
            }
        },
        { data: "contact_no" },
        { data: "birthday" },
        { data: "address" },
        {
            data: null,
            render: function(data) {
                return `
                 <a style="font-size:12px" class="btn btn-warning btn-sm pl-2 pr-2" href="employee/edit/${data.id}"><i class="fas fa-edit"></i> Edit</a>
                 <a style="font-size:12px" class="btn btn-secondary btn-sm"href="employee/diagnosis/${data.id}"><i class="fas fa-stethoscope"></i> Diagnosis</a>
                 `
            }
        },

    ]
});


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

    return age;
}