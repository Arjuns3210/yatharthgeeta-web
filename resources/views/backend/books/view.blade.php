
<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Book : {{$books['name']}} ({{ config('translatable.locales_name')[\App::getLocale()] }})</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
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
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>Number of Pages</strong></td>
                                                        <td>{{ $books['pages'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Book Pdf</strong></td>
                                                        <td>
                                                            @if(!empty($pdf_file))
                                                            <div class="d-flex mb-1 ">
                                                                <input type="text"
                                                                       class="form-control input-sm bg-white document-border"
                                                                       value="{{ $pdf_file->file_name ?? ''}}"
                                                                       readonly
                                                                       style="color: black !important;">
                                                                <a href="{{$pdf_file->getFullUrl() ?? ''}}"
                                                                   class="btn btn-primary mx-2 px-2"
                                                                   target="_blank"><i class="fa ft-eye"></i></a>
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Book Epub File</strong></td>
                                                        <td>
                                                            @if(!empty($epub_file))
                                                            <div class="d-flex mb-1 ">
                                                                <input type="text"
                                                                       class="form-control input-sm bg-white document-border"
                                                                       value="{{ $epub_file->file_name ?? ''}}"
                                                                       readonly
                                                                       style="color: black !important;">
                                                                <a href="{{$epub_file->getFullUrl() ?? ''}}"
                                                                   class="btn btn-primary mx-2 px-2"
                                                                   target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
                                                            </div>
                                                        @else
                                                            -
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Available Audio</strong></td>
                                                        <td>{{$books->audio->translations[0]->title ?? '-'}} ({{$books->language->name}})</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Available Video</strong></td>
                                                        <td>{{$books->video->translations[0]->title ?? '-'}} ({{$books->language->name}})</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>People Also Read</strong></td>
                                                        <td>
                                                            @if(!empty($book))
                                                                @foreach ($book as $related_id)
                                                                    <li> {{ $related_id->name }}</li>
                                                                @endforeach
                                                            @else
                                                               -
                                                             @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Guru</strong></td>
                                                        <td>{{ $books->artist['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Media Language</strong></td>
                                                        <td>{{ $books->language['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Views Count</strong></td>
                                                        <td>{{$books->view_count ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sequence</strong></td>
                                                        <td>{{ $books->sequence ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td><?php echo $books['status'] == 1 ? 'Active' : 'Inactive' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Cover Image </strong></td>
                                                        <td>
                                                            @if(!empty($media))
                                                                <img src="{{ $media-> getFullUrl() ?? ''}}" width="200px" height="200px" alt="">
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <?php foreach (config('translatable.locales') as $translated_data_tabs) { ?>
                                            <div id="<?php echo $translated_data_tabs ?>_block_details" class="tab-pane fade">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <?php foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value) { ?>
                                                                    <tr>
                                                                        @if(formatName($translated_block_fields_key) == 'name')
                                                                            <td><strong>Book Name</strong></td>
                                                                        @elseif ( formatName($translated_block_fields_key) == 'description')
                                                                            <td><strong>Long Description</strong></td>
                                                                        @else
                                                                        <td><strong>{{formatName(ucfirst(str_replace('_',' ',$translated_block_fields_key)))}}</strong></td>
                                                                        @endif
                                                                        <td><?php echo $books[$translated_block_fields_key.'_'.$translated_data_tabs] ?? '' ?></td>
                                                                    </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
