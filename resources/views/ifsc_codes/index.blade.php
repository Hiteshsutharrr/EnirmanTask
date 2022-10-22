<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>IFSC Code</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>
<body>

<div class="container pt-5">
	<div class="col-lg-12 row">
		<div class="col-lg-6">
			<h4>IFSC Codes</h4>
		</div>
		<div class="col-lg-6 text-right">
			<a href="{{route('ifsc_codes.create')}}" class="btn btn-primary">Add IFSC Code</a>
		</div>
	</div>
	<div class="col-lg-12 pt-5">
		<table id="ifsc" class="table table-bordered">
			<thead>
				<tr>
					<th>Sr No</th>
					<th>IFSC Code</th>
					<th>Name</th>
					<th>City</th>
					<th>State</th>
					<th>Pin Code</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

@if(Session::has('message'))
	<script>toastr['success']("{{Session::get('message')}}")</script>
@endif

<script type="text/javascript">
	$('#ifsc').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
      	"url":"{{ route('ifsc_codes.datatable') }}",
      	"type":"POST",
      	"data":{"_token":"{{csrf_token()}}"}
      },
      columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          {data: 'ifsc_code', name: 'ifsc_code'},
          {data: 'name', name: 'name'},
          {data: 'city', name: 'city'},
          {data: 'state', name: 'state'},
          {data: 'pincode', name: 'pincode'},
          {data: 'phone_number', name: 'phone_number'},
          {data: 'address', name: 'address'},
          {data: 'action',name: 'action',orderable: true,searchable: true},
      ]
  });

  function destroy(id) 
  {
	  if (confirm("Are You Sure you want to delete this Ifsc Code")) 
	  {
		    var url = '{{ route("ifsc_codes.destroy", ":id") }}';
		    url = url.replace(':id', id);
		    $.ajax({
		      	url:url,
		      	type:"post",
		      	data:{"_token":"{{csrf_token()}}","_method": 'DELETE'},
		      	success:function(data)
		      	{
			        if (data=='success') 
			        {
			          toastr['success']("Ifsc Code Deleted Successfully");
			          $('#ifsc').DataTable().ajax.reload();
			        }
			        else
			        {
			          toastr['error']("something went wrong!");
		      	  	}
		      	}
		    })
	  }


}

</script>
</body>
</html>