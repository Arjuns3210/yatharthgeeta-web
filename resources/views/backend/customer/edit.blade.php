<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit User Details: {{$data->name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="updateUserData" method="post" action="customer/update?id={{$data['id']}}">
                    			@csrf
                                <div class="row">
                                    <div class="col-sm-6 mb-2">
                                        <label>Login Allowed<span class="text-danger">*</span></label>
                                        <select class="form-control select2 required" id="login_allowed" name="login_allowed">
                                            <option value="1" <?php echo $data->login_allowed == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?php echo $data->login_allowed == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6 d-flex" style="margin-top:30px">
                                        <input type="checkbox" class="largerCheckbox" id="is_verified" name="is_verified" value="{{$data->is_verified}}" {{ $data->is_verified == 'Y' ? 'checked' :'' }}>
                                        <div class="ml-2">
                                            <label class="" for="is_verified">Is Verified ?</label>
                                        </div>
                                    </div>
								</div><br/>
                        		<div class="row">
									<div class="col-sm-6 mb-2">
                                        <label>Approval Status<span class="text-danger">*</span></label>
                                        <select class="form-control select2 required" id="approval_status" name="approval_status">
                                            <option value="pending" <?php echo $data->approval_status == 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="accepted" <?php echo $data->approval_status == 'accepted' ? 'selected' : '' ?>>Accepted</option>
                                            <option value="rejected" <?php echo $data->approval_status == 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Admin Remark<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="admin_remark" name="admin_remark" value="{{$data->admin_remark}}"><br/>
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('updateUserData','post')">Update</button>
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
    $('#is_head').click(function(){
        if( $(this).val()==1){
            $(this).val(0);
        }else{
            $(this).val(1)
        }
    });
</script>