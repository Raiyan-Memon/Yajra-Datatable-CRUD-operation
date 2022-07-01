$(function () {

    // alert('included');


    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('account.index') }}",
        columns: [
            // {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'id', name: 'id', class :'classid'},
            {data: 'name', name: 'name'},
            {data: 'enrollno', name: 'enrollno', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: true, class: 'edit'},
        ]
    });

    //save
    $('#savedata').on('click', function(){

        // alert('saved');

        $('#myModal').modal('show');



    })

    $('body').on('click','#edit' ,function(){

            alert('sdf');
  });

  $('body').on('click','#show' ,function(){

    alert('show');
    console.log($('#show').text());
});

   
    })