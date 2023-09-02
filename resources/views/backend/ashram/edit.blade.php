<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Ashram</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editBooksCategoryForm" method="post" action="ashram/update?id={{$ashram['id']}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            <?php foreach (config('translatable.locales') as $translated_tabs) { ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#<?php echo $translated_tabs ?>_block_details"><?php echo $translated_tabs; ?></a>
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
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Image</label>
                                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" onchange="handleFileInputChange('image')" value="{{$ashram['image']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Email<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="email" name="email" value="{{$ashram['email']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <img src="{{$media->getFullUrl() ?? ''}}" width="100px" height="100px" alt="" id="image">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Contact (add More no by comma)<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="phone" name="phone" value="{{$ashram['phone']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Location<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="location" name="location" value="{{$ashram['location']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Latitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="latitude" name="latitude" oninput="filterNonNumeric(this)" value="{{$ashram['latitude']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Longitude<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="longitude" name="longitude" oninput="filterNonNumeric(this)" value="{{$ashram['longitude']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Goolge Address<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="google_address" name="google_address" value="{{$ashram['google_address']}}"><br/>
                                                    </div>
                                                    <!-- <div class="col-sm-6">
                                                        <label>Working Hours :<span class="text-danger">*</span></label>
                                                        <div class="row">
                                                            <div class="col-sm-6">

                                                                <div class="custom-switch custom-control-inline mb-1 mb-xl-0">
                                                                    <label class="custom-control-label mr-1" for="sunday">
                                                                        <span>Sunday</span>
                                                                    </label>
                                                                    <input type="checkbox" class="custom-control-input" id="sunday" name="sunday">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div> -->
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editBooksCategoryForm','post')">Submit</button>
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