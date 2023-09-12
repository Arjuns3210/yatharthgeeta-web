<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Ashram: {{$ashram['name']}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editAshramForm" method="post" action="ashram/update?id={{$ashram['id']}}">
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
                                                        <label>Ashram Status<span class="text-danger">*</span></label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1" <?php echo $ashram['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                            <option value="0" <?php echo $ashram['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                        </select><br>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Type</label>
                                                        <select class="form-control" id="type" name="type">
                                                            <option value="ashram" <?php echo $ashram['type'] == 'ashram' ? 'selected' : '' ?>>Ashram</option>
                                                            <option value="others" <?php echo $ashram['type'] == 'others' ? 'selected' : '' ?>>Others</option>
                                                        </select><br>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Email<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="email" name="email" value="{{$ashram['email']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Contact (add More no by comma)<span class="text-danger">*</span></label>
                                                        <?php $output = implode(',', json_decode($ashram['phone'])); ?>
                                                        <input class="form-control required" type="text" id="phone" name="phone" value="{{$output}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="location" name="location" value="{{$ashram['location']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="sequence" name="sequence" oninput="onlyNumericNegative(this)" value="{{$ashram['sequence']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6" hidden>
                                                        <label>Latitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="latitude" name="latitude" oninput="filterNonNumeric(this)" value="{{$ashram['latitude']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6" hidden>
                                                        <label>Longitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="longitude" name="longitude" oninput="filterNonNumeric(this)" value="{{$ashram['longitude']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Goolge Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="google_address" name="google_address" value="{{$ashram['google_address']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Image</label>
                                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" onchange="handleFileInputChange('image')"><br/>
                                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                        @if(isset($media))
                                                        <div class="main-del-section" style="position: relative; border: 1px solid #999; border-radius: 5px; padding: 5px; margin-right: 10px; display: inline-block;">
                                                            <img src="{{$media->getFullUrl() ?? ''}}" width="100px" height="auto">
                                                            <span class="delimg bg-danger text-center" id="{{$ashram['id']}}" data-url="ashram/delete_img?id={{$ashram['id']}}" style="padding: 0 5px; position: absolute; top: -8px; right: -8px; border-radius: 50%; cursor: pointer;"><i class="fa fa-times text-light"></i></span>
                                                        </div>
                                                        @endif
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
                                                                    <input type="checkbox" name="open_monday">
                                                                </td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="start_monday" value="{{$working_days['start_monday']}}"></td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="end_monday" value="{{$working_days['end_monday']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Tuesday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="open_tuesday">
                                                                </td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="start_tuesday" value="{{$working_days['start_tuesday']}}"></td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="end_tuesday" value="{{$working_days['end_tuesday']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Wednesday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="open_wednesday">
                                                                </td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="start_wednesday" value="{{$working_days['start_wednesday']}}"></td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="end_wednesday" value="{{$working_days['end_wednesday']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Thursday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="open_thursday">
                                                                </td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="start_thursday" value="{{$working_days['start_thursday']}}"></td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="end_thursday" value="{{$working_days['end_thursday']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Friday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="open_friday">
                                                                </td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="start_friday" value="{{$working_days['start_friday']}}"></td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="end_friday" value="{{$working_days['end_friday']}}"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Saturday</td>
                                                                <td class="toggle-button text-center">
                                                                    <input type="checkbox" name="open_saturday">
                                                                </td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="start_saturday" value="{{$working_days['start_saturday']}}"></td>
                                                                <td class="date-input" style="padding-left: 33px;display:none;"><input type="time" name="end_saturday" value="{{$working_days['end_saturday']}}"></td>
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
                                                                    <label>{{$translated_block_fields_key}}</label>
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" value="{{$ashram[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}">
                                                                </div>
                                                            <?php
                                                        } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{$translated_block_fields_key}}</label>
                                                                    <textarea class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$ashram[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editAshramForm','post')">Submit</button>
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
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSrdDORoPiSFHR_XPUDEc8BNsLrfVhBeQ&callback=initMap" type="text/javascript"></script>
<script>
    let map;
    let geocoder; // Define a geocoder to convert lat/lng to address

    function initMap() {
        var lati = parseInt("<?php echo $ashram['latitude']?>");
        var lang = parseInt("<?php echo $ashram['longitude']?>");
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