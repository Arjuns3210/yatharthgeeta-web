<div class="row episode-master-div mb-2">
    <div class="col-sm-4">
        <label>Duration<span style="color:#ff0000">*</span></label>
        <input class="form-control required numeric-validation" type="number"
               id="episode_duration" name="episode_duration[]"><br/>
    </div>
    <div class="col-sm-4">
        <label>sequence<span style="color:#ff0000">*</span></label>
        <input class="form-control required" type="text"
               id="episode_sequence" name="episode_sequence[]"><br/>
    </div>
    <div class="col-sm-3">
        <label>Audio File (MP3)</label>
        <input class="form-control " type="file"  accept=".mp3" name="episode_audio_file[]">
    </div>
    <div class="col-sm-1">
        <br>
        <div class="py-1">
            <a href="javascript:void(0)" class="btn btn-danger btn-sm remove_episode_item"><i
                        class="fa fa-trash"></i></a>
        </div>
    </div>
    <div class="col-sm-4">
        <label>Title<span style="color:#ff0000">*</span></label>
        <input class="form-control required" type="text" name="episode_title[]">
    </div>
    <div class="col-sm-4">
        <label>Chapters <span style="color:#ff0000">*</span></label>
        <input class="form-control required" type="text" name="episode_chapters[]">
    </div>
    <div class="col-sm-3">
        <label>Verses <span style="color:#ff0000">*</span></label>
        <input class="form-control required" type="text" name="episode_verses[]">
    </div>
</div>
