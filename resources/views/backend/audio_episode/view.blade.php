<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Audio Episode : {{$audioEpisode->translations[0]->title ?? ''}}</h5>
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
                                        <div class="col-sm-12">
                                            <ul class="nav nav-tabs">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                                </li>
                                                @foreach (config('translatable.locales') as $translated_tabs)
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#{{ $translated_tabs }}_block_details">{{ config('translatable.locales_name')[$translated_tabs] }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <div class="tab-content">
                                                <div id="data_details" class="tab-pane fade in active show">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-bordered">
                                                                    <tr>
                                                                        <td><strong>Duration (In Minute)</strong></td>
                                                                        <td>{{ $audioEpisode->duration ?? ''}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Main Shlok</strong></td>
                                                                        <td>{!!$audioEpisode->main_shlok ?? ''!!}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Explanation Shlok</strong></td>
                                                                        <td>{!! $audioEpisode->explanation_shlok ?? ''!!}</td>
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
                                                                            @if (in_array($audioEpisodeFile->mime_type, $allowedMimeTypes))
                                                                                <audio id="audioPlayer" controls>
                                                                                    <source src="{{$audioEpisodeFile->getFullUrl() ?? ''}}" type="audio/mpeg">
                                                                                    Your browser does not support the audio element.
                                                                                </audio>
                                                                            @else
                                                                                -
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Srt File</strong></td>
                                                                       <td>
                                                                           @if(!empty($audioEpisodeSrtFile))
                                                                           <div class="d-flex mb-1 ">
                                                                               <input type="text"
                                                                                      class="form-control input-sm bg-white document-border"
                                                                                      value="{{ $audioEpisodeSrtFile->name ?? ''}}"
                                                                                      readonly
                                                                                      style="color: black !important;">
                                                                               <a href="{{$audioEpisodeSrtFile->getFullUrl() ?? ''}}"
                                                                                  class="btn btn-primary mx-2 px-2"
                                                                                  target="_blank"><i class="fa ft-eye"></i></a>                                                          
                                                                           </div>
                                                                           @else
                                                                               -
                                                                               @endif
                                                                       </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td><strong>Date Time</strong></td>
                                                                        <td>{{\Carbon\Carbon::parse($audioEpisode->created_at)->format('d-m-Y')}}</td>
                                                                    </tr>
                                                                   
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach (config('translatable.locales') as $translated_data_tabs)
                                                    <div id="{{ $translated_data_tabs }}_block_details" class="tab-pane fade"> 
                                                        @php
                                                            $translateData  = $audioEpisode->translations()->where('locale',$translated_data_tabs)->first();
                                                        @endphp
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-bordered">
                                                                        <tr>
                                                                            <td><strong>Audio Episode Title</strong>
                                                                            </td>
                                                                            <td>{{ $translateData->title ?? ''}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Chapter Number</strong>
                                                                            </td>
                                                                            <td>{{ $translateData->chapter_number ?? ''}}</td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td><strong>Chapter Name</strong>
                                                                            </td>
                                                                            <td>{{ $translateData->chapter_name ?? ''}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Verses Number</strong>
                                                                            </td>
                                                                            <td>{{$translateData->verses_number ?? ''}}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td><strong>Verses Name</strong>
                                                                            </td>
                                                                            <td>{{$translateData->verses_name ?? ''}}</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

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
