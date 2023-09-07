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
                                        <style>
                                            .nav.nav-tabs .extra-details-li.d-none {
                                                display: none !important;
                                            }
                                        </style>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            <li class="nav-item extra-details-li ">
                                                <a class="nav-link" data-toggle="tab" href="#multiple-details">Extra details</a>
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
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Collection Type<span class="text-danger">*</span></label>
                                                        <select class="form-control select2" id="collection_type" name="collection_type">
                                                            @foreach($collection_types as $key => $type)
                                                                <option value="{{$key}}">{{$type}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                        
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Collection Title<span class="text-danger">*</span></label>
                                                        <textarea class="ckeditor form-control" id="" rows="13" name="title"></textarea>
                                                        <br/>
                                                    </div>
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Short Description</label>
                                                            <input class="form-control" type="text" id="short_description" name="short_description"><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Sequence<span class="text-danger">*</span></label>
                                                            <input class="form-control required" type="text" id="sequence" name="sequence" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>display in columns</label>
                                                            <input class="form-control required" type="text" id="display_in_columns" name="display_in_columns" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode ==46'><br/>
                                                        </div>
                                                        <div class="col-sm-12 pl-0 pr-0">
                                                            <label>Orientation Type<span class="text-danger">*</span></label>
                                                            <select class="form-control select2" id="orientation" name="orientation">
                                                                @foreach($orientation_types as $key => $type)
                                                                    <option value="{{$key}}">{{$type}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- ---------------------- sample div for multiple ---------------------------- -->
                                                <div class="sample_div_multiple_class" style= "display:none">
                                                    <div class="col-md-12 main_div_multiple mt-0" id="sample_div_multiple">
                                                        <div class="row">
                                                            <div class="col-md-3 mt-1">
                                                                <input type="text" class="img_name_sample_class form-control" id="img_name_1" name="img_name[]" placeholder="Image Name"><br/>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="file" class="img_file_sample_class form-control" id="img_file_1" name="img_file[]" ><br/>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select class="select2 img_clickable_sample_class form-control" id="img_clickable_1" name="img_clickable[]" style="width: 100% !important;">
                                                                    <option value = "1">Yes</option>
                                                                    <option value = "0">No</option>
                                                                </select><br/><br>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-danger btn-sm" onclick="remove_multi_row(this);" ><i class="fa fa-trash fa-lg"></i></button><br/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- ----------------------- sample div for multiple --------------------------- -->
                                            </div>
                                            <div class="tab-pane fade mt-2" id="multiple-details" role="tabpanel" aria-labelledby="multiple-details-tab">
                                                <div class="row">
                                                    <!-- -------------------multiple_div start----------------------- -->
                                                    <div class="col-md-12 div_multiple">
                                                        <div class="row" id="dummy_div_multiple">
                                                            <div class="col-md-12 main_div_multiple mb-0">
                                                                <div class="row">
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Image Name</label>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Image Upload<span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <label>Is Clickable</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-3 mt-1">
                                                                        <input type="text" class="form-control" id="img_name_1" name="img_name[]" placeholder="Image Name"><br/>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <input type="file" class="form-control" id="img_file_1" name="img_file[]" ><br/>
                                                                    </div>
                                                                    <div class="col-md-3 mt-1">
                                                                        <select class="select2" id="img_clickable_1" name="img_clickable[]" style="width: 100% !important;">
                                                                            <option value = "1">Yes</option>
                                                                            <option value = "0">No</option>
                                                                        </select><br/><br>
                                                                    </div>
                                                                    <div class="col-md-1 mt-1">
                                                                        <a href="javascript:void(0);" onclick="add_multi_row();" class="btn btn-primary btn-sm"><i class="fa fa-plus fa-lg"></i></a><br/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach (config('translatable.locales') as $translated_data_tabs)
                                                <div id="{{ $translated_data_tabs }}_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        @foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value)
                                                            @if ($translated_block_fields_value == 'input')
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{ $translated_block_fields_key }}</label>
                                                                    <input class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    <div class="row">
                                                        @foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value)
                                                            @if ($translated_block_fields_value == 'textarea')
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{ $translated_block_fields_key }}</label>
                                                                    <textarea class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}"></textarea>
                                                                </div>
                                                            @endif
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('addBooksCategoryForm','post')">Submit</button>
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
<script src="../backend/vendors/ckeditor5/ckeditor.js"></script>
<script>
    $( document ).ready(function() {
        $(".div_multiple").hide();
        $(".extra-details-li").addClass('d-none');
        $('.select2').select2();
        var editor = loadCKEditor('ckeditor-textarea');

        $('#collection_type').change(function () {
            if ($('#collection_type').val() == 'multiple') {
                $('.extra-details-li').removeClass('d-none');
                $('.div_multiple').show();
            } else {
                $('.div_multiple').hide();
                $('.extra-details-li').addClass('d-none');
            }
        });
    });

    function add_multi_row(){
        var i = parseInt($('[id^=img_name_]:last').attr('id').substr(9))+1;
        $('.sample_div_multiple_class .img_name_sample_class').attr({'name':'img_name[]','id':'img_name_'+ i});
        $('.sample_div_multiple_class .img_file_sample_class').attr({'name':'img_file[]','id':'img_file_'+ i});
        $('.sample_div_multiple_class .img_clickable_sample_class').attr({'name':'img_clickable[]','id':'img_clickable_'+ i});

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
