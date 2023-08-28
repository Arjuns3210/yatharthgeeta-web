<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">{{trans('labels.edit_staff')}} :  {{$data['data']->admin_name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="updateStaffData" method="post" action="staff_update">
                    			@csrf
                        		<div class="row">
                        			<div class="col-sm-6">
                        				<label>{{trans('labels.role')}}<span class="text-danger">*</span></label>                                       
                        				<select class="select2 required" id="role_id" name="role_id" style="width: 100% !important;">
                                            <option value="">Select</option>
                                            @foreach($data['roles'] as $roles)
                                                @if($roles->id == $data['data']->role_id)
                                                    <option value="{{$roles->id}}" selected>{{$roles->role_name}}</option>
                                                @else
                                                    <option value="{{$roles->id}}">{{$roles->role_name}}</option>
                                                @endif
                                            @endforeach
                                        </select><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>{{trans('labels.admin_name')}}<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="admin_name" name="admin_name" value="{{$data['data']->admin_name}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>{{trans('labels.nick_name')}}<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="nick_name" name="nick_name" value="{{$data['data']->nick_name}}"><br/>
                                    </div>
                                    <dl class="col-sm-6">
                                        <label>{{trans('labels.email_id')}}</label>
                                        <dd class="form-control" readonly>{{ $data['data']->email }}</dd>
                                    </dl>
                                    <div class="col-sm-6">
                                        <label>{{trans('labels.phone')}}<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="phone" name="phone" value="{{$data['data']->phone}}"><br/>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>{{trans('labels.address')}}<span class="text-danger">*</span></label>
                        				<textarea class="form-control required" id="address" name="address">{{$data['data']->address}}</textarea><br/>
                                        <input type="hidden" name="id" value="{{$data['data']->id}}">
                        			</div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('updateStaffData','post')">Update</button>
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
