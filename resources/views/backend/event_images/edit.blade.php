<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Event Gallay Details : {{$event_image['title']}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editEventImageForm" method="post" action="event_images/update?id={{$event_image['id']}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Title<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="title" name="title" oninput="validateNameInput(this)" value="{{$event_image['title']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Event</label>
                                                        <select class="form-control mb-3" type="text" id="event_id" name="event_id">
                                                        @foreach($event as $event)
                                                            <option value="{{$event->id}}">{{$event->title}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Cover Image</label>
                                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" onchange="handleFileInputChange('image')" value="{{$event_image['image']}}"><br/>
                                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.event_gallery_width')}}X{{config('global.dimensions.event_gallery_height')}} pixel and .jpg, .png, or jpeg format image</p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="text" id="sequence" name="sequence" value="{{$event_image->sequence}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <img src="{{$media->getFullUrl() ?? ''}}" width="100px" height="100px" alt="">
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editEventImageForm','post')">Submit</button>
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
