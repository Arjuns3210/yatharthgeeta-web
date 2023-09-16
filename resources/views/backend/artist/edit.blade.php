<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Guru: {{$guru['name']}} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="editGuruForm" method="post" action="guru/update?id={{$guru['id']}}">
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
                                                        <label>Sequence<span class="text-danger">*</span></label>
                                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" value="{{$guru['sequence']}}"><br/>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>guru Status<span class="text-danger">*</span></label>
                                                        <select class="form-control" id="status" name="status">
                                                            <option value="1" <?php echo $guru['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                            <option value="0" <?php echo $guru['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 offset-sm-3 mt-3">
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
                                                    <div class="d-flex mb-1  media-div-{{$media->id}}">
                                                        <input type="text"
                                                                class="form-control input-sm bg-white document-border"
                                                                value="{{ $media->file_name ?? '' }}"
                                                                readonly style="color: black !important;">
                                                        <a href="{{ $media->getFullUrl() }}"
                                                            class="btn btn-primary mx-2 px-2" target="_blank"><i
                                                                    class="fa ft-eye"></i></a>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-danger delete-media  px-2"
                                                            data-url="{{ $media->getFullUrl() }}" data-id="{{ $media->id }}"><i
                                                                    class="fa ft-trash"></i></a>
                                                    </div>
                                                    <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                                </div>
                                            </div>

                                            <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                                <div id="<?php echo $translated_data_tabs ?>_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) {
                                                         ?>

                                                            <?php if($translated_block_fields_value == 'input') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{$translated_block_fields_key}}<span class="text-danger">*</span></label>
                                                                    <input class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" value="{{$guru[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}">
                                                                </div>
                                                            <?php
                                                        } ?>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="row">
                                                        <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                            <?php if($translated_block_fields_value == 'textarea') { ?>
                                                                <div class="col-md-6 mb-3">
                                                                    <label>{{$translated_block_fields_key}}<span class="text-danger">*</span></label>
                                                                    <textarea class="translation_block form-control required" type="text" id="{{$translated_block_fields_key}}_{{$translated_data_tabs}}" name="{{$translated_block_fields_key}}_{{$translated_data_tabs}}">{{$guru[$translated_block_fields_key.'_'.$translated_data_tabs] ?? ''}}</textarea>
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
                                            <button type="button" class="btn btn-success" onclick="submitForm('editGuruForm','post')">Submit</button>
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
    </script>
</section>
