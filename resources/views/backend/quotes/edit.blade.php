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
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="title" name="title" value="{{$quotes->title ?? ''}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Sequence<span class="text-danger">*</span></label>
                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" value="{{$quotes->sequence}}"><br/>
                                    </div>
									<div class="col-sm-6">
                                        <label>Image</label>
                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" onchange="handleFileInputChange('image')"><br/>
                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                        @if(isset($media))
                                        <div class="main-del-section" style="position: relative; border: 1px solid #999; border-radius: 5px; padding: 5px; margin-right: 10px; display: inline-block;">
                                            <img src="{{$media->getFullUrl() ?? ''}}" width="100px" height="auto">
                                            <span class="delimg bg-danger text-center" id="{{$quotes['id']}}" data-url="quotes/delete_img?id={{$quotes['id']}}" style="padding: 0 5px; position: absolute; top: -8px; right: -8px; border-radius: 50%; cursor: pointer;"><i class="fa fa-times text-light"></i></span>
                                        </div>
                                        @endif
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
