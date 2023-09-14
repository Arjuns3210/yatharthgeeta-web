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
                            <form id="updateExploreCollection" method="post" action="explore_collection/update">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6 mb-2">
                                                        <label>Collection Type<span class="text-danger">*</span></label>
                                                        <select class="form-control select2 required" id="collection_type" name="collection_type">
                                                            <option value="{{$collection->type}}" >{{\App\Models\ExploreCollection::EXPLORE_COLLECTION_TYPES[$collection->type]}}</option>
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

                                                @if($collection->type == \App\Models\ExploreCollection::BOOK)
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
                                                @if($collection->type == \App\Models\ExploreCollection::AUDIO)
                                                    <div class="row div_audio">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Audio<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="audio_id" name="audio_id[]" multiple>
                                                                @foreach($audios as $audio)
                                                                    <option value="{{$audio->id}}" {{(in_array($audio->id,$mappedIds))? 'selected':''}}>{{$audio->translations[0]->title ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\ExploreCollection::QUOTES)
                                                    <div class="row">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Quotes<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="quote_id" name="quote_id[]" multiple>
                                                                @foreach($quotes as $quote)
                                                                    <option value="{{$quote->id}}" {{(in_array($quote->id,$mappedIds))? 'selected':''}}>{{$quote->title ?? ''}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if($collection->type == \App\Models\ExploreCollection::MANTRA)
                                                    <div class="row">
                                                        <div class="col-sm-6 mb-2">
                                                            <label>Mantra<span class="text-danger">*</span></label>
                                                            <select class="form-control select2 " id="mantra_id" name="mantra_id[]" multiple>
                                                                @foreach($mantras as $mantra)
                                                                    <option value="{{$mantra->id}}" {{(in_array($mantra->id,$mappedIds))? 'selected':''}}>{{$mantra->translations[0]->title ?? ''}}</option>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('updateExploreCollection','post')">Submit</button>
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
</script>
