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
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Collection Type<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="collection_type" name="collection_type">
                                                            @foreach($collection_types as $key => $type)
                                                                <option value="{{$key}}">{{\App\Models\ExploreCollection::EXPLORE_COLLECTION_TYPES[$key]}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 mb-2">
                                                            <label>Sequence<span class="text-danger">*</span></label>
                                                            <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" ><br/>
                                                        </div>
                                                    <div class="col-sm-6 mb-2"  >
                                                            <label>Display in columns<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 required" id="display_in_column" name="display_in_column">
                                                                @foreach(\App\Models\ExploreCollection::DISPLAY_IN_COLUMN as $key => $type)
                                                                    <option value="{{$type}}">{{$type}}</option>
                                                                @endforeach
                                                            </select><br/>
                                                        </div>
                                                    <div class="col-sm-6 mb-4 mt-4">
                                                            <div class="custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="is_scrollable" name="is_scrollable">
                                                                <label class="custom-control-label" for="is_scrollable">Is Scrollable</label>
                                                            </div>
                                                        </div>
                                                </div>
                                                
                                                <div class="row div_book">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Book<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 book-type-filed required" id="book_id" name="book_id[]" multiple>
                                                            @foreach($books as $book)
                                                                <option value="{{$book->id}}">{{$book->name ?? ''}} ( {{ $book->language->name ?? '' }} )</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_audio">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Satsang<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 audio-type-filed" id="audio_id" name="audio_id[]" multiple>
                                                            @foreach($audios as $audio)
                                                                <option value="{{$audio->id}}">{{$audio->title ?? ''}} ( {{ $audio->language->name ?? '' }} )</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_quote">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Quote<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 quote-type-filed" id="quote_id" name="quote_id[]" multiple>
                                                            @foreach($quotes as $quote)
                                                                <option value="{{$quote->id}}">{{$quote->title ?? ''}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row div_mantra">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Mantra<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 mantra-type-filed" id="mantra_id" name="mantra_id[]" multiple>
                                                            @foreach($mantras as $mantra)
                                                                <option value="{{$mantra->id}}">{{$mantra->name ?? ''}}</option>
                                                            @endforeach
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
                                                                    <label>{{ $translated_block_fields_key }}<span class="text-danger">*</span></label>
                                                                    <input class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}">
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
            $('.book-type-filed, .audio-type-filed, .mantra-type-filed, .quote-type-filed').removeClass('required');

            // Show the relevant div based on the selected value
            switch ($('#collection_type').val()) {
                case 'Book':
                    $('.div_book').show();
                    $('.book-type-filed').addClass('required');
                    break;
                case 'Audio':
                    $('.div_audio').show();
                    $('.audio-type-filed').addClass('required');
                    break;
                case 'Quote':
                    $('.div_quote').show();
                    $('.quote-type-filed').addClass('required');
                    break;
                case 'Mantra':
                    $('.div_mantra').show();
                    $('.mantra-type-filed').addClass('required');
                    break;
                default:
                    $('.div_book').show();
                    $('.book-type-filed').addClass('required');
            }
        });
    });
</script>
