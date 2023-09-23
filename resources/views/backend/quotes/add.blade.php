<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Quotes</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <!-- <hr class="mb-0"> -->
                    	<div class="card-body">
                    		<form id="saveQuotes" method="post" action="quotes/save">
                    			@csrf
                        		<div class="row">
                                    <div class="col-sm-6">
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input class="form-control required" type="text" id="title" name="title"><br/>
                                    </div>
                        			<div class="col-sm-6">
                        				<label>Sequence<span class="text-danger">*</span></label>
                        				<input class="form-control required integer-validation" type="number" id="sequence" name="sequence"><br/>
                        			</div>
                        		</div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-12 col-sm-6 text-center">
                                        <p class="font-weight-bold">Quote Image<span class="text-danger">*</span></p>
                                        <p style="color:blue;">Note : Upload file size {{config('global.dimensions.image')}}</p>
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
                                </div>
                        		<hr>
                        		<div class="row">
                        			<div class="col-sm-12">
                        				<div class="pull-right">
                        					<button type="button" class="btn btn-success" onclick="submitForm('saveQuotes','post')">Submit</button>
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
    </script>
</section>
