<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">Add Episode :  {{ $audioTitle->title ?? '' }}</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="addAudioEpisodeForm" method="post" action="save_episodes">
                                <input type="hidden" name="audio_id" value="{{$audio->id ?? ''}}">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#data_details">Details</a>
                                            </li>
                                            @foreach (config('translatable.locales') as $translated_tabs)
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#{{ $translated_tabs }}_block_details">{{ $translated_tabs }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <div class="tab-content">
                                            <div id="data_details" class="tab-pane fade in active show">
                                             <div class="row">
                                                 <div class="col-sm-6">
                                                     <label>Duration (In Minute)<span style="color:#ff0000">*</span></label>
                                                     <input class="form-control required" type="number" id="duration" name="duration"><br/>
                                                 </div>
                                                 <div class="col-sm-6">
                                                     <label>sequence<span style="color:#ff0000">*</span></label>
                                                     <input class="form-control required" type="number"    id="sequence" name="sequence"><br/>
                                                 </div>
                                                 <div class="col-sm-6">
                                                     <label>Audio File (MP3)<span style="color:#ff0000">*</span></label>
                                                     <input class="form-control required" type="file"  accept=".mp3, .wav" name="audio_file">
                                                 </div>
                                                 <div class="col-sm-6 mb-2">
                                                     <label>Srt for lyrics<span style="color:#ff0000">*</span></label>
                                                     <input class="form-control required" type="file" accept=".srt" name="srt_file">
                                                 </div>
                                             </div>

                                            </div>
                                            @foreach (config('translatable.locales') as $translated_data_tabs)
                                                <div id="{{ $translated_data_tabs }}_block_details" class="tab-pane fade">
                                                    <div class="row">
                                                        @foreach ($translated_block as $translated_block_fields_key => $translated_block_fields_value)
                                                            <div class="col-md-6 mb-3">
                                                                @if ($translated_block_fields_value == 'input')
                                                                    <label>{{ $translated_block_fields_key }}<span class="text-danger">*</span></label>
                                                                    <input class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}">
                                                                @endif
                                                                @if ($translated_block_fields_value == 'textarea')
                                                                    <label>{{ $translated_block_fields_key }}<span class="text-danger">*</span></label>
                                                                    <textarea class="translation_block form-control required" type="text" id="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}" name="{{ $translated_block_fields_key }}_{{ $translated_data_tabs }}"></textarea>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-success" onclick="submitForm('addAudioEpisodeForm','post')">Submit</button>
                                            <a href="{{URL::previous()}}" class="btn btn-sm btn-danger px-3 py-1"> Cancel</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3 ">
                                    <h5 class="my-2 text-bold-500"><i class="ft-info mr-2"></i>Audio Episodes</h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td><strong>Title</strong></td>
                                                <td><strong>Duration</strong></td>
                                                <td><strong>Sequence</strong></td>
                                            </tr>
                                            @foreach($audioEpisodes as $episode)
                                                <tr>
                                                    <td>{{ $episode->translations[0]->title ?? '' }}</td>
                                                    <td>{{ $episode->duration ?? '' }}</td>
                                                    <td>{{ $episode->sequence ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
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
        $('.select2').select2();
    </script>
</section>
