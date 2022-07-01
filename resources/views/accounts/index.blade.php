{{-- @include('layouts.app') --}}

<!DOCTYPE html>
<html>
<head>
    <title>Yajra Datatable CRUD</title>

    {{-- meta tag for ajax csrf token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
    
<div class="container-fluid">

    {{-- models --}}
 
  <!-- Button to Open the Modal -->
  <div class="text-center">
  <button type="button" id="savedata" value="add" class="btn btn-primary"  data-target="#myModal">
   Save Data
  </button>
</div>

  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Creating new data</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form action="" method="get" id="form_id" class="d-none">
                Name : <input type="text" class="form-control" id="inputname" name="name">
                Enrollment No. : <input type="number" id="inputenrollno" class="form-control" name="enrollno">
                <input type="hidden" id="inputhidden">
            </form>
            
            {{-- For show --}}
            <div class="d-none" id="details">
                <h5 class="name">Name</h5>
                <h5 class="enrollno">Enrollment</h5>
            </div>

        
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" id="submit" data-dismiss="modal">submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

        </div>
        
      </div>
    </div>
  </div>

  {{-- end modal --}}

    <table class="table table-bordered data-table" id="">
        <thead id="">
            <tr class="odd">
                {{-- <th>internal id</th> --}}
                {{-- <div id="sortable"> --}}
                {{-- <ul id="sortable"> --}}
                    <th>id</th>
                   <th>Name</th>
                   <th>Enrollment Number</th>
                   <th width="250px">Action</th>
                {{-- </ul> --}}
            {{-- </div> --}}
            </tr>
        </thead>
        <tbody>
            <tr>

            </tr>
        </tbody>
    </table>
</div>

   
</body>
   
<script type="text/javascript">
  $(function () {


// csrf token for ajax
$.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
           }
     });


    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('account.index') }}",
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id', class :'classid'},
            {data: 'name', name: 'name'},
            {data: 'enrollno', name: 'enrollno', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: true}
        ]
    });

    //save
    $('#savedata').on('click', function(){

        $('#inputhidden').val('');
        $('#form_id').trigger('reset');
        $('#form_id').removeClass('d-none');
        $('.modal-body').children('#details').addClass('d-none');
        $('.modal-title').text('Create new data');
        $('#myModal').modal('show');
    })

    //edit
    $('body').on('click','#edit' ,function(){

        $('#form_id').removeClass('d-none');
        $('.modal-body').children('#details').addClass('d-none');
        $('#myModal').modal('show');    
        $('.modal-title').text('Edit data');
        console.log($(this).val());
        var id= $(this).val();
        
            $.ajax({

                url : 'account/'+id+'/edit',
                type : 'GET',
                success : function(res){
                    $('#inputname').val(res.name);
                    $('#inputenrollno').val(res.enrollno);
                    $('#inputhidden').val(res.id);
                }
            })
            $('#form_id').trigger('reset');
  });

  //show
  $(document).on('click','#show' ,function(){
    $('#form_id').addClass('d-none');
    $('.modal-body').children('#details').removeClass('d-none');
    $('.modal-title').text('Details');
    console.log($(this).val());
    var id = $(this).val();
    $.ajax({
        url : 'account/'+id,
        type : 'GET',
        success : function(res){
            $('.name').text(res.name);
            $('.enrollno').text(res.enrollno);
        }
    })
    $('#myModal').modal('show');
});


//delete

$(document).on('click', '#delete', function(){
    var id = $(this).val();
    $.ajax({
        url : 'account/'+id,
        type : 'DELETE',
        success: function(res){
            table.draw();
        }
    })
})

//submit

$('#submit').on('click', function(){
    console.log($('#inputhidden').val())
    var editid = $('#inputhidden').val();
    if(editid == ''){
    $.ajax({
        url : 'account',
        type : 'POST',
        data : $('#form_id').serialize(),
        success : function(res){
          
            table.draw();

        }
    })
    }
   else{
    $.ajax({
        url : 'account/'+editid,
        data : $('#form_id').serialize(),
        type : 'PATCH',
        success : function(res){
            table.draw();
        }
    })
   }
})
    })
</script>
</html>