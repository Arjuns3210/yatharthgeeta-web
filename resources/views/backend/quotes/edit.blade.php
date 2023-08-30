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
                                        <label>Quotes Text<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="text" name="text" value="{{$quotes->text}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Quote Image<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="file" id="image" name="image" value="{{$quotes->image}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Sequence<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="sequence" name="sequence" value="{{$quotes->sequence}}"><br/>
                                    </div>
									<div class="col-sm-6">
                                        <label>Quote Description<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="description" name="description" value="{{$quotes->description}}"><br/>
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