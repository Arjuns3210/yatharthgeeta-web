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
                                                        <label>SEQUENCE<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Book Category<span class="text-danger">*</span></label>
                                                        <select class="form-control mb-3" type="text" id="book_category_id" name="book_category_id">
                                                            @foreach($book_category as $book_category)
                                                                <option value="{{$book_category->id}}">{{$book_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Number of Pages<span class="text-danger">*</span></label>
                                                        <input class="form-control integer-validation" type="number" id="pages" name="pages"><br/>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Video<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required " id="related_id" name="related_id[]">
                                                        @foreach($video as $video)
                                                                <option value="{{$video->id}}">{{$video->translations[0]->title ?? ''}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Audio<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="related_id" name="related_id[]">
                                                        @foreach($audio as $audio)
                                                                <option value="{{$audio->id}}">{{$audio->translations[0]->title ?? ''}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>People Also Read</label>
                                                        <select class="form-control select2 " id="related_id" name="related_id[]">
                                                        @foreach($books as $book)
                                                                <option value="{{$book->id}}">{{$book->translations[0]->name ?? ''}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-3">
                                                        <label>GURU</label>
                                                        <select class="form-control" type="text" id="artist_id" name="artist_id">
                                                        @foreach($artist as $artist)
                                                            <option value="{{$artist->id}}">{{$artist->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>LANGUAGE</label>
                                                        <select class="form-control" type="text" id="language_id" name="language_id">
                                                        @foreach($language as $language)
                                                            <option value="{{$language->id}}">{{$language->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6 border-right">
                                                        <div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div mb-3">
                                                            <p class="font-weight">BOOK PDF<span class="text-danger">*</span></p>
                                                            <p style="color:blue;">Note : Upload {{config('global.dimensions.pdf')}}</p>
                                                            <div class="shadow bg-white rounded d-inline-block mb-2">
                                                                <div class="input-file">
                                                                    <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                        <input class="form-control required" type="file" accept=".pdf" id="pdf_file_name" name="pdf_file_name"  onchange="handleFileInputChange('pdf_file_name', 'pdf')">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div mb-3">
                                                            <p class="font-weight">BOOK EPUB FILE</p>
                                                            <p style="color:blue;">Note : Upload {{config('global.dimensions.epub')}}</p>
                                                            <div class="shadow bg-white rounded d-inline-block mb-2">
                                                                <div class="input-file">
                                                                    <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                        <input class="form-control mb-3" type="file" id="epub_file_name" name="epub_file_name" onchange="handleFileInputChange('epub_file_name', 'epub')"><br/>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6 offset-sm-3">
                                                        <div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div mb-3">
                                                            <p class="font-weight-bold">Cover Image</p>
                                                            <div class="shadow bg-white rounded d-inline-block mb-2">
                                                                <div class="input-file">
                                                                    <label class="label-input-file">Choose Files &nbsp;&nbsp;&nbsp;<i class="ft-upload font-medium-1"></i><input type="file" name="cover_image" class="cover-images" id="cover_image" accept=".jpg, .jpeg, .png">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <p id="files-area">
                                                                <span id="coverImagesLists">
                                                                    <span id="cover-images-names"></span>
                                                                </span>
                                                            </p>
                                                            <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                        </div>
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
                                                                    <label>{{ str_replace('_',' ',$translated_block_fields_key)}}</label>
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
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            $('#has_episodes').change(function() {
                if ($(this).val() == '1') {
                    $('.file-label').text('');
                    $('.file-input').removeClass('required');
                    $('.file-input-div').addClass('d-none');
                } else {
                    $('.file-label').text('*');
                    $('.file-input').addClass('required');
                    $('.file-input-div').removeClass('d-none');
                }
            });
    </script>
</section>
