@extends('layouts.app')
@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
@endpush
@section('content')
<?php
	if(isset($data->id) && $data->id != 0){
		$id 			= $data->id;
		$student_name 	= $data->student_name;
		$address 		= $data->address;
		$grade			= $data->grade;
		$photo			= $data->photo;
		$date_of_birth 	= date("m/d/Y", strtotime($data->date_of_birth));
		$country_id 	= $data->country_id;
		$city_id 		= $data->city_id;

	}else{
		$id 			= 0;
		$student_name 	= old('student_name');
		$address 		= old('address');
		$grade			= old('grade');
		$photo			= old('photo');
		$date_of_birth 	= old('date_of_birth');
		$country_id 	= old('country_id');
		$city_id		= old('country_id');
	}

	if($photo!= ''){
		$photo = asset('storage/studentsprofile/' . $photo);
	}else{
	    $photo = asset('img')."/image-placeholder.png";
	}
?>
<div class="col-md-12">
    @if(Session::has('success'))
        <p class="alert alert-info">{{ Session::get('success') }}</p>
    @endif

    @if(Session::has('error'))
        <p class="alert alert-danger">{{ Session::get('error') }}</p>
    @endif

	<div class="card">
		<div class="card-header">
			<h3 class="card-title">{{isset($id) && $id != 0 ? 'Edit' : 'Add'}} Student</h3>
		</div>
		<!-- /.card-header -->
		<div class="card-body">
			<div class="d-flex justify-content-center mb-15">
			</div>
			<form method="post" action="{{isset($id) && $id != 0 ? route('students.update',[$id]) : route('students.store')}}" id="student-form"  enctype="multipart/form-data" >
				@if($id != 0)
					{{ method_field('PUT') }}
				@endif
				<input type="hidden" name="_token" value="{{ csrf_token() }}" />
				<input type="hidden" name="edit_city_id" value="{{isset($city_id)?$city_id:'0'}}">
				<div class="card-body">
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="student_name">Student Name*</label>
							<input type="text" name="student_name" class="form-control" id="student_name" value="{{$student_name}}" placeholder="Enter Student Name">
						</div>
						<div class="col-md-6 form-group">
							<label for="grade">Grade(%)*</label>
							<input type="text" class="form-control" id="grade" name="grade" value="{{$grade}}" placeholder="Enter Grade">
						</div>

					</div>
					<div class="row">
						<div class="col-md-12 form-group">
							<label for="address">Address*</label>
							<textarea id="address" name="address" placeholder="Enter Address" class="form-control" rows="4" cols="50">{{$address}}</textarea>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="country_name">Country Name*</label>
							<select class="form-control" name="country_name" id="country_name" onchange="return getCityData()">
								<option value="">Select Country</option>
								<?php
								if(isset($countries) && count($countries) > 0){
									foreach ($countries as $key => $country) {
										if($country->id == $country_id){
											$select = 'selected';
										}else{
											$select = '';
										}
										echo "<option value=".$country->id." ".$select.">".$country->name."</option>";
									}
								}
								?>
							</select>
						</div>
						<div class="col-md-6 form-group">
							<label for="city_name">City Name*</label>
							<select class="form-control" name="city_name" id="city_name">
								<option value="">Select City</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 form-group">
							<label for="date_of_birth">Date Of Birth*</label>
							<input type="text" class="form-control datepicker" value="{{$date_of_birth}}" placeholder="MM/DD/YYYY" name="date_of_birth" id="date_of_birth">
						</div>
						<div class="col-md-6 form-group">
							<label for="pro_photo">Photo</label>
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="pro_photo" id="pro_photo">
								<input type="hidden" class="custom-file-input" value="{{(isset($data->photo) && $data->photo != '' ? $data->photo : '')}}" name="hiddenphoto" id="hiddenphoto">
								<label class="custom-file-label" for="pro_photo">Choose file</label>
							</div>
							<br></br>
							<img id="img_prview" src="{{$photo}}" alt="your image" height="100" width="100" />
						</div>
					</div>
		    </div>
		    <!-- /.card-body -->
		    <div class="card-footer">
		    	<button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		  </form>
		</div>
		<!-- /.card-body -->
	</div>
	<!-- /.card -->
</div>
@endsection
@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {

	var edit_id = '{{$id}}';
	var bod 	= '{{$date_of_birth}}';

	$('#date_of_birth').datetimepicker({
		format: 'L',
	});

	if(edit_id != 0){
		getCityData();
	}
	

	  $("#student-form").validate({
			rules: {
				student_name : {
					required: true,
					minlength: 3
				},
				grade: {
					required: true,
					number: true,
	        min: 0,
	        max: 100,
				},
				address: {
					required: true,
				},
				country_name: {
					required: true,
				},
				city_name: {
					required: true,
				},
				date_of_birth: {
					required : true
				},
				pro_photo: {
					extension: "jpg|jpeg|png"
				}
			}
		});

	  $("#pro_photo").change(function() {
	    readURL(this);
	  });

	});
	function getCityData(){
		$.ajax({
        type:'POST',
            url: "{{route('student.getcitydefault')}}",
            dataType:'json',
            data: {
              _token:'{{ csrf_token() }}',
              country_id: $('#country_name').find(":selected").val(),
              city_id 	: '{{$city_id}}'
             },
            beforeSend: function(){
            //
            },
            success:function(data){
              $('#city_name').html(data);
            },
            complete:function(data){
             //
            },
        });
	}
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      var ext = input.files[0].name.split('.').pop().toLowerCase();  //file
    	var basepath = "{{asset('img')}}";
      reader.onload = function(e) {
		    if(($.trim(ext) == 'jpg') || ($.trim(ext) == 'jpeg') || ($.trim(ext) == 'png')){
	        $('#img_prview').attr('src', e.target.result)
	      }else{
	        $('#img_prview').attr('src',basepath+'/image-placeholder.png');
	      }
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
</script>
@endpush
