<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Event</h5>
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
                                                        <td><strong>Event Start Date</strong></td>
                                                        <td>{{ $event['event_start_date'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Event End Date</strong></td>
                                                        <td>{{ $event['event_end_date'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Event Start Time</strong></td>
                                                        <td>{{ $event['event_start_time'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Event End Time</strong></td>
                                                        <td>{{ $event['event_end_time'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Event Visible Date</strong></td>
                                                        <td>{{ $event['event_visible_date'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Location</strong></td>
                                                        <td>{{ $location['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Guru</strong></td>
                                                        <td>{{ $artist['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sequence</strong></td>
                                                        <td>{{ $event['sequence']}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td><?php echo $event['status'] == 1 ? 'Active' : 'Inactive' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Cover Image </strong></td>
                                                        <td>
                                                            @if(!empty($coverImage))
                                                            <img src="{{$coverImage->getFullUrl() ?? ''}}" width="200px" height="200px" alt="">
                                                        @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Event Image</strong></td>
                                                        <td>
                                                            @forelse($eventImages as  $image)
                                                                <div class="d-flex mb-1 ">
                                                                    <input type="text"
                                                                           class="form-control input-sm bg-white document-border"
                                                                           value="{{ $image->name}}"
                                                                           readonly
                                                                           style="color: black !important;">
                                                                    <a href="{{$image->getFullUrl()}}"
                                                                       class="btn btn-primary mx-2 px-2"
                                                                       target="_blank"><i class="fa ft-eye"></i></a>
                                                                </div>

                                                            @empty
                                                                Event Images Not uploaded
                                                            @endforelse</td>
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
                                                                        <td><strong>{{ucfirst($translated_block_fields_key)}}</strong></td>
                                                                        <td><?php echo $event[$translated_block_fields_key.'_'.$translated_data_tabs] ?? '' ?></td>
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

