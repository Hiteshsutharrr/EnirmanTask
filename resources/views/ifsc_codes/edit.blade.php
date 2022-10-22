<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>IFSC Code</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

<div class="container pt-5">
	<div class="col-lg-12 row">
		<div class="col-lg-6">
			<h4>IFSC Codes - Modify</h4>
		</div>
	</div>
	<div class="col-lg-12 pt-5">

		<form method="POST" action="{{route('ifsc_codes.update',$IfscCode->id)}}">
			@csrf
			@method('PUT')

		  <div class="col-lg-12 row">

			  <div class="form-group col-lg-6">
			    <label>IFSC Code</label>
			    <input type="text" class="form-control " name="Ifsc_Code" id="Ifsc_Code" placeholder="Please Enter IFSC Code" value="{{$IfscCode->ifsc_code}}" oninput="this.value = this.value.toUpperCase()">
			    @error('Ifsc_Code')<span id="Ifsc_Code-error" class="error help-block" style="color:red;">{{$message}}</span>@enderror
			  </div>

			  <div class="form-group col-lg-6">
			    <label>Name</label>
			    <input type="text" class="form-control required" name="Name" id="Name" placeholder="Please Enter Bank Name" value="{{$IfscCode->name}}">
			    @error('Name')<span id="Name-error" class="error help-block" style="color:red;">{{$message}}</span>@enderror
			  </div>

			</div>
			

			<div class="col-lg-12 row">

			  <div class="form-group col-lg-4">
			    <label>PinCode</label>
			    <input type="text" class="form-control required" name="PinCode" id="PinCode" placeholder="Please Enter PinCode" onkeyup="getPinCodeData(this.value)" value="{{$IfscCode->pincode}}">
			    @error('PinCode')<span id="PinCode-error" class="error help-block" style="color:red;">{{$message}}</span>@enderror
			  </div>

			  <div class="form-group col-lg-4">
			    <label>City</label>
			    <input type="text" class="form-control" name="City" id="City"  readonly value="{{$IfscCode->city}}">
			    @error('City')<span id="City-error" class="error help-block" style="color:red;">{{$message}}</span>@enderror
			  </div>

			  <div class="form-group col-lg-4">
			    <label>State</label>
			    <input type="text" class="form-control" name="State" id="State"  readonly value="{{$IfscCode->state}}">
			    @error('State')<span id="State-error" class="error help-block" style="color:red;">{{$message}}</span>@enderror
			  </div>

			</div>

			<div class="col-lg-12 row">

			  <div class="form-group col-lg-3">
			    <label>Phone Number</label>
			    <input type="number" min="0" maxlength="10" minlength="10" onkeypress="if(this.value.length == 10)return false;" class="form-control" name="PhoneNumber" id="PhoneNumber"  placeholder="Phone Number (optional)" value="{{$IfscCode->phone_number}}">
			    @error('PhoneNumber')<span id="PhoneNumber-error" class="help-block" style="color:red;">{{$message}}</span>@enderror
			  </div>

			  <div class="form-group col-lg-9">
			    <label>Address</label>
			    <input type="text" class="form-control" name="Address" id="Address"  placeholder="Address (optional)" value="{{$IfscCode->address}}">
			  </div>

			</div>

			<div class="col-lg-12 ">
			  <button type="submit" class="btn btn-success">Update</button>
			  <a href="{{route('ifsc_codes.index')}}" class="btn btn-danger">Cancel</a>
			</div>
			

		</form>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">


	function getPinCodeData(pincode)
	{

		// url = 'https://pos.ibai.org/get-city-state/'+pincode;   ////   it's not working.
		
		url = 'https://api.postalpincode.in/pincode/'+pincode;

		if(pincode.length == 6)
		{
			$.get(url,function(date,status){

				$('#City').val(date[0].PostOffice != null ? date[0].PostOffice[0]['District'] : "");
				$('#State').val(date[0].PostOffice != null ? date[0].PostOffice[0]['State'] : "");
			
			})
		}
		else
		{
			$('#City, #State').val('');
		}

	}

	$('#Ifsc_Code').on('keyup',function(){

		$.ajax({
			url:"{{route('check_ifsc')}}",
			method:"POST",
			data:{
				_token:"{{csrf_token()}}",
				ifsc_code:$('#Ifsc_Code').val(),
				id:"{{$IfscCode->id}}",
			},
			async:false,
			success:function(response)
			{
				if(response > 0)
				{
					error = "This Ifsc Code Is already registered";
					if($('#Ifsc_Code-error').exists())
					{
						$('#Ifsc_Code-error').html(error).show();
					}
					else
					{
						element = '<spam id="Ifsc_Code-error" class="error help-block" style="color:red;">'+error+'</span>';
						$('#Ifsc_Code').parent('div').append(element);
					}
				}
				else
				{
					$('#Ifsc_Code-error').hide();
				}
			}
		});

	})

	$('form').on('submit',function(){
		is_error =  false;
		required(['Ifsc_Code','Name','PinCode']);

		$('#Ifsc_Code').trigger('keyup');

		if($('.error').is(':visible'))
		{
			is_error =  true;
		}
		if($('#PinCode').val() != '')
		{
			if($('#City').val() == '' || $('#State').val() == '' )
			{	
				error = 'Please Enter Valid Pincode';
				if($('#PinCode-error').exists())
				{
					$('#PinCode-error').html(error).show();
				}
				else
				{
					element = '<spam id="PinCode-error" class="error help-block" style="color:red;">'+error+'</span>';
					$('#PinCode').parent('div').append(element);
				}
				is_error =  true;
			}
		}

		if(is_error == true)
		{
			return false;
		}

	})

	$('.required').on('keyup',function(){
		if(this.value != '')
		{
			$('#'+this.id+'-error').hide();
		}else{
			$('#'+this.id+'-error').show();
		}
	})

	function required(element_ids)
	{
		$.each(element_ids,function(i,v){
			if($('#'+v).val() == '')
			{
				error = 'This Field Is Required';
				if($('#'+v+'-error').exists())
				{
					$('#'+v+'-error').html(error).show();
				}else{
					element = '<spam id="'+v+'-error" class="error help-block" style="color:red;">'+error+'</span>';
					$('#'+v).parent('div').append(element);
				}
			}
		})
	}

	jQuery.fn.exists = function(){return this.length>0;}
</script>
</body>
</html>