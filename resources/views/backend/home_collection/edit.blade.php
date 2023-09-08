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
                                                            <input class="form-control required" type="text" id="sequence" name="sequence" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46' value="{{$collection->sequence ?? ''}}"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>display in columns</label>
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
                                                    <!-- -------------------multiple_div start----------------------- -->
                                                    <div class="col-md-12 ">
                                                        <div class="row" id="dummy_div_multiple">
                                                            <div class="col-md-12 main_div_multiple mb-0">
                                                                <div class="row">
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Image Upload<span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Is Clickable</label>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Mapped Type</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3 mt-1">
                                                                        <input type="file" class="form-control" id="img_file_1" name="img_file[]" ><br/>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <select class="select2" id="img_clickable_1" name="img_clickable[]" style="width: 100% !important;">
                                                                            <option value = "0">No</option>
                                                                            <option value = "1">Yes</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <select class="select2" id="mapped_to_1" name="mapped_to[]" style="width: 100% !important;">
                                                                            <option value = "0">No</option>
                                                                            <option value = "1">Yes</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="javascript:void(0);" onclick="add_multi_row();" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-lg"></i></a><br/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ---------------------- sample div for multiple ---------------------------- -->
                                                <div class="sample_div_multiple_class" style= "display:none">
                                                    <div class="col-md-12 main_div_multiple mt-0" id="sample_div_multiple">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <input type="file" class="img_file_sample_class form-control" id="img_file_1" name="img_file[]" ><br/>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="select2 img_clickable_sample_class form-control" id="img_clickable_1" name="img_clickable[]" style="width: 100% !important;">
                                                                    <option value = "0">No</option>
                                                                    <option value = "1">Yes</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 mt-1">
                                                                <select class="select2 mapped_to_sample_class" id="mapped_to_1" name="mapped_to[]" style="width: 100% !important;">
                                                                    <option value = "0">No</option>
                                                                    <option value = "1">Yes</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="remove_multi_row(this);" ><i class="fa fa-trash fa-lg"></i></button><br/>
                                                            </div>
                                                        </div>
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
                                                                    <option value="{{$sholk->id}}" {{(in_array($sholk->id,$mappedIds))? 'selected':''}}>{{$sholk->translations[0]->name ?? ''}}</option>
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
</script>
