<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Language :  {{$data->language_name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="updateLanguageData" method="post" action="language/update?id={{$data['id']}}">
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-6">
                                        <label>Language Name<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="language_name" name="language_name" value="{{$data->language_name}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Language Code<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="language_code" name="language_code" value="{{$data->language_code}}"><br/>
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('updateLanguageData','post')">Update</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
                        				</div>
                        			</div>
                        		</div>
                        	</form>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $('.select2').select2();
</script>
