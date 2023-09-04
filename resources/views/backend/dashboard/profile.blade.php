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
                                    <div class="row">
                                        <div class="col-12 col-sm-7">
                                            <h4 class="card-title">General Info</h4>
                                        </div>
                                        <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                            <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i class="fa fa-arrow-left"></i> Back To Listing</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            	<div class="card-body">
                            		<form method="post" id="profileForm" action="updateProfile">
                                        @csrf
                                        <div class="row">
                                            <dl class="col-sm-4">
                                                <label>Email</label>
                                                <dd class="form-control" readonly>{{ $data->email }}</dd>
                                            </dl>
                                            <div class="col-md-4">
                                                <label>Name<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="admin_name" value="{{$data->admin_name}}"><br/>
                                            </div>
                                            <dl class="col-sm-4">
                                                <label>Nick Name</label>
                                                <dd class="form-control" readonly>{{ $data->nick_name }}</dd>
                                            </dl>
                                            <dl class="col-sm-4">
                                                <label>Role</label>
                                                <dd class="form-control" readonly>{{ $data->role->role_name }}</dd>
                                            </dl>
                                            <div class="col-md-4">
                                                <label>Contact Number<span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="phone" value="{{$data->phone}}"><br/>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="pull-left">
                                                    @if ($message = Session::get('success'))
                                                        <div class="successAlert alert text-success">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success" onclick="submitForm('profileForm','post')">Update</button>
                                                    <!-- <button type="submit" class="btn btn-success btn-sm">Update Info</button> -->
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
        </section>
    </div>
</div>
@endsection