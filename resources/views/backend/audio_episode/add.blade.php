<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Episode :  {{ $audioTitle->title ?? '' }} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="addAudioEpisodeForm" method="post" action="audio_episode/save">
                                <input type="hidden" name="audio_id" value="{{$audio->id ?? ''}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            @foreach (config('translatable.locales') as $translated_tabs)
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#{{ $translated_tabs }}_block_details">{{ config('translatable.locales_name')[$translated_tabs] ?? '' }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Duration (In Minute)<span style="color:#ff0000">*</span></label>
                                                        <input class="form-control required numeric-validation" type="number" id="duration" name="duration"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>sequence<span style="color:#ff0000">*</span></label>
                                                        <input class="form-control required integer-validation" type="number"    id="sequence" name="sequence"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Main Shlok<span class="text-danger">*</span></label>
                                                        <textarea class="form-control required" rows="10" name="main_shlok"></textarea>
                                                        <br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Explanation Shlok<span class="text-danger">*</span></label>
                                                        <textarea class="form-control required" rows="10" name="explanation_shlok"></textarea>
                                                        <br/>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-sm-6 border-right text-center file-input-div">
                                                        <p class="font-weight-bold">Audio File (MP3) <span class="text-danger">*</span></p>
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
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-sm-6 border-right text-center file-input-div">
                                                        <p class="font-weight-bold">SRT</p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
                                                                    <input type="file"  class="srt-file" id="srtFiles" accept=".srt" name="srt_file">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p id="files-area">
                                                            <span id="srtFilesLists">
                                                                <span id="srt-files-names"></span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                            @foreach (config('translatable.locales') as $translated_data_tabs)
                                                <div id="{{ $translated_data_tabs }}_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        @foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value)
                                                            <div class="col-md-6 mb-3">
                                                                @if ($translated_block_fields_value == 'input')
                                                                    <label>{{ str_replace('_',' ',$translated_block_fields_key) }}<span class="text-danger">*</span></label>
                                                                    <input class="translation_block form-control required {{(in_array($translated_block_fields_key,['chapter_number','verses_number']) ? 'integer-validation' : '')}}" type="{{(in_array($translated_block_fields_key,['chapter_number','verses_number']) ? 'number' : 'text')}}" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}">
                                                                @endif
                                                                @if ($translated_block_fields_value == 'textarea')
                                                                    <label>{{ $translated_block_fields_key }}<span class="text-danger">*</span></label>
                                                                    <textarea class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}"></textarea>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('addAudioEpisodeForm','post')">Submit</button>
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
        $(document).ready(function(){
            const audioFileData = new DataTransfer();

            function handleAudioFileAttachmentChange() {
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

            handleAudioFileAttachmentChange();

            const srtFileData = new DataTransfer();

            function handleSrtFileAttachmentChange() {
                const attachmentInput = document.getElementById('srtFiles');

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
                        // Display an error message or take appropriate action for multiple files
                        alert('Please upload only one document at a time.');
                        // Reset the input field to clear selected files
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
                    const input = document.getElementById('srtFiles');
                    input.value = ''; // This should clear the selected file(s) in the input field
                });
            }

            handleSrtFileAttachmentChange();
        });
    </script>
</section>
