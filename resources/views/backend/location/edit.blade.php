<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Location: {{$location['name']}} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editLocationForm" method="post" action="location/update?id={{$location['id']}}">
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
                                                        <label>Type</label>
                                                        <select class="form-control" id="type" name="type">
                                                            <option value="ashram" <?php echo $location['type'] == 'ashram' ? 'selected' : '' ?>>Ashram</option>
                                                            <option value="others" <?php echo $location['type'] == 'others' ? 'selected' : '' ?>>Others</option>
                                                        </select><br>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Email<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="email" name="email" value="{{$location['email']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Contact (add More no by comma)<span class="text-danger">*</span></label>
                                                        <?php $output = implode(',', json_decode($location['phone'])); ?>
                                                        <input class="form-control required" type="text" id="phone" name="phone" value="{{$output}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="location" name="location" value="{{$location['location']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence"  value="{{$location['sequence']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6" hidden>
                                                        <label>Latitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="number" id="latitude" name="latitude"  value="{{$location['latitude']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6" hidden>
                                                        <label>Longitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="number" id="longitude" name="longitude"  value="{{$location['longitude']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Goolge Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="google_address" name="google_address" value="{{$location['google_address']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
														<div class="col-md-6 col-lg-12 col-sm-6 text-center file-input-div">
															<p class="font-weight-bold">IMAGE <span class="text-danger">*</span></p>
															<div class="shadow bg-white rounded d-inline-block mb-2">
																<div class="input-file">
																	<label class="label-input-file">Choose Files <i class="ft-upload font-medium-1"></i>
																		<input class="form-control" accept=".jpg,.jpeg,.png" type="file" id="image" name="image" onchange="handleFileInputChange('cover_image')"><br/>
																	</label>
																</div>
															</div>
															<p id="files-area">
																<span id="coverImagesLists">
																	<span id="cover-images-names"></span>
																</span>
															</p>
														</div>
                                                        @if(!empty($media))
														<div class="d-flex mb-1  media-div-{{$media->id}}">
															<input type="text"
																	class="form-control input-sm bg-white document-border"
																	value="{{ $media->file_name ?? '' }}"
																	readonly style="color: black !important;">
															<a href="{{ $media->getFullUrl() }}"
																class="btn btn-primary mx-2 px-2" target="_blank"><i
																		class="fa ft-eye"></i></a>
														</div>
                                                        @endif
														<p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
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
                                                                <?php
                                                                $monday_open = $working_days['monday_open'] == 'on' ? 'checked' : '';
                                                                $monday_calss = $working_days['monday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Monday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="monday_open" {{ $monday_open}}>
                                                                </td>
                                                                <td class="date-input" style="{{ $monday_calss }}"><input type="time" name="monday_start_time" value="{{$working_days['monday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $monday_calss }}"><input type="time" name="monday_end_time" value="{{$working_days['monday_end_time']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $tuesday_open = $working_days['tuesday_open'] == 'on' ? 'checked' : '';
                                                                $tuesday_calss = $working_days['tuesday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Tuesday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="tuesday_open" {{ $tuesday_open }}>
                                                                </td>
                                                                <td class="date-input" style="{{ $tuesday_calss }}"><input type="time" name="tuesday_start_time" value="{{$working_days['tuesday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $tuesday_calss }}"><input type="time" name="tuesday_end_time" value="{{$working_days['tuesday_end_time']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $wednesday_open = $working_days['wednesday_open'] == 'on' ? 'checked' : '';
                                                                $wednesday_calss = $working_days['wednesday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Wednesday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="wednesday_open" {{ $wednesday_open }}>
                                                                </td>
                                                                <td class="date-input" style="{{ $wednesday_calss }}"><input type="time" name="wednesday_start_time" value="{{$working_days['wednesday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $wednesday_calss }}"><input type="time" name="wednesday_end_time" value="{{$working_days['wednesday_end_time']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $thursday_open = $working_days['thursday_open'] == 'on' ? 'checked' : '';
                                                                $thursday_calss = $working_days['thursday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Thursday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="thursday_open" {{ $thursday_open }}>
                                                                </td>
                                                                <td class="date-input" style="{{ $thursday_calss }}"><input type="time" name="thursday_start_time" value="{{$working_days['thursday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $thursday_calss }}"><input type="time" name="thursday_end_time" value="{{$working_days['thursday_end_time']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $friday_open = $working_days['friday_open'] == 'on' ? 'checked' : '';
                                                                $friday_calss = $working_days['friday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Friday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="friday_open" {{ $friday_open }}>
                                                                </td>
                                                                <td class="date-input" style="{{ $friday_calss }}"><input type="time" name="friday_start_time" value="{{$working_days['friday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $friday_calss }}"><input type="time" name="friday_end_time" value="{{$working_days['friday_end_time']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $saturday_open = $working_days['saturday_open'] == 'on' ? 'checked' : '';
                                                                $saturday_calss = $working_days['saturday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Saturday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="saturday_open" {{ $saturday_open }}>
                                                                </td>
                                                                <td class="date-input" style="{{ $saturday_calss }}"><input type="time" name="saturday_start_time" value="{{$working_days['saturday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $saturday_calss }}"><input type="time" name="saturday_end_time" value="{{$working_days['saturday_end_time']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <?php
                                                                $sunday_open = $working_days['sunday_open'] == 'on' ? 'checked' : '';
                                                                $sunday_calss = $working_days['sunday_open'] == 'on' ? '' : 'display:none';
                                                                ?>
                                                                <td>Sunday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="sunday_open" {{ $sunday_open }}>
                                                                </td>
                                                                <td class="date-input" style="{{ $sunday_calss }}"><input type="time" name="sunday_start_time" value="{{$working_days['sunday_start_time']}}"></td>
                                                                <td class="date-input" style="{{ $sunday_calss }}"><input type="time" name="sunday_end_time" value="{{$working_days['sunday_end_time']}}"></td>
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
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) {
                                                         ?>

                                                            <?php if($translated_block_fields_value == 'input') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    @if( formatName($translated_block_fields_key) == 'title')
                                                                    <label>Short Description<span class="text-danger">*</span></label>
                                                                    @else
                                                                    <label>{{formatName($translated_block_fields_key)}}<span class="text-danger">*</span></label>
                                                                    @endif
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" value="{{$location[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}">
                                                                </div>
                                                            <?php
                                                        } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    @if( formatName($translated_block_fields_key) == 'do' || formatName($translated_block_fields_key) == 'dont')
                                                                    <label>{{formatName($translated_block_fields_key)}}</label>
                                                                    <textarea class="translation_block form-control" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$location[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
                                                                    @else
                                                                    @if( formatName($translated_block_fields_key) == 'description')
                                                                    <label>Long Description<span class="text-danger">*</span></label>
                                                                    @else
                                                                    <label>{{formatName($translated_block_fields_key)}}<span class="text-danger">*</span></label>
                                                                    @endif
                                                                    <textarea class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$location[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editLocationForm','post')">Submit</button>
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
	
	$('.delete-media').click(function () {
                let mediaId = $(this).attr('data-id');
                deleteDocuments(mediaId, '.media-div-');
            });
    
	let map;
    let geocoder; // Define a geocoder to convert lat/lng to address

    function initMap() {
        var lati = parseInt("<?php echo $location['latitude']?>");
        var lang = parseInt("<?php echo $location['longitude']?>");
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: lati, lng: lang },
            zoom: 10,
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
</script>
