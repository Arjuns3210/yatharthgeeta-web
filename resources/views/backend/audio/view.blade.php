<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Audio : {{$audio->translations[0]->title ?? ''}}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade mt-2 show active" role="tabpanel">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <tr>
                                                        <td><strong>Has Episodes</strong></td>
                                                        <td>{{ ($audio->has_episodes == 1) ? 'Yes' : 'No' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Duration (In Minute)</strong></td>
                                                        <td>{{ ($audio->duration == 1) ? 'Yes' : 'No' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sequence</strong></td>
                                                        <td>{{ $audio->sequence }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Audio File</strong></td>
                                                        <td>
                                                            @php
                                                                $allowedMimeTypes = [
                                                                'audio/mpeg', // MP3
                                                                'audio/ogg',  // Ogg
                                                                'audio/wav',  // WAV
                                                            ];
                                                            @endphp
                                                            @if (in_array($audioFile->mime_type, $allowedMimeTypes))
                                                            <audio id="audioPlayer" controls>
                                                                <source src="{{$audioFile->getFullUrl() ?? ''}}" type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                            @else 
                                                           -
                                                           @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Cover Image</strong></td>
                                                        @if(!empty($audioCoverImage))
                                                            <td><img src="{{$audioCoverImage->getFullUrl() ?? ''}}" alt="" width="50px"></td>
                                                        @else
                                                            <td></td>
                                                        @endif
                                                    </tr>
                                                    @foreach($audio->translations as $key => $data)
                                                        <tr>
                                                            <td><strong>Title ({{ ucfirst($data->locale) }})</strong></td>
                                                            <td>{{ $data->title ?? '' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong>Description ({{ ucfirst($data->locale) }})</strong></td>
                                                            <td>{{ $data->description ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                        </div>
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
