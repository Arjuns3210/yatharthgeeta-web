<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Quotes</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveQuotes" method="post" action="quotes/save">
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-6">
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="title" name="title"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Image<span class="text-danger">*</span></label>
                                        <input class="form-control required" accept=".jpg,.jpeg,.png" type="file" id="image" name="image" onchange="handleFileInputChange('image')"><br/>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>Sequence<span class="text-danger">*</span></label>
                        				<input class="form-control required" type="text" id="sequence" name="sequence" oninput="filterNonNumeric(this)"><br/>
                        			</div>
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveQuotes','post')">Submit</button>
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
