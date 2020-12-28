@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Students List</h3>
        <div class="card-tools">
         
          <a href="{{route('student.createstudent')}}" class="btn btn-primary" tag="button">Add New <i class="fa fa-image" aria-hidden="true"></i></a>
        </div>
      </div>
      <!-- /.card-header -->
    <div class="card-body">
    <div class="d-flex justify-content-center mb-15">
    </div>
    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4 table-responsive">
        <table id="student_list" class="display Main-Table-View table table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>Id</th>
                <th>Student Name</th>
                <th>Grade</th>
                <th>Date Of Birth</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
  </div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
</div>

@endsection



@if(session()->has('message'))
  <script type="text/javascript">
    Toast.fire({
      icon: "{{ session()->get('icon') }}",
      //type: "{{ session()->get('type') }}",
      title: "{{ session()->get('message') }}",
    });
  </script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script type="text/javascript">
  $(document).ready(function () {
    initStudentsTable();  
  });
  function initStudentsTable() {
    if($(document).find('#student_list').length > 0) {
      var student_list_tbl = $('#student_list').DataTable({
        dom: 'lBfrtip',
        "destroy"   : true,
        "processing": true,
        "serverSide": true,
        "searching": true,
        "pageLength": 10,
        "order": [[ 0, "desc" ]],
        buttons: [

        ],
       
      "ajax":{
              "url"     : "{{ route('student.getstudentlist')}}",
              "dataType": "json",
              "type"    : "GET",
              "data"    :{ _token: "{{csrf_token()}}"}
          },
        "columns": [
            { "data": "id" },
            { "data": "student_name" },
            { "data": "grade" },
            { "data": "date_of_birth" },                
            { "data": "actions" }
        ],
        columnDefs : [
          { targets: 0, visible: false, searchable: false },
          { targets: 4, orderable : false, className: "text-center", width: "25%" },
        ],
        responsive:true
      });
    }  
  }

  function deleteNews(id)
  {
    Swal.fire({
      text: "are You sure whant to delete?",
      icon: 'warning',
      showCancelButton: true,
      cancelButtonText: 'Cancel',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.value) {
        //send request to server
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:'POST',
            url: "{{route('student.studentdelete')}}",
            dataType:'json',
            data: {
              _token:'{{ csrf_token() }}', 
              id:id
             },
            beforeSend: function(){
            //
            },
            success:function(data){
              Swal.fire(
                data['title'],
                data['message'],
                data['type']
              )
              $('#student_list').DataTable().ajax.reload();
            },
            complete:function(data){
             //
            },
        });
      }
    })
  }

</script>
