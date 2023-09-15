<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Home Collection</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="addHomeCollection" method="post" action="home_collection/save" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
{{--                                        <ul class="nav nav-tabs">--}}
{{--                                            <li class="nav-item">--}}
{{--                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>--}}
{{--                                            </li>--}}
{{--                                        </ul>--}}
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Collection Type<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="collection_type" name="collection_type">
                                                            @foreach($collection_types as $key => $type)
                                                                <option value="{{$key}}">{{\App\Models\HomeCollection::COLLECTION_TYPES[$key]}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Language<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="language_id" name="language_id">
                                                            <option value="">Select</option>
                                                            @foreach($languages as $language)
                                                                <option value="{{$language->id}}">{{$language->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Collection Title<span class="text-danger">*</span></label>
                                                        <textarea class="ckeditor form-control required" id="" rows="13" name="title"></textarea>
                                                        <br/>
                                                    </div>
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Short Description</label>
                                                            <input class="form-control" type="text" id="description" name="description"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Sequence<span class="text-danger">*</span></label>
                                                            <input class="form-control required integer-validation" type="number" id="sequence" name="sequence"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Display in columns<span class="text-danger">*</span></label>
                                                            <input class="form-control required" type="text" id="display_in_column" name="display_in_column" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0 mt-2">
                                                            <div class="custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="is_scrollable" name="is_scrollable">
                                                                <label class="custom-control-label" for="is_scrollable">Is Scrollable</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="row div_multiple">
                                                    <div class="col-md-12 ">
                                                        <fieldset class="scheduler-border mb-3">
                                                            <legend class="scheduler-border"> Extra Details :</legend>
                                                        <div class="row" id="dummy_div_multiple">
                                                            <div class="col-md-12 main_div_multiple mb-0">
                                                                <div class="row">
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Image Upload<span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-md-2 mt-1">
                                                                        <label>Is Clickable<span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Mapped Type<span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Mapped Master</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3 mt-1">
                                                                        <input type="file" class="form-control" id="img_file_1" name="img_file[]" accept=".jpg,.jpeg,.png"><br/>
                                                                    </div>
                                                                    <div class="col-md-2 mt-1">
                                                                        <select class="select2" id="img_clickable_1" name="img_clickable[]" style="width: 100% !important;">
                                                                            <option value = "0">No</option>
                                                                            <option value = "1">Yes</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <select class="select2 mapped-to" id="mapped_to" name="mapped_to[]" style="width: 100% !important;" >
                                                                            @foreach($mappingCollectionType as $key => $type)
                                                                                <option value = "{{$key}}">{{ \App\Models\HomeCollectionMapping::MAPPING_COLLECTION_TYPES[$key] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <select class="select2  mapped-ids" id="mapped_ids" name="mapped_ids[0][]" multiple style="width: 100% !important;" >
                                                                            @foreach($books as $key => $book)
                                                                                <option value="{{$book->id}}">{{$book->translations[0]->name ?? ''}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="javascript:void(0);"  class="btn btn-primary btn-sm add-multiple-row"><i class="fa fa-plus fa-lg"></i></a><br/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                
                                                <div class="row div_single">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Image</label>
                                                        <input type="file" class=" form-control" id="single_image" name="single_image" accept=".jpg,.jpeg,.png"><br/>
                                                    </div>
                                                </div>
                                                <div class="row div_book">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Book<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="book_id" name="book_id[]" multiple>
                                                            @foreach($books as $book)
                                                                <option value="{{$book->id}}">{{$book->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_audio">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Audio<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="audio_id" name="audio_id[]" multiple>
                                                            @foreach($audios as $audio)
                                                                <option value="{{$audio->id}}">{{$audio->translations[0]->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_video">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Video<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="video_id" name="video_id[]" multiple>
                                                            @foreach($videos as $video)
                                                                <option value="{{$video->id}}">{{$video->translations[0]->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_sholk">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Shlok<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="shlok_id" name="shlok_id[]" multiple>
                                                            @foreach($shloks as $sholk)
                                                                <option value="{{$sholk->id}}">{{$sholk->translations[0]->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_artis">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Guru<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="artist_id" name="artist_id[]" multiple>
                                                            @foreach($artists as $artist)
                                                                <option value="{{$artist->id}}">{{$artist->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('addHomeCollection','post')">Submit</button>
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
</section>
<script>
    $(".select2").select2();
    $( document ).ready(function() {
        $(".div_multiple").hide();
        $(".extra-details-li").addClass('d-none');
        $('.select2').select2();
// Hide all divs initially
        $('.div_multiple, .div_book, .div_audio, .div_video, .div_sholk, .div_artis').hide();
        $('#collection_type').change(function () {
            // Hide all divs initially
            $('.div_single, .div_multiple, .div_book, .div_audio, .div_video, .div_sholk, .div_artis').hide();

            // Show the relevant div based on the selected value
            switch ($('#collection_type').val()) {
                case 'Multiple':
                    $('.div_multiple').show();
                    break;
                case 'Single':
                    $('.div_single').show();
                    break;
                case 'Book':
                    $('.div_book').show();
                    break;
                case 'Audio':
                    $('.div_audio').show();
                    break;
                case 'Video':
                    $('.div_video').show();
                    break;
                case 'Shlok':
                    $('.div_sholk').show();
                    break;
                case 'Artist':
                    $('.div_artis').show();
                    break;
                default:
                    $('.div_single').show();
            }
        });
    });
    $(document).on('change', '.mapped-to', function () {
        var $mappedToSelect = $(this);
        var $mappedIdsSelect = $mappedToSelect.closest('.row').find('.mapped-ids');
        let type = $(this).val();
        $.ajax({
            type: 'GET',
            url: 'get_mapped_listing/'+type,
            success: function (data) {
                // Clear existing options
                $mappedIdsSelect.empty();
                if (type == 'Book' && data.books != undefined) {
                    // Populate options based on the AJAX response
                    $.each(data.books, function (key, value) {
                        if (value.translations[0] != undefined) {

                            $mappedIdsSelect.append($('<option>', {
                                value: value.id,
                                text: value.translations[0].name ?? ''
                            }));
                        }
                    });

                    // Trigger Select2 to refresh and display the updated options
                    $mappedIdsSelect.trigger('change.select2');
                }
                if (type == 'Audio' && data.audios != undefined) {
                    $.each(data.audios, function (key, value) {
                        if (value.translations[0] != undefined) {
                            $mappedIdsSelect.append($('<option>', {
                                value: value.id,
                                text: value.translations[0].title ?? ''
                            }));
                        }
                    });

                    // Trigger Select2 to refresh and display the updated options
                    $mappedIdsSelect.trigger('change.select2');
                }
                if (type == 'Video' && data.videos != undefined) {
                    $.each(data.videos, function (key, value) {
                       if (value.translations[0] != undefined){
                           $mappedIdsSelect.append($('<option>', {
                               value: value.id,
                               text: value.translations[0].title ??''
                           }));   
                       }
                    });

                    // Trigger Select2 to refresh and display the updated options
                    $mappedIdsSelect.trigger('change.select2');
                }
                if (type == 'Shlok' && data.shloks != undefined) {
                    $.each(data.shloks, function (key, value) {
                        if (value.translations[0] != undefined) {

                            $mappedIdsSelect.append($('<option>', {
                                value: value.id,
                                text: value.translations[0].title ?? ''
                            }));
                        }
                    });

                    // Trigger Select2 to refresh and display the updated options
                    $mappedIdsSelect.trigger('change.select2');

                }
                if (type == 'Artist' && data.artists != undefined) {
                    $.each(data.artists, function (key, value) {
                        if (value.translations[0] != undefined) {

                            $mappedIdsSelect.append($('<option>', {
                                value: value.id,
                                text: value.translations[0].name ?? ''
                            }));
                        }
                    });

                    // Trigger Select2 to refresh and display the updated options
                    $mappedIdsSelect.trigger('change.select2');
                }
            },
        });
    });

    $(document).on('click', '.add-multiple-row', function () {
        // Disable the a tag
        $(this).addClass('disabled');
        var pluseButton = $(this);
        let totalDiv = $('.main_div_multiple').length;
        $.ajax({
            type: 'GET',
            url: 'prepare_multiple_collection_item/' + totalDiv,
            success: function (data) {
                // Append the data to the container
                var $newElements = $(data);
                $('#dummy_div_multiple').append($newElements);

                // Initialize Select2 on the newly added elements
                $newElements.find('.select2').select2();

                // Re-enable the anchor tag and remove the 'disabled' class
                pluseButton.removeClass('disabled');
            },
            error: function () {
                pluseButton.removeClass('disabled');
            }
        });
    });


    $(document).on('click', '.remove-multiple-div-row', function () {
        $(this).closest('.main_div_multiple').remove();
        updateSelectNames();
    });

    function updateSelectNames() {
        $('.main_div_multiple').each(function (index) {
            var $row = $(this);
            $row.find('select[name^="mapped_ids["]').attr('name', 'mapped_ids[' + index + '][]');
        });
    }
</script>
