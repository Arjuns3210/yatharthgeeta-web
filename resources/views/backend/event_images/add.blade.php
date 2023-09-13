<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Event Image : {{ $event->translations[0]->title ?? '' }} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="saveEventImage" method="post" action="event_images/save">
                    			@csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-md-6 col-lg-6 col-sm-6  text-center">
                                                        <input type="hidden" name="event_id" value="{{$event->id}}">
                                                        <p class="font-weight-bold">Event Image</p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">
                                                                    Choose Files &nbsp;&nbsp;&nbsp;<i
                                                                            class="ft-upload font-medium-1"></i>
                                                                    <input type="file" multiple name="event_images[]"
                                                                           class="event-images"
                                                                           id="eventImages" accept=".jpg, .jpeg, .png">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p id="files-area">
	<span id="eventImagesLists">
		<span id="event-images-names"></span>
	</span>
                                                        </p>
                                                        <div class="mt-2">
                                                            @foreach($eventImages as $image)
                                                                <div class="d-flex mb-1  event-image-div-{{$image->id}}">
                                                                    <input type="text"
                                                                           class="form-control input-sm bg-white document-border"
                                                                           value="{{ $image->name }}"
                                                                           readonly style="color: black !important;">
                                                                    <a href="{{ $image->getFullUrl() }}"
                                                                       class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                                class="fa ft-eye"></i></a>
                                                                    <a href="javascript:void(0)"
                                                                       class="btn btn-danger delete-event-image  px-2"
                                                                       data-url="{{ $image->getFullUrl() }}" data-id="{{ $image->id }}"><i
                                                                                class="fa ft-trash"></i></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
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
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveEventImage','post')">Submit</button>
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
    $(document).ready(function(){
        const eventImageData = new DataTransfer();
        function handleEventImagesAttachmentChange () {
            const attachmentInput = document.getElementById('eventImages');

            attachmentInput.addEventListener('change', function (e) {
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const fileBloc = $('<span/>', { class: 'file-block' });
                    const fileName = $('<span/>', { class: 'name', text: file.name });

                    fileBloc.append('<span class=" file-delete event-image-delete"><span>+</span></span>').
                        append(fileName);

                    $('#eventImagesLists > #event-images-names').append(fileBloc);
                    eventImageData.items.add(file);
                }

                this.files = eventImageData.files;

                $('span.event-image-delete').click(function () {
                    const name = $(this).next('span.name').text();
                    $(this).parent().remove();

                    for (let i = 0; i < eventImageData.items.length; i++) {
                        if (name === eventImageData.items[i].getAsFile().name) {
                            eventImageData.items.remove(i);
                            break;
                        }
                    }

                    document.getElementById('eventImages').files = eventImageData.files;
                });
            });
        }
        handleEventImagesAttachmentChange ()

        $('.delete-event-image').click(function () {
            let mediaId = $(this).attr('data-id');
            deleteDocuments(mediaId, '.event-image-div-');
        });
    });
</script>
