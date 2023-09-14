<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Explore Collection</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="addExploreCollection" method="post" action="explore_collection/save" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Collection Type<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="collection_type" name="collection_type">
                                                            @foreach($collection_types as $key => $type)
                                                                <option value="{{$key}}">{{\App\Models\ExploreCollection::EXPLORE_COLLECTION_TYPES[$key]}}</option>
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
                                                        <label>Pravachan<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="audio_id" name="audio_id[]" multiple>
                                                            @foreach($audios as $audio)
                                                                <option value="{{$audio->id}}">{{$audio->translations[0]->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_quote">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Quote<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="quote_id" name="quote_id[]" multiple>
                                                            @foreach($quotes as $quote)
                                                                <option value="{{$quote->id}}">{{$quote->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_mantra">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Mantra<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 " id="mantra_id" name="mantra_id[]" multiple>
                                                            @foreach($mantras as $mantra)
                                                                <option value="{{$mantra->id}}">{{$mantra->translations[0]->title ?? ''}}</option>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('addExploreCollection','post')">Submit</button>
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
// Hide all divs initially
        $('.div_audio,.div_mantra,.div_quote').hide();
        $('#collection_type').change(function () {
            // Hide all divs initially
            $(' .div_book, .div_audio,.div_mantra,.div_quote').hide();

            // Show the relevant div based on the selected value
            switch ($('#collection_type').val()) {
                case 'Book':
                    $('.div_book').show();
                    break;
                case 'Audio':
                    $('.div_audio').show();
                    break;
                case 'Quote':
                    $('.div_quote').show();
                    break;
                case 'Mantra':
                    $('.div_mantra').show();
                    break;
                default:
                    $('.div_book').show();
            }
        });
    });
</script>
