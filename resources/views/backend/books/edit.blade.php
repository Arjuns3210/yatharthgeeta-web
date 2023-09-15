<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Book Details : {{$books['name']}} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editBookForm" method="post" action="books/update?id={{$books['id']}}">
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
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" value="{{$books->sequence}}" ><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Book Category</label>
                                                        <select class="form-control mb-3" type="text" id="book_category_id" name="book_category_id">
                                                            @foreach($book_category as $book_category)
                                                                <option value="{{$book_category->id}}">{{$book_category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Number of Pages<span class="text-danger">*</span></label>
                                                        <input class="form-control integer-validation" type="number" id="pages" name="pages" value="{{$books->pages}}" ><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Audio Url<span class="text-danger">*</span></label>
                                                        <?php $output = implode(',', json_decode($books['audio_id'])); ?>
                                                        <input class="form-control required" type="text" id="audio_id" name="audio_id" value="{{$output}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Video Url<span class="text-danger">*</span></label>
                                                        <?php $outputVideo = implode(',', json_decode($books['video_id'])); ?>
                                                        <input class="form-control required" type="text" id="video_id" name="video_id" value="{{$outputVideo}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Related Books Url<span class="text-danger">*</span></label>
                                                        <?php $outputBook = implode(',', json_decode($books['related_id'])); ?>
                                                        <input class="form-control required" type="text" id="related_id" name="related_id" value="{{$outputBook}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Guru</label>
                                                        <select class="form-control mb-3" type="text" id="artist_id" name="artist_id" value="{{$books->artist_id}}">
                                                        @foreach($artist as $artist)
                                                            <option value="{{$artist->id}}">{{$artist->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Language</label>
                                                        <select class="form-control mb-3" type="text" id="language_id" name="language_id" value="{{$books->language_id}}">
                                                        @foreach($language as $language)
                                                            <option value="{{$language->id}}">{{$language->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6 border-right">
                                                        <div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div">
                                                            <p class="font-weight-bold">BOOK PDF <span class="text-danger">*</span></p>
                                                            <div class="shadow bg-white rounded d-inline-block mb-2">
                                                                <div class="input-file">
                                                                    <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                        <input class="form-control mb-3" type="file" accept=".pdf" id="pdf_file_name" name="pdf_file_name" onchange="handleFileInputChange('pdf_file_name', 'pdf')">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2">
                                                                    <div class="d-flex mb-1  srt-file-div-{{$pdf_file->id}}">
                                                                        <input type="text"
                                                                                class="form-control input-sm bg-white document-border"
                                                                                value="{{ $pdf_file->name }}"
                                                                                readonly style="color: black !important;">
                                                                        <a href="{{ $pdf_file->getFullUrl() }}"
                                                                            class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                    class="fa ft-eye"></i></a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-danger delete-srt-pdf_file  px-2"
                                                                            data-url="{{ $pdf_file->getFullUrl() }}" data-id="{{ $pdf_file->id }}"><i
                                                                                    class="fa ft-trash"></i></a>
                                                                    </div>
                                                                    <p style="color:blue;">Note : Upload {{config('global.dimensions.pdf')}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div">
                                                            <p class="font-weight-bold">BOOK EPUB FILE</p>
                                                            <div class="shadow bg-white rounded d-inline-block mb-2">
                                                                <div class="input-file">
                                                                    <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                        <input class="form-control mb-3" type="file" id="epub_file_name" name="epub_file_name" onchange="handleFileInputChange('epub_file_name', 'epub')">
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mt-2">
                                                                    <div class="d-flex mb-1  srt-file-div-{{$epub_file->id}}">
                                                                        <input type="text"
                                                                                class="form-control input-sm bg-white document-border"
                                                                                value="{{ $epub_file->name }}"
                                                                                readonly style="color: black !important;">
                                                                        <a href="{{ $epub_file->getFullUrl() }}"
                                                                            class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                    class="fa ft-eye"></i></a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-danger delete-srt-epub_file  px-2"
                                                                            data-url="{{ $epub_file->getFullUrl() }}" data-id="{{ $epub_file->id }}"><i
                                                                                    class="fa ft-trash"></i></a>
                                                                    </div>
                                                                    <p style="color:blue;">Note : Upload {{config('global.dimensions.epub')}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                    <div class="col-sm-6 offset-sm-3 mt-3">
                                                    <div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div">
                                                        <p class="font-weight-bold">COVER IMAGE <span class="text-danger">*</span></p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                    <input class="form-control" accept=".jpg,.jpeg,.png" type="file" id="cover_image" name="cover_image" onchange="handleFileInputChange('cover_image')"><br/>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mb-1  epub-file-div-{{$media->id}}">
                                                        <input type="text"
                                                                class="form-control input-sm bg-white document-border"
                                                                value="{{ $media->name }}"
                                                                readonly style="color: black !important;">
                                                        <a href="{{ $media->getFullUrl() }}"
                                                            class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                    class="fa ft-eye"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-danger delete-media  px-2"
                                                            data-url="{{ $media->getFullUrl() }}" data-id="{{ $media->id }}"><i
                                                                    class="fa ft-trash"></i></a>
                                                    </div>
                                                    <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                </div>
                                            </div>

                                            <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                                <div id="<?php echo $translated_data_tabs ?>_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) {
                                                         ?>

                                                            <?php if($translated_block_fields_value == 'input') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>Book {{$translated_block_fields_key}}</label>
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" value="{{$books[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}">
                                                                </div>
                                                            <?php
                                                        } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{$translated_block_fields_key}}</label>
                                                                    <textarea class="translation_block form-control required" rows="5" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$books[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editBookForm','post')">Submit</button>
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
