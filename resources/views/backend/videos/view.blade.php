<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Video : {{$videos['title']}} ( {{$videos->language->name ?? ''}} )</h5>
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
                                                        <td><strong>Duration (In Minutes)</strong></td>
                                                        <td>{{ $videos['duration'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>YouTube Video Link</strong></td>
                                                        <td>{{ $videos['link'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Media Language</strong></td>
                                                        <td>{{ $language['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Guru</strong></td>
                                                        <td>{{ $artist['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Views Count</strong></td>
                                                        <td>{{$videos->view_count ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sequence</strong></td>
                                                        <td>{{ $videos['sequence']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td><?php echo $videos['status'] == 1 ? 'Active' : 'Inactive' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Cover Image </strong></td>
                                                        <td><img src="{{$media->getFullUrl() ?? ''}}" width="200px" height="200px" alt=""></td>
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
                                                                        @if( formatName($translated_block_fields_key) == 'title')
                                                                            <td><strong>Video Name</strong></td>
                                                                        @else
                                                                        <td><strong>{{formatName(ucfirst($translated_block_fields_key))}}</strong></td>
                                                                        @endif
                                                                        <td><?php echo $videos[$translated_block_fields_key.'_'.$translated_data_tabs] ?? '' ?></td>
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

