<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Collection:
                                        {{$collection->title}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                            <form id="updateHomeCollection" method="post" action="home_collection/update">
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
                                                            <option value="{{$collection->type}}" >{{$collection->type}}</option>
                                                        </select>
                                                        <input type="hidden" value="{{$collection->id}}" name="id">
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Language<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="language_id" name="language_id">
                                                            @foreach($languages as $language)
                                                                <option value="{{$language->id}}" {{ ($collection->id == $language->id) ? 'selected'  : '' }}>{{$language->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Collection Title<span class="text-danger">*</span></label>
                                                        <textarea class="ckeditor form-control required" id="" rows="13" name="title">{!! $collection->title ?? '' !!}</textarea>
                                                        <br/>
                                                    </div>
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Short Description</label>
                                                            <input class="form-control" type="text" id="description" name="description" value="{{$collection->description ?? ''}}"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Sequence<span class="text-danger">*</span></label>
                                                            <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" value="{{$collection->sequence ?? ''}}"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Display in columns<span class="text-danger">*</span></label>
                                                            <input class="form-control required" type="text" id="display_in_column" name="display_in_column" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46' value="{{$collection->display_in_column ?? ''}}"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0 mt-2">
                                                            <div class="custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="is_scrollable" name="is_scrollable" {{($collection->is_scrollable == 1) ? 'checked' : ''}}>
                                                                <label class="custom-control-label" for="is_scrollable">Is Scrollable</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($collection->type == \App\Models\HomeCollection::MULTIPLE)
                                                    <div class="row div_multiple">
                                                        <div class="col-md-12 ">
                                                            <fieldset class="scheduler-border mb-3">
                                                                <legend class="scheduler-border"> Extra Details :</legend>
                                                                <div class="row" id="dummy_div_multiple">
                                                                    @foreach($multipleCollectionData as $detailsKey => $collectionDetail)
                                                                        <div class="col-md-12 main_div_multiple mb-0">
                                                                            @if($loop->first)
                                                                            <div class="row">
                                                                                <div class="col-md-3 mt-1">
                                                                                    <label>Image Upload<span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-md-2 mt-1">
                                                                                    <label>Is Clickable</label>
                                                                                </div>
                                                                                <div class="col-md-3 mt-1">
                                                                                    <label>Mapped Type</label>
                                                                                </div>
                                                                                <div class="col-md-3 mt-1">
                                                                                    <label>Mapped Master</label>
                                                                                </div>
                                                                            </div>
                                                                            @endif
                                                                            <div class="row">
                                                                                <div class="col-md-3 mt-1">
                                                                                    <div class="row">
                                                                                        <div class="col-11 ">
                                                                                            <input type="file" class="form-control"  name="img_file[]" accept=".jpg,.jpeg,.png"><br/>
                                                                                        </div>
                                                                                        <div class="col-1 p-0 mt-1">
                                                                                            <a href="{{ $collectionDetail->multiple_collection_image ?? '' }}" target=”_blank”  class="btn btn-primary btn-sm view-small-button"><i class="fa fa-eye"></i></a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-2 mt-1">
                                                                                    <input type="hidden" name="collection_details_ids[]" value="{{$collectionDetail->id}}">
                                                                              <select class="select2"  name="img_clickable[]" style="width: 100% !important;">
                                                                                        <option value = "0" {{ ($collectionDetail->is_clickable == 0) ? 'selected':'' }}>No</option>
                                                                                        <option value = "1" {{ ($collectionDetail->is_clickable == 1) ? 'selected':'' }}>Yes</option>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-3 mt-1">
                                                                                    <select class="select2 mapped-to"  name="mapped_to[]" style="width: 100% !important;" >
                                                                                        @foreach($mappingCollectionType as $key => $type)
                                                                                            <option value = "{{$key}}" {{($collectionDetail->mapped_to == $key) ? 'selected' : ''}}>{{ $type }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-3 mt-1">
                                                                                    @php
                                                                                    $detailsMappedIds = explode(",",$collectionDetail->mapped_ids ?? '');
                                                                                    @endphp
                                                                                    <select class="select2  mapped-ids"
                                                                                            name="mapped_ids[{{$detailsKey}}][]"
                                                                                            multiple
                                                                                            style="width: 100% !important;">
                                                                                        @if($collectionDetail->mapped_to == \App\Models\HomeCollectionMapping::BOOK)
                                                                                            @foreach($books as $key => $book)
                                                                                                <option value="{{$book->id}}" {{ in_array($book->id,$detailsMappedIds) ? 'selected' : '' }}>{{$book->translations[0]->name ?? ''}}</option>
                                                                                            @endforeach
                                                                                        @elseif($collectionDetail->mapped_to == \App\Models\HomeCollectionMapping::AUDIO)
                                                                                            @foreach($audios as $audio)
                                                                                                <option value="{{$audio->id}}" {{(in_array($audio->id,$detailsMappedIds))? 'selected':''}}>{{$audio->translations[0]->title ?? ''}}</option>
                                                                                            @endforeach

                                                                                        @elseif($collectionDetail->mapped_to == \App\Models\HomeCollectionMapping::VIDEO)
                                                                                            @foreach($videos as $video)
                                                                                                <option value="{{$video->id}}" {{(in_array($video->id,$detailsMappedIds))? 'selected':''}}>{{$video->translations[0]->title ?? ''}}</option>
                                                                                            @endforeach
                                                                                        @elseif($collectionDetail->mapped_to == \App\Models\HomeCollectionMapping::SHLOK)
                                                                                            @foreach($shloks as $sholk)
                                                                                                <option value="{{$sholk->id}}" {{(in_array($sholk->id,$detailsMappedIds))? 'selected':''}}>{{$sholk->translations[0]->title ?? ''}}</option>
                                                                                            @endforeach

                                                                                        @elseif($collectionDetail->mapped_to == \App\Models\HomeCollectionMapping::ARTIST)
                                                                                            @foreach($artists as $artist)
                                                                                                <option value="{{$artist->id}}" {{(in_array($artist->id,$detailsMappedIds))? 'selected':''}}>{{$artist->translations[0]->name ?? ''}}</option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                </div>
                                                                                <div class="col-md-1 mt-1">
                                                                                    @if($loop->first)
                                                                                    <a href="javascript:void(0);"  class="btn btn-primary btn-sm add-multiple-row"><i class="fa fa-plus fa-lg"></i></a><br/>
                                                                                    @else
                                                                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm remove-multiple-div-row"><i  class="fa fa-trash"></i></a>                                                                                                                     @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\HomeCollection::SINGLE)
                                                    <div class="row div_single">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Image</label>
                                                            <input type="file" class=" form-control" id="single_image" name="single_image" accept=".jpg,.jpeg,.png"><br/>
                                                            @foreach($singleImage as $image)
                                                                <div class="d-flex mb-1  cover-image-div-{{$image->id}}">
                                                                    <input type="text"
                                                                           class="form-control input-sm bg-white document-border"
                                                                           value="{{ $image->name }}"
                                                                           readonly style="color: black !important;">
                                                                    <a href="{{ $image->getFullUrl() }}"
                                                                       class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                class="fa ft-eye"></i></a>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-danger delete-single-image  px-2"
                                                                       data-url="{{ $image->getFullUrl() }}" data-id="{{ $image->id }}"><i
                                                                                class="fa ft-trash"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\HomeCollection::BOOK)
                                                    <div class="row div_book">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Book<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="book_id" name="book_id[]" multiple>
                                                                @foreach($books as $book)
                                                                    <option value="{{$book->id}}" {{(in_array($book->id,$mappedIds))? 'selected':''}}>{{$book->translations[0]->name ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\HomeCollection::AUDIO)
                                                    <div class="row div_audio">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Audio<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="audio_id" name="audio_id[]" multiple>
                                                                @foreach($audios as $audio)
                                                                    <option value="{{$audio->id}}" {{(in_array($book->id,$mappedIds))? 'selected':''}}>{{$audio->translations[0]->title ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\HomeCollection::VIDEO)
                                                    <div class="row div_video">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Video<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="video_id" name="video_id[]" multiple>
                                                                @foreach($videos as $video)
                                                                    <option value="{{$video->id}}" {{(in_array($video->id,$mappedIds))? 'selected':''}}>{{$video->translations[0]->title ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\HomeCollection::SHLOK)
                                                    <div class="row div_sholk">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Shlok<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="shlok_id" name="shlok_id[]" multiple>
                                                                @foreach($shloks as $sholk)
                                                                    <option value="{{$sholk->id}}" {{(in_array($sholk->id,$mappedIds))? 'selected':''}}>{{$sholk->translations[0]->title ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\HomeCollection::ARTIST)
                                                <div class="row div_artis">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Artis<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="artist_id" name="artist_id[]" multiple>
                                                            @foreach($artists as $artist)
                                                                <option value="{{$artist->id}}" {{(in_array($artist->id,$mappedIds))? 'selected':''}}>{{$artist->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('updateHomeCollection','post')">Submit</button>
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
        $('.delete-single-image').click(function () {
            let mediaId = $(this).attr('data-id');
            deleteDocuments(mediaId, '.cover-image-div-');
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
