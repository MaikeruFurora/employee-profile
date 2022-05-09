<form id="diagnosisForm">@csrf
<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
            <div class="modal-body">
                
                <input type="hidden" name="id">
                <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Diagnosis</label>
                           <textarea id="my-textarea" class="form-control" name="diagnos" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Recommendation</label>
                           <textarea id="my-textarea" class="form-control" name="recommendation" rows="5"></textarea>
                    </div>
                    <div class="input-group inputDate">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" value="{{ date('F j, Y') }}" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>
</form>