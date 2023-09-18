<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Pravachan : {{$audio['translations'][0]['title'] ?? ''}} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editPravachanCategoryForm" method="post" action="pravachan/update?id={{$audio['id']}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            @foreach (config('translatable.locales') as $translated_tabs)
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#{{ $translated_tabs }}_block_details">{{ config('translatable.locales_name')[$translated_tabs] }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <input type="hidden" name="id" value="{{ $audio['id'] }}">
                                                    <div class="col-md-6 mb-2">
                                                        <label>Duration (In Minute)<span style="color:#ff0000">*</span></label>
                                                        <input class="form-control required numeric-validation" type="number" id="duration" name="duration" value="{{$audio['duration']}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <label>Sequence<span style="color:#ff0000">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" value="{{$audio['sequence']}}">
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Media Language<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="language_id" name="language_id">
                                                            <option value="">Select</option>
                                                            @foreach($languages as $language)
                                                                <option value="{{$language->id}}" {{($language->id ==$audio['language_id'] ) ? 'selected' : ''}}>{{$language->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Speaker<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="author_id" name="author_id">
                                                            <option value="">Select</option>
                                                            @foreach($gurus as $speaker)
                                                                <option value="{{$speaker->id}}" {{($speaker->id ==$audio['author_id'] ) ? 'selected' : ''}}>{{$speaker->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-sm-6 border-right text-center">
                                                        <p class="font-weight-bold">Cover Image <span class="text-danger">*</span></p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i><input type="file" name="cover_image" class="cover-images" id="coverImages" accept=".jpg, .jpeg, .png">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p id="files-area">
                                                            <span id="coverImagesLists">
                                                                <span id="cover-images-names"></span>
                                                            </span>
                                                        </p>
                                                        <div class="mt-2">
                                                            @foreach($audioCoverImage as $image)
                                                                <div class="d-flex mb-1  cover-image-div-{{$image->id}}">
                                                                    <input type="text"
                                                                           class="form-control input-sm bg-white document-border"
                                                                           value="{{ $image->file_name }}"
                                                                           readonly style="color: black !important;">
                                                                    <a href="{{ $image->getFullUrl() }}"
                                                                       class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                class="fa ft-eye"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-sm-6  text-center file-input-div">
                                                        <p class="font-weight-bold">Pravachan File (MP3) <span class="text-danger">*</span></p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                    <input type="file"  name="audio_file"  class="audio-file" id="audioFiles" accept=".mp3, .wav">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p id="files-area">
                                                            <span id="audioFilesLists">
                                                                <span id="audio-files-names"></span>
                                                            </span>
                                                        </p>
                                                        <div class="mt-2">
                                                            @foreach($audioFile as $data)
                                                                <div class="d-flex mb-1  audio-file-div-{{$data->id}}">
                                                                    <input type="text"
                                                                           class="form-control input-sm bg-white document-border"
                                                                           value="{{ $data->file_name }}"
                                                                           readonly style="color: black !important;">
                                                                    <a href="{{ $data->getFullUrl() }}"
                                                                       class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                class="fa ft-eye"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach (config('translatable.locales') as $translated_data_tabs)
                                                <div id="{{ $translated_data_tabs }}_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        @foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value)
                                                            <div class="col-md-6 mb-3">
                                                                @if ($translated_block_fields_value == 'input')
                                                                    <label>{{($translated_block_fields_key == 'title' ? 'Pravachan ' :'')}}{{ $translated_block_fields_key }}<span class="text-danger">*</span></label>
                                                                    <input class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" value="{{ $audio[$translated_block_fields_key.'_'.$translated_data_tabs] ?? '' }}">
                                                                @elseif ($translated_block_fields_value == 'textarea')
                                                                    <label>{{ $translated_block_fields_key }}</label>
                                                                    <textarea class="translation_block form-control required" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}">{{ $audio[$translated_block_fields_key.'_'.$translated_data_tabs] ?? '' }}</textarea>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('editPravachanCategoryForm','post')">Submit</button>
                                            <a href="{{URL::previous()}}" class="btn btn-sm btn-danger px-3 py-1"> Cancel</a>
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

            const coverImageData = new DataTransfer();

            function handleCoverImagesAttachmentChange() {
                const attachmentInput = document.getElementById('coverImages');

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
                        // Display an error message or take appropriate action for multiple files
                        alert('Please upload only one document at a time.');
                        // Reset the input field to clear selected files
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
                    const input = document.getElementById('coverImages');
                    input.value = ''; // This should clear the selected file(s) in the input field
                });
            }

            handleCoverImagesAttachmentChange();

            const audioFileData = new DataTransfer();

            function handlePravachanFileAttachmentChange() {
                const attachmentInput = document.getElementById('audioFiles');

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
                    const input = document.getElementById('audioFiles');
                    input.value = ''; // This should clear the selected file(s) in the input field
                });
            }

            handlePravachanFileAttachmentChange();
            

            $('.delete-cover-image').click(function () {
                let mediaId = $(this).attr('data-id');
                deleteDocuments(mediaId, '.cover-image-div-');
            });

            $('.delete-audio-file').click(function () {
                let mediaId = $(this).attr('data-id');
                deleteDocuments(mediaId, '.audio-file-div-');
            });
        });
    </script>
</section>
