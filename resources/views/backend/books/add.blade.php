<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Book</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="saveBook" method="post" action="books/save">
                    			@csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            <?php foreach (config('translatable.locales') as $translated_tabs) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#<?php echo $translated_tabs ?>_block_details">{{ config('translatable.locales_name')[$translated_tabs] }}</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Book Category</label>
                                                        <select class="form-control mb-3" type="text" id="book_category_id" name="book_category_id">
                                                            @foreach($book_category as $book_category)
                                                                <option value="{{$book_category->id}}">{{$book_category->name}}</option>
                                                            @endforeach
                                                            </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Number of Pages</label>
                                                        <input class="form-control" type="text" id="pages" name="pages" oninput="filterNonNumeric(this)"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Book Pdf<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="file" id="pdf_file_name" name="pdf_file_name"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>File Extension<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="epub_file_name" name="epub_file_name"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Audio Url<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="audio_id" name="audio_id"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Video Url<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="video_id" name="video_id"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Related Books<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="related_id" name="related_id"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Guru</label>
                                                        <select class="form-control mb-3" type="text" id="artist_id" name="artist_id">
                                                        @foreach($artist as $artist)
                                                            <option value="{{$artist->id}}">{{$artist->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Language</label>
                                                        <select class="form-control mb-3" type="text" id="language_id" name="language_id">
                                                        @foreach($language as $language)
                                                            <option value="{{$language->id}}">{{$language->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Cover Image<span class="text-danger">*</span></label>
                                                        <input class="form-control required" accept=".jpg,.jpeg,.png" type="file" id="cover_image" name="cover_image" onchange="handleFileInputChange('cover_image')"><br/>
                                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="sequence" name="sequence" oninput="onlyNumericNegative(this)"><br/>
                                                    </div>
                                                </div>

                                            </div>

                                            <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                                <div id="<?php echo $translated_data_tabs ?>_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'input') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>Book {{$translated_block_fields_key}}</label>
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{$translated_block_fields_key}}</label>
                                                                    <textarea class="translation_block form-control required" rows="5" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}"></textarea>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveBook','post')">Submit</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger"> Cancel</a>
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
