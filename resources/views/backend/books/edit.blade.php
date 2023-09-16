<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Book Details : {{$book['name']}} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editBookForm" method="post" action="books/update?id={{$book['id']}}">
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
                                                        <input class="form-control required  integer-validation" type="number" id="sequence" name="sequence" value="{{$book->sequence}}" ><br/>
                                                    </div>
                                                    <!-- <div class="col-sm-6">
                                                        <label>Book Category</label>
                                                        <select class="form-control mb-3" type="text" id="book_category_id" name="book_category_id">
                                                            @foreach($book_category as $book_cat)
                                                                <option value="{{$book_cat->id}}"
                                                                    {{$book_cat->id ==$book['book_category_id'] ? 'selected' : ''}}>{{$book_cat->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div> -->
                                                    <div class="col-sm-6">
                                                        <label>Number of Pages<span class="text-danger">*</span></label>
                                                        <input class="form-control integer-validation" type="number" id="pages" name="pages" value="{{$book->pages}}" ><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Available Audio<span class="text-danger">*</span></label>
                                                        <select class="form-control required" type="text" id="audio_id" name="audio_id">
                                                            @foreach($audio as $audios)
                                                                <option value="{{$audios->id}}" {{$audios->id ==$book['audio_id'] ? 'selected' : ''}}>{{$audios->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-3 ">
                                                        <label>Available Video<span class="text-danger">*</span></label>
                                                            <select class="form-control required" type="text" id="video_id" name="video_id">
                                                                @foreach($video as $videos)
                                                                    <option value="{{$videos->id}}" {{$videos->id ==$book['video_id'] ? 'selected' : '' }}>{{$videos->title ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-3">
                                                        <label>People Also Read</label>
                                                        <select class="form-control select2" id="related_id" name="related_id[]" multiple>
                                                            @foreach($books as $related)
                                                            <option value="{{ $related->id }}" {{ in_array($related->id, $peopleAlsoReadIds) ? 'selected' : '' }}>
                                                                {{ $related->translations[0]->name}}
                                                            </option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Guru</label>
                                                        <select class="form-control " type="text" id="artist_id" name="artist_id">
                                                        @foreach($artist as $artist)
                                                            <option value="{{$artist->id}}" {{($artist->id ==$book['artist_id'] ) ? 'selected' : ''}}>{{$artist->translations[0]->name ?? ''}}</option>
                                                        @endforeach
                                                        </select><br>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>LANGUAGE</label>
                                                        <select class="form-control" type="text" id="language_id" name="language_id">
                                                        @foreach($language as $language)
                                                        <option value="{{$language->id}}" {{($language->id ==$book['language_id'] ) ? 'selected' : ''}}>{{$language->translations[0]->name ?? ''}}</option>
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
                                                            <p id="files-area">
                                                                <span id="audioFilesLists">
                                                                    <span id="audio-files-names"></span>
                                                                </span>
                                                            </p>
                                                            @if(!empty($epub_file))
                                                            <div class="mt-2">
                                                                <div class="d-flex mb-1  pdf_file-div-{{$pdf_file->id}}">
                                                                    <input type="text"
                                                                            class="form-control input-sm bg-white document-border"
                                                                            value="{{ $pdf_file->file_name }}"
                                                                            readonly style="color: black !important;">
                                                                    <a href="{{ $pdf_file->getFullUrl() }}"
                                                                        class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                class="fa ft-eye"></i></a>
                                                                    <a href="javascript:void(0)"
                                                                        class="btn btn-danger delete-pdf_file  px-2"
                                                                        data-url="{{ $pdf_file->getFullUrl() }}" data-id="{{ $pdf_file->id }}"><i
                                                                                class="fa ft-trash"></i></a>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <p style="color:blue;">Note : Upload {{config('global.dimensions.pdf')}}</p>
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
                                                            <p id="files-area">
                                                                <span id="srtFilesLists">
                                                                    <span id="srt-files-names"></span>
                                                                </span>
                                                            </p>
                                                            @if(!empty($epub_file))
                                                            <div class="mt-2">
                                                                    <div class="d-flex mb-1  epub_file-div-{{$epub_file->id ?? ''}}">
                                                                      
                                                                        <input type="text"
                                                                                class="form-control input-sm bg-white document-border"
                                                                                value="{{ $epub_file->file_name ?? '' }}"
                                                                                readonly style="color: black !important;">
                                                                        <a href="{{ $epub_file->getFullUrl() ?? '' }}"
                                                                            class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                    class="fa ft-eye"></i></a>
                                                                        <a href="javascript:void(0)"
                                                                            class="btn btn-danger delete-epub_file  px-2"
                                                                            data-url="{{ $epub_file->getFullUrl() ?? '' }}" data-id="{{ $epub_file->id ?? '' }}"><i
                                                                                    class="fa ft-trash"></i></a>
                                                                    </div>
                                                            </div>
                                                            @endif
                                                            <p style="color:blue;">Note : Upload {{config('global.dimensions.epub')}}</p>
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
                                                        <p id="files-area">
                                                            <span id="coverImagesLists">
                                                                <span id="cover-images-names"></span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="d-flex mb-1  media-div-{{$media->id}}">
                                                        <input type="text"
                                                                class="form-control input-sm bg-white document-border"
                                                                value="{{ $media->file_name }}"
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
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" value="{{$book[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}">
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
                                                                    <textarea class="translation_block form-control required" rows="5" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$book[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
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
    <script>
        $('.select2').select2();
        $(document).ready(function() {
            let hasEpisodeValue = $('#has_episodes').val();
            if (hasEpisodeValue == '1') {
                $('.file-input-div').addClass('d-none');
            } else {
                $('.file-input-div').removeClass('d-none');
            }
            $('#has_episodes').change(function() {
                if ($(this).val() == '1') {
                    $('.file-input-div').addClass('d-none');
                } else {
                    $('.file-input-div').removeClass('d-none');
                }
            });

            const coverImageData = new DataTransfer();

            function handleCoverImagesAttachmentChange() {
                const attachmentInput = document.getElementById('cover_image');

                attachmentInput.addEventListener('change', function (e) {
                    if (this.files.length === 1) {
                        const file = this.files[0];
                        const fileBloc = $('<span/>', { class: 'file-block' });
                        const fileName = $('<span/>', { class: 'name', text: file.name });

                        fileBloc.append('<span class="file-delete cover-image-delete"><span>+</span></span>').
                            append(fileName);

                        // Clear existing uploaded documents
                        $('#coverImagesLists > #cover-images-names').empty();

                        $('#coverImagesLists > #cover-images-names').append(fileBloc);
                        coverImageData.items.clear(); // Clear existing items
                        coverImageData.items.add(file);
                    } else {
                        this.value = '';
                        $('#coverImagesLists > #cover-images-names').empty();
                        coverImageData.items.clear();
                    }
                });

                $(document).on('click', 'span.cover-image-delete', function () {
                    // Clear UI
                    $('#coverImagesLists > #cover-images-names').empty();

                    // Clear DataTransfer object (coverImageData)
                    coverImageData.items.clear();

                    // Reset the input field to clear selected files
                    const input = document.getElementById('cover_image');
                    input.value = ''; // This should clear the selected file(s) in the input field
                });
            }

            handleCoverImagesAttachmentChange();

            const audioFileData = new DataTransfer();

            function handleAudioFileAttachmentChange() {
                const attachmentInput = document.getElementById('pdf_file_name');

                attachmentInput.addEventListener('change', function (e) {
                    if (this.files.length === 1) {
                        const file = this.files[0];
                        const fileBloc = $('<span/>', { class: 'file-block' });
                        const fileName = $('<span/>', { class: 'name', text: file.name });

                        fileBloc.append('<span class="file-delete audio-files-delete"><span>+</span></span>').
                            append(fileName);

                        // Clear existing uploaded documents
                        $('#audioFilesLists > #audio-files-names').empty();

                        $('#audioFilesLists > #audio-files-names').append(fileBloc);
                        audioFileData.items.clear(); // Clear existing items
                        audioFileData.items.add(file);
                    } else {
                        // Display an error message or take appropriate action for multiple files
                        alert('Please upload only one document at a time.');
                        // Reset the input field to clear selected files
                        this.value = '';
                        $('#audioFilesLists > #audio-files-names').empty();
                        audioFileData.items.clear();
                    }
                });

                $(document).on('click', 'span.audio-files-delete', function () {
                    // Clear UI
                    $('#audioFilesLists > #audio-files-names').empty();

                    // Clear DataTransfer object (audioFileData)
                    audioFileData.items.clear();

                    // Reset the input field to clear selected files
                    const input = document.getElementById('pdf_file_name');
                    input.value = ''; // This should clear the selected file(s) in the input field
                });
            }

            handleAudioFileAttachmentChange();

            const srtFileData = new DataTransfer();

            function handleSrtFileAttachmentChange() {
                const attachmentInput = document.getElementById('epub_file_name');

                attachmentInput.addEventListener('change', function (e) {
                    if (this.files.length === 1) {
                        const file = this.files[0];
                        const fileBloc = $('<span/>', { class: 'file-block' });
                        const fileName = $('<span/>', { class: 'name', text: file.name });

                        fileBloc.append('<span class="file-delete srt-files-delete"><span>+</span></span>').
                            append(fileName);

                        // Clear existing uploaded documents
                        $('#srtFilesLists > #srt-files-names').empty();

                        $('#srtFilesLists > #srt-files-names').append(fileBloc);
                        srtFileData.items.clear(); // Clear existing items
                        srtFileData.items.add(file);
                    } else {
                        this.value = '';
                        $('#srtFilesLists > #srt-files-names').empty();
                        srtFileData.items.clear();
                    }
                });

                $(document).on('click', 'span.srt-files-delete', function () {
                    // Clear UI
                    $('#srtFilesLists > #srt-files-names').empty();

                    // Clear DataTransfer object (audioFileData)
                    srtFileData.items.clear();

                    // Reset the input field to clear selected files
                    const input = document.getElementById('epub_file_name');
                    input.value = ''; // This should clear the selected file(s) in the input field
                });
            }

            handleSrtFileAttachmentChange();

            $('.delete-media').click(function () {
                let mediaId = $(this).attr('data-id');
                deleteDocuments(mediaId, '.media-div-');
            });

            $('.delete-epub_file').click(function () {
                let mediaId = $(this).attr('data-id');
                deleteDocuments(mediaId, '.epub_file-div-');
            });
            $('.delete-pdf_file').click(function () {
                let mediaId = $(this).attr('data-id');
                deleteDocuments(mediaId, '.pdf_file-div-');
            });
        });
    </script>
</section>
