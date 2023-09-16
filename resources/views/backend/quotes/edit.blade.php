<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Edit Quotes : {{$quotes['title']}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="updateQuoteData" method="post" action="quotes/update?id={{$quotes['id']}}">
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-6">
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="title" name="title" value="{{$quotes->title ?? ''}}"><br/>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Sequence<span class="text-danger">*</span></label>
                                        <input class="form-control required integer-validation" type="number" id="sequence" name="sequence" value="{{$quotes->sequence}}"><br/>
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
									@if(!empty($media))
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
									@endif
                                    <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
                                </div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('updateQuoteData','post')">Update</button>
                                            <a href="{{URL::previous()}}" class="btn btn-danger px-3 py-1">Cancel</a>
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
