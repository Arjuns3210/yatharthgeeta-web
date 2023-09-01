<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Ashram : {{ $ashram->name}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="editAshram" method="post" action="ashram/update?id={{ $ashram->id}}">
                    			@csrf
                        		<div class="row">
                        			<div class="col-sm-6">
                        				<label>Name<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="name" name="name" value="{{ $ashram->name}}" oninput="validateNameInput(this)"><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="title" name="title" value="{{ $ashram->title}}" oninput="validateNameInput(this)"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Image<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" value="{{ $ashram->image}}" onchange="handleFileInputChange('image')"><br/>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>Description<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="description" name="description" value="{{ $ashram->description}}"><br/>
                        			</div>
                                    <div class="col-sm-6">
                                        <label>Email<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="email" name="email" value="{{ $ashram->email}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Contact<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="phone" name="phone" value="{{ $ashram->phone}}" oninput="filterNonNumeric(this)"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Location<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="location" name="location" value="{{ $ashram->location}}"><br/>
                                    </div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('editAshram','post')">Submit</button>
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