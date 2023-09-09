<section class="shloks-list-wrapper">
    <div class="shloks-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Shlok</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary px-3 py-1"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="saveShlok" method="post" action="shloks/save">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab"
                                                    href="#shlok_details">Details</a>
                                            </li>
                                            <?php foreach (config('translatable.locales') as $translated_tabs) { ?>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab"
                                                    href="#<?php echo $translated_tabs; ?>_block_details"><?php echo $translated_tabs; ?></a>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="shlok_details" class="tab-pane fade in active show">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Shlok Text<span class="text-danger">*</span></label>
                                                        <textarea class="form-control required" rows="5" id="shlok_text" name="shlok_text"></textarea>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>Status<span class="text-danger">*</span></label>
                                                        <select class="form-control required" id="shlok_status"
                                                            name="shlok_status">
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required" type="text"
                                                            id="shlok_sequence" name="shlok_sequence"
                                                            oninput="onlyNumericNegative(this)">
                                                    </div>
                                                </div>
                                            </div>
                                            <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                            <div id="<?php echo $translated_data_tabs; ?>_block_details" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Shlok Title (<?php echo $translated_data_tabs; ?>)</label>
                                                        <input class="translation_block form-control required"
                                                            type="text" id="shlok_title_<?php echo $translated_data_tabs; ?>"
                                                            name="shlok_title_<?php echo $translated_data_tabs; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Chapter (<?php echo $translated_data_tabs; ?>)</label>
                                                        <input class="translation_block form-control required"
                                                            type="text" id="shlok_chapter_<?php echo $translated_data_tabs; ?>"
                                                            name="shlok_chapter_<?php echo $translated_data_tabs; ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Shlok Description (<?php echo $translated_data_tabs; ?>)</label>
                                                        <textarea class="translation_block form-control required" rows="5" type="text"
                                                            id="shlok_description_<?php echo $translated_data_tabs; ?>" name="shlok_description_<?php echo $translated_data_tabs; ?>"></textarea>
                                                    </div>
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
                                            <button type="button" class="btn btn-success"
                                                onclick="submitForm('saveShlok','post')">Submit</button>
                                            <a href="{{ URL::previous() }}" class="btn btn-danger">Cancel</a>
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
