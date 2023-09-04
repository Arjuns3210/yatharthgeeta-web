<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Video Details :  {{$videos->title}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editVideoForm" method="post" action="videos/update?id={{$videos['id']}}">
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
                                                        <label>Video Status<span class="text-danger">*</span></label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1" <?php echo $videos['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                            <option value="0" <?php echo $videos['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Cover Image</label>
                                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" onchange="handleFileInputChange('cover_image')" value="{{$videos['cover_image']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                    <img src="{{$media->getFullUrl() ?? ''}}" width="200px" height="200px" alt="">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Duration (In Min)</label>
                                                        <input class="form-control" type="text" id="duration" name="duration" oninput="filterNonNumeric(this)" value="{{$videos->duration}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Cover Image</label>
                                                        <input class="form-control" type="file" accept=".jpg,.jpeg,.png" id="image" name="image" onchange="handleFileInputChange('cover_image')" value="{{$videos['cover_image']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="sequence" name="sequence" oninput="onlyNumericNegative(this)" value="{{$videos->sequence}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <img src="{{$media->getFullUrl() ?? ''}}" width="100px" height="100px" alt="">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Link<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text" id="link" name="link" value="{{$videos->link}}"><br/>
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
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" value="{{$videos[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}">
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
                                                                    <textarea class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$videos[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editVideoForm','post')">Submit</button>
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
