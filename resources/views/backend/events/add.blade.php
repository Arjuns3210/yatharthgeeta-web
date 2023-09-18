<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Event</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="saveEvent" method="post" action="events/save">
                    			@csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            <?php foreach (config('translatable.locales') as $translated_tabs) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#<?php echo $translated_tabs ?>_block_details">{{ config('translatable.locales_name')[$translated_tabs] }}</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Event Start Date<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="date" id="event_start_date" name="event_start_date"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Event End Date<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="date" id="event_end_date" name="event_end_date"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Event Start Time<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="time" id="event_start_time" name="event_start_time"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Event End Time<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="time" id="event_end_time" name="event_end_time"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Event Visible Date<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="date" id="event_visible_date" name="event_visible_date"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Media Location<span class="text-danger">*</span></label>
                                                        <select class="form-control required mb-3" type="text" id="location_id" name="location_id">
                                                        @foreach($location as $location)
                                                            <option value="{{$location->id}}">{{$location->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Guru<span class="text-danger">*</span></label>
                                                        <select class="form-control required mb-3" type="text" id="artist_id" name="artist_id">
                                                        @foreach($artist as $artist)
                                                            <option value="{{$artist->id}}">{{$artist->name}}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence"><br/>
                                                    </div>
                                                    <div class="col-md-6 col-lg-12 col-sm-6 mt-2 text-center">
                                                        <p class="font-weight-bold">Cover<span class="text-danger">*</span></p>
                                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">Choose Files &nbsp;&nbsp;&nbsp;<i class="ft-upload font-medium-1"></i>
                                                                    <input type="file" name="cover" class="cover-images required" id="cover" accept=".jpg, .jpeg, .png" onchange="handleFileInputChange('cover', 'image')">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p id="files-area">
                                                            <span id="coverImagesLists">
                                                                <span id="cover-images-names"></span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>

                                            <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                                <div id="<?php echo $translated_data_tabs ?>_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'input') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{str_replace('_',' ',$translated_block_fields_key)}}</label>
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{str_replace('_',' ',$translated_block_fields_key)}}</label>
                                                                    <textarea class="translation_block form-control required" rows="5" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}"></textarea>
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveEvent','post')">Submit</button>
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
    <script>
        const coverImageData = new DataTransfer();

        function handleCoverImagesAttachmentChange() {
            const attachmentInput = document.getElementById('cover');

            attachmentInput.addEventListener('change', function (e) {
                if (this.files.length === 1) {
                    const file = this.files[0];
                    const fileBloc = $('<span/>', { class: 'file-block' });
                    const fileName = $('<span/>', { class: 'name', text: file.name });

                    fileBloc.append('<span class="file-delete cover-image-delete"><span>+</span></span>').
                        append(fileName);

                    // Clear existing uploaded documents
                    $('#coverImagesLists > #cover-images-names').empty();

                    $('#coverImagesLists > #cover-images-names').append(fileBloc);
                    coverImageData.items.clear(); // Clear existing items
                    coverImageData.items.add(file);
                } else {
                    this.value = '';
                    $('#coverImagesLists > #cover-images-names').empty();
                    coverImageData.items.clear();
                }
            });

            $(document).on('click', 'span.cover-image-delete', function () {
                // Clear UI
                $('#coverImagesLists > #cover-images-names').empty();

                // Clear DataTransfer object (coverImageData)
                coverImageData.items.clear();

                // Reset the input field to clear selected files
                const input = document.getElementById('cover');
                input.value = ''; // This should clear the selected file(s) in the input field
            });
        }

        handleCoverImagesAttachmentChange();
    </script>
</section>
<script>
    $(document).ready(function() {
        // Attach event listener to the start date input
        $('#event_start_date').change(function() {
            var startDate = new Date($('#event_start_date').val());
            var endDate = new Date($('#event_end_date').val());

            // Check if start date is greater than end date
            if (startDate > endDate) {
                $.activeitNoty({
                    type: 'danger',
                    icon: 'fa fa-minus',
                    message: 'Event Start date cannot be greater than end Event date.' ,
                    container: 'floating',
                    timer: 3000
                });
                $('#event_start_date').val('');
            }
        });

        // Attach event listener to the end date input
        $('#event_end_date').change(function() {
            var startDate = new Date($('#event_start_date').val());
            var endDate = new Date($('#event_end_date').val());

            // Check if start date is greater than end date
            if (startDate > endDate) {
                $.activeitNoty({
                    type: 'danger',
                    icon: 'fa fa-minus',
                    message: 'Event Start date cannot be greater than Event end date.' ,
                    container: 'floating',
                    timer: 3000
                });
                $('#event_end_date').val('');
            }
        });

        $('#event_start_time').change(function() {
            var startTime = $('#event_start_time').val();
            var endTime = $('#event_end_time').val();
            if (endTime !='' && startTime > endTime) {
                $.activeitNoty({
                    type: 'danger',
                    icon: 'fa fa-minus',
                    message: 'Event Start time cannot be greater than Event end time.' ,
                    container: 'floating',
                    timer: 3000
                });
                $('#event_start_time').val('');
            }
        });
        $('#event_end_time').change(function() {
            var startTime = $('#event_start_time').val();
            var endTime = $('#event_end_time').val();
            if (startTime != '' && startTime > endTime) {
                $.activeitNoty({
                    type: 'danger',
                    icon: 'fa fa-minus',
                    message: 'Event Start time cannot be greater than Event end time.' ,
                    container: 'floating',
                    timer: 3000
                });
                $('#event_end_time').val('');
            }
        });
    });

</script>
