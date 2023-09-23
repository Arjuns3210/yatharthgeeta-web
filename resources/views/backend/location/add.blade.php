<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Location</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                    	<div class="card-body">
                    		<form id="saveLocation" method="post" action="location/save">
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
                                                        <label>Type<span class="text-danger">*</span></label>
                                                        <select class="form-control" id="type" name="type">
                                                            <option value="ashram">Ashram</option>
                                                            <option value="others">Others</option>
                                                        </select><br>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Email<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="email" name="email"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Contact (add More no by comma)<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="phone" name="phone"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="location" name="location"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence"><br/>
                                                    </div>
                                                    <div class="col-sm-6" hidden>
                                                        <label>Latitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="latitude" name="latitude" value="19.1005574066246"><br/>
                                                    </div>
                                                    <div class="col-sm-6" hidden>
                                                        <label>Longitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="longitude" name="longitude" value="72.88494229316711"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Google Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="google_address" name="google_address"><br/>
                                                    </div>
                                                    <div class="col-md-6 col-lg-6 col-sm-6 text-center">
                                                        <p class="font-weight-bold">Image<span class="text-danger">*</span></p>
                                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.location_width')}}X{{config('global.dimensions.location_height')}} pixel and .jpg, .png, or jpeg format image</p>
                                                        <div class="shadow bg-white rounded d-inline-block mb-2">
                                                            <div class="input-file">
                                                                <label class="label-input-file">Choose Files &nbsp;&nbsp;&nbsp;<i class="ft-upload font-medium-1"></i>
                                                                    <input type="file" name="image" class="cover-images required" id="image" accept=".jpg, .jpeg, .png" onchange="handleFileInputChange('coverImages', 'image')">
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <p id="files-area">
                                                            <span id="coverImagesLists">
                                                                <span id="cover-images-names"></span>
                                                            </span>
                                                        </p>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <h6><strong>Working Days :</strong><span class="text-danger">*</span></h6>
                                                        <table class="">
                                                            <tr>
                                                                <th>Day</th>
                                                                <th>Open / Close</th>
                                                                <th style="padding-left: 33px">Start Time</th>
                                                                <th style="padding-left: 33px">End Time</th>
                                                            </tr>
                                                            <tr>
                                                                <td>Monday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="monday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="monday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="monday_end_time"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tuesday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="tuesday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="tuesday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="tuesday_end_time"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Wednesday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="wednesday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="wednesday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="wednesday_end_time"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thursday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="thursday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="thursday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="thursday_end_time"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Friday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="friday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="friday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="friday_end_time"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Saturday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="saturday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="saturday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="saturday_end_time"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Sunday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="sunday_open">
                                                                </td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="sunday_start_time"></td>
                                                                <td class="date-input" style="display:none;"><input type="time" name="sunday_end_time"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="map" style="height:400px; width: 400px;" class="my-3"></div>
                                                    </div>

                                                </div>
                                            </div>

                                            <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                                <div id="<?php echo $translated_data_tabs ?>_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'input') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    @if( formatName($translated_block_fields_key) == 'title')
                                                                    <label>Short Description<span class="text-danger">*</span></label>
                                                                    @else
                                                                    <label>{{formatName($translated_block_fields_key)}}<span class="text-danger">*</span></label>
                                                                    @endif
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">
                                                                </div>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-12 mb-3">
                                                                    @if( formatName($translated_block_fields_key) == 'do' || formatName($translated_block_fields_key) == 'dont')
                                                                    <label>{{formatName($translated_block_fields_key)}}</label>
                                                                    <textarea class="translation_block form-control" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}"></textarea>
                                                                    @else
                                                                    @if( formatName($translated_block_fields_key) == 'description')
                                                                    <label>Long Description<span class="text-danger">*</span></label>
                                                                    @else
                                                                    <label>{{formatName($translated_block_fields_key)}}<span class="text-danger">*</span></label>
                                                                    @endif
                                                                    <textarea class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}"></textarea>
                                                                    @endif
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
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveLocation','post')">Submit</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1"> Cancel</a>
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSrdDORoPiSFHR_XPUDEc8BNsLrfVhBeQ&callback=initMap" type="text/javascript"></script>
<script>
    let map;
    let geocoder; // Define a geocoder to convert lat/lng to address

    function initMap() {
        var lati = 19.1005574066246;
        var lang = 72.88494229316711;
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: lati, lng: lang },
            zoom: 15,
            scrollwheel: true,
        });

        geocoder = new google.maps.Geocoder(); // Initialize the geocoder

        const uluru = { lat: lati, lng: lang };
        let marker = new google.maps.Marker({
            position: uluru,
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker, 'position_changed', function () {
            let lat = marker.position.lat();
            let lng = marker.position.lng();
            $('#latitude').val(lat);
            $('#longitude').val(lng);

            // Reverse geocode to get the address
            geocoder.geocode({ 'location': { lat, lng } }, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        const address = results[0].formatted_address;
                        $('#google_address').val(address);
                    }
                }
            });
        });

        google.maps.event.addListener(map, 'click', function (event) {
            const pos = event.latLng;
            marker.setPosition(pos);
        });
    }
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const dateInputs = checkbox.parentElement.parentElement.querySelectorAll('.date-input');
            dateInputs.forEach(input => {
                input.style.display = checkbox.checked ? 'table-cell' : 'none';
            });
        });
    });


        const coverImageData = new DataTransfer();

        function handleCoverImagesAttachmentChange() {
            const attachmentInput = document.getElementById('image');

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
                const input = document.getElementById('image');
                input.value = ''; // This should clear the selected file(s) in the input field
            });
        }

        handleCoverImagesAttachmentChange();


</script>
