@extends('backend.layouts.app')
@section('content')
<div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <section class="users-list-wrapper">
        	<div class="users-list-table">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                            <div class="card-header">
                                    <h4 class="card-title text-center">Manage General Settings</h4>
                                </div>
                                <!-- <hr class="mb-0"> -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3 mt-3">
                                            <!-- Nav tabs -->
                                            <ul class="nav flex-column nav-pills" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                                        <i class="ft-settings mr-1 align-middle"></i>
                                                        <span class="align-middle">General</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="about_us-tab" data-toggle="tab" href="#about_us" role="tab" aria-controls="about_us" aria-selected="false">
                                                        <i class="ft-info mr-1 align-middle"></i>
                                                        <span class="align-middle">About Us</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="terms-tab" data-toggle="tab" href="#terms" role="tab" aria-controls="terms" aria-selected="false">
                                                        <i class="ft-command mr-1 align-middle"></i>
                                                        <span class="align-middle">Terms and Condition</span>
                                                    </a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" id="privacy-tab" data-toggle="tab" href="#privacy" role="tab" aria-controls="privacy" aria-selected="false">
                                                        <i class="ft-globe mr-1 align-middle"></i>
                                                        <span class="align-middle">Privacy Policy</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="social-links-tab" data-toggle="tab" href="#social-links" role="tab" aria-controls="social-links" aria-selected="false">
                                                        <i class="ft-twitter mr-1 align-middle"></i>
                                                        <span class="align-middle">Social Links</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="app_link-tab" data-toggle="tab" href="#app_link" role="tab" aria-controls="app_link" aria-selected="false">
                                                        <i class="ft-link mr-1 align-middle"></i>
                                                        <span class="align-middle">App Link</span>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="app_version-tab" data-toggle="tab" href="#app_version" role="tab" aria-controls="app_version" aria-selected="false">
                                                        <i class="ft-play mr-1 align-middle"></i>
                                                        <span class="align-middle">App Version</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-9">
                                            <!-- Tab panes -->
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <div class="tab-content">
                                                            <!-- General Tab -->
                                                            <div class="tab-pane active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                                                <form id="generalForm" method="post" action="updateSettingInfo?param=general">
                                                                @csrf
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label for="system_email">System E-mail</label>
                                                                            <div class="controls">
                                                                                <input type="email" id="system_email" name="system_email" class="form-control" placeholder="E-mail" value="{{$data['system_email']}}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="system_contact_no">System Contact No</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="system_contact_no" name="system_contact_no" class="form-control" placeholder="Contact No" value="{{$data['system_contact_no']}}" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46' required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="meta_title">Meta Title</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="meta_title" name="meta_title"  value="{{$data['meta_title']}}" class="form-control"  placeholder="" aria-invalid="false">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="meta_keywords">Meta Keywords</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="meta_keywords" name="meta_keywords" value="{{$data['meta_keywords']}}" class="form-control" placeholder="" aria-invalid="false">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="meta_description">Meta Description</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="meta_description" name="meta_description" value="{{$data['meta_description']}}" class="form-control" placeholder="" aria-invalid="false">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitForm('generalForm','post')">Save Changes</button>
                                                                            {{-- <button type="reset" class="btn btn-danger mb-1">Cancel</button> --}}
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane" id="about_us" role="tabpanel" aria-labelledby="about_us-tab">
                                                                <form id="aboutusForm" method="post" action="updateSettingInfo?param=aboutus">
                                                                <!-- <form id="aboutusForm" method="post" action="updateSettingInfo/aboutus"> -->

                                                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label>About Us</label>
                                                                            <textarea class="ckeditor form-control" id="about_us_editor" name="about_us"> {{$data['about_us']}}</textarea>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitEditor('aboutusForm')">Save Changes</button>
                                                                            {{-- <button type="reset" class="btn btn-danger mb-1">Cancel</button> --}}
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane" id="contact_tab" role="tabpanel" aria-labelledby="contact_tab-tab">
                                                                <form id="contact_data" method="post" action="updateSettingInfo?param=contact_data">
                                                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label for="contact_email">Email</label>
                                                                            <div class="controls">
                                                                                <input type="email" id="contact_email" name="contact_email"  value="{{$data['contact_email']}}" class="form-control"  placeholder="" aria-invalid="false" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="contact_phone">Phone</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="contact_phone" name="contact_phone"  value="{{$data['contact_phone']}}" class="form-control"  placeholder="" aria-invalid="false" onkeypress='return event.charCode >= 48 && event.charCode <= 57 || event.charCode == 46'>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="contact_address">Address</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="contact_address" name="contact_address"  value="{{$data['contact_address']}}" class="form-control"  placeholder="" aria-invalid="false" >
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitForm('contact_data','post')">Save Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="tab-pane" id="terms" role="tabpanel" aria-labelledby="terms-tab">
                                                                <form id="tncForm" method="post" action="updateSettingInfo?param=tnc">
                                                                @csrf
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label>Terms and Condition</label>
                                                                            <textarea class="ckeditor form-control" id="terms_condition_editor" name="terms_condition">{{$data['terms_and_condition']}}</textarea>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitEditor('tncForm')">Save Changes</button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <div class="tab-pane" id="privacy" role="tabpanel" aria-labelledby="privacy-tab">
                                                                <form id="privacyForm" method="post" action="updateSettingInfo?param=privacy">
                                                                @csrf
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label>Privacy Policy</label>
                                                                            <textarea class="ckeditor form-control" id="privacy_policy_editor" name="privacy_policy">{{$data['privacy_policy']}}</textarea>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitEditor('privacyForm')">Save Changes</button>
                                                                            {{-- <button type="reset" class="btn btn-danger mb-1">Cancel</button> --}}
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <!-- Social Links Tab -->
                                                            <div class="tab-pane" id="social-links" role="tabpanel" aria-labelledby="social-links-tab">
                                                                <form id="socialLinkForm" method="post" action="updateSettingInfo?param=social">
                                                                @csrf
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label for="facebook">Facebook</label>
                                                                            <input id="facebook" type="text" name="fb_link" class="form-control" placeholder="Add link" value="{{$data['fb_link']}}">
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="instagram">Instagram</label>
                                                                            <input id="instagram" type="text" name="insta_link" class="form-control" placeholder="Add link" value="{{$data['insta_link']}}">
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="twitter">Twitter</label>
                                                                            <input id="twitter" type="text" name="twitter_link" class="form-control" placeholder="Add link" value="{{$data['twitter_link']}}">
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitForm('socialLinkForm','post')">Save Changes</button>
                                                                            {{-- <button type="reset" class="btn btn-danger mb-1">Cancel</button> --}}
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                            <!-- App Link Tab -->
                                                            <div class="tab-pane" id="app_link" role="tabpanel" aria-labelledby="app_link-tab">
                                                                <form id="appLinkForm" method="post" action="updateSettingInfo?param=appLink">
                                                                @csrf
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label for="android_url">Android</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="android_url" name="android_url" class="form-control" placeholder="" value="{{$data['android_url']}}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="ios_url">IOS</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="ios_url" name="ios_url"  class="form-control" placeholder="" aria-invalid="false" value="{{$data['ios_url']}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitForm('appLinkForm','post')">Save Changes</button>
                                                                            {{-- <button type="reset" class="btn btn-danger mb-1">Cancel</button> --}}
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>

                                                             <!-- App Version Tab -->
                                                            <div class="tab-pane" id="app_version" role="tabpanel" aria-labelledby="app_version-tab">
                                                                <form id="appVersionForm" method="post" action="updateSettingInfo?param=appVersion">
                                                                @csrf
                                                                    <div class="row">
                                                                        <div class="col-12 form-group">
                                                                            <label for="android_version">Android (Format-> ["va1","val2","val3"])</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="android_version" name="android_version" class="form-control" placeholder="" value="{{$data['android_version']}}" required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 form-group">
                                                                            <label for="ios_version">IOS (Format-> ["va1","val2","val3"])</label>
                                                                            <div class="controls">
                                                                                <input type="text" id="ios_version" name="ios_version"  class="form-control" placeholder="" aria-invalid="false" value="{{$data['ios_version']}}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                            <button type="button" class="btn btn-success mr-sm-2 mb-1" onclick="submitForm('appVersionForm','post')">Save Changes</button>
                                                                            {{-- <button type="reset" class="btn btn-danger mb-1">Cancel</button> --}}
                                                                        </div>
                                                                    </div>
                                                                </form>
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
                </div>
            </div>
        </section>
    </div>
</div>
<script src="../backend/vendors/ckeditor5/ckeditor.js"></script>
<script>
    $('#privacy-tab').on('click',function(){
        loadCKEditor('privacy_policy_editor');
    });
    $('#about_us-tab').on('click',function(){
        loadCKEditor('about_us_editor');
    });
    $('#terms-tab').on('click',function(){
        loadCKEditor('terms_condition_editor');
    });
    $('#coupons_terms-tab').on('click',function(){
        loadCKEditor('coupons_terms_condition_editor');
    });
    $('#return_policy-tab').on('click',function(){
        loadCKEditor('return_policy_editor');

    });
</script>

@endsection
