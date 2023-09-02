<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Quotes</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="updateQuoteData" method="post" action="quotes/update?id={{$quotes['id']}}">
                    			@csrf
                        		<div class="row">
                                                                      
                                    <div class="col-sm-6">
                                        <label>Sequence<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="sequence" name="sequence" value="{{$quotes->sequence}}" oninput="onlyNumericNegative(this)"><br/>
                                    </div>
									<div class="tab-pane fade in active show">
										<label>Shlok<span class="text-danger">*</span></label>
										<select class="form-control" id="shlok" name="shlok" value="{{$quotes->shlok}}">
											<option value="A">A</option>
											<option value="B">B</option>
										</select>
                                    </div> 
									<div class="col-sm-6">
                                        <label>Quote Image (200*200)<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="file" id="image" name="image" value="{{$quotes->image}}" accept=".jpg,.jpeg,.png" onchange="handleFileInputChange('image')"><br/>
                                    </div>
									<div class="tab-pane fade in active show">
										<label>Share Allowance<span class="text-danger">*</span></label>
										<select class="form-control" id="share_allowance" name="share_allowance" value="{{$quotes->share_allowance}}">
											<option value="yes">Yes</option>
											<option value="no">No</option>
										</select>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="col-sm-6">
                                            <img src="{{$media->getFullUrl()}}" width="200px" alt="">
                                        </div>
                                    </div>									
                        		</div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('updateQuoteData','post')">Update</button>
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
