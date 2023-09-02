<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Audio Category</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editAudioCategoryForm" method="post" action="audio/update?id={{$audio['id']}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            @foreach (config('translatable.locales') as $translated_tabs)
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#{{ $translated_tabs }}_block_details">{{ $translated_tabs }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <input type="hidden" name="id" value="{{ $audio['id'] }}">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Has Episodes<span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="has_episodes" name="has_episodes">
                                                            <option value="0" {{ ($audio['has_episodes'] == 0) ?'selected' : '' }}>No</option>
                                                            <option value="1" {{ ($audio['has_episodes'] == 1) ?'selected' : '' }}>Yes</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Cover Image</label>
                                                        <input class="form-control " type="file" accept=".jpg, .jpeg, .png" name="cover_image">
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Audio File (MP3)<span class="text-danger">*</span></label>
                                                        <input class="form-control " type="file" accept=".mp3, .wav"  name="audio_file">
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Srt for lyrics</label>
                                                        <input class="form-control " type="file" accept=".srt" name="srt_file">
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Language<span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="language_id" name="language_id">
                                                            @foreach(config('translatable.locales') as $language)
                                                                <option value="{{$language}}">{{$language}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>People Also Read<span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="people_also_read_ids" name="people_also_read_ids[]" multiple>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Duration<span style="color:#ff0000">*</span></label>
                                                        <input class="form-control required" type="text" id="duration" name="duration" value="{{$audio['sequence']}}">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Sequence<span style="color:#ff0000">*</span></label>
                                                        <input class="form-control required" type="text" id="sequence" name="sequence" value="{{$audio['sequence']}}">
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Author<span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="author_id" name="author_id">
                                                            <option value="">Select</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            @foreach (config('translatable.locales') as $translated_data_tabs)
                                                <div id="{{ $translated_data_tabs }}_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        @foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value)
                                                            <div class="col-md-6 mb-3">
                                                                @if ($translated_block_fields_value == 'input')
                                                                    <label>{{ $translated_block_fields_key }}</label>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editAudioCategoryForm','post')">Submit</button>
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
            $('#has_episodes').change(function() {
                if ($(this).val() == '1') {
                    $('.episodes-details-div').removeClass('d-none');
                } else {
                    $('.episodes-details-div').addClass('d-none');
                }
            });

            $('.add_episode_item').click(function () {
                var rowCount = $('.episodes-append-div .row').length - 1;
                $.ajax({
                    type: 'GET',
                    url: 'prepare_episode_item/'+rowCount,
                    success: function (data) {
                        // Append the data to the container
                        var $newElements = $(data);
                        $('.episodes-append-div').append($newElements);

                        // Initialize Select2 on the newly added elements
                        $newElements.find('.select2').select2();
                    },
                });
            });
        });

        $(document).on('click', '.remove_episode_item', function () {
            $(this).closest('.episode-master-div').remove();
        });
    </script>
</section>
