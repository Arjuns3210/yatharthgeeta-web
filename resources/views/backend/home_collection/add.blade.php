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
                            <form id="addHomeCollection" method="post" action="home_collection/save">
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
                                                                <option value="{{$key}}">{{$type}}</option>
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
                                                            <input class="form-control required" type="text" id="sequence" name="sequence" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>display in columns</label>
                                                            <input class="form-control required" type="text" id="display_in_columns" name="display_in_columns" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'><br/>
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
                                                
                                                <div class="row div_single">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Image</label>
                                                        <input type="file" class=" form-control" id="single_image" name="single_image" ><br/>
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
                                                                <option value="{{$audio->id}}">{{$audio->translations[0]->name ?? ''}}</option>
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
                                                                <option value="{{$sholk->id}}">{{$sholk->translations[0]->name ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_artis">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Artis<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="artis_id" name="artis_id[]" multiple>
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

    function add_multi_row(){
        var i = parseInt($('[id^=img_file_]:last').attr('id').substr(9))+1;
        $('.sample_div_multiple_class .img_file_sample_class').attr({'name':'img_file[]','id':'img_file_'+ i});
        $('.sample_div_multiple_class .img_clickable_sample_class').attr({'name':'img_clickable[]','id':'img_clickable_'+ i});
        $('.sample_div_multiple_class .mapped_to_sample_class').attr({'name':'mapped_to[]','id':'mapped_to'+ i});

        var sampleClone = $('#sample_div_multiple').clone();
        sampleClone.find("span").remove();
        sampleClone.find("select").select2();
        $('#dummy_div_multiple').append(sampleClone);
    }

    function remove_multi_row($this)
    {
        $($this).parents('.main_div_multiple').remove();
    }
</script>
