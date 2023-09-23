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
                                                <h5 class="pt-2">Manage Audio Episode : {{$data['audio']->title ?? ''}} ( {{$data['audio']->language->name ?? ''}} )</h5>
                                            </div>
                                            <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                                <button class="btn btn-sm btn-outline-danger px-3 py-1 mr-2" id="listing-filter-toggle"><i class="fa fa-filter"></i> Filter</button>
                                                @if($data['audio_episode_add'])
                                                    <a href="{{'audio_episode/add/'.$data['audio']->id}}" class="btn btn-sm btn-outline-primary px-3 py-1 src_data"><i class="fa fa-plus"></i> Add</a>
                                                @endif
                                                <a href="audios" class="btn btn-sm btn-secondary px-3 py-1 ml-2"><i class="fa fa-arrow-left"></i> Back</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-2" id="listing-filter-data" style="display: none;">
                                            <div class="col-md-4">
                                                <label>Status</label>
                                                <select class="form-control mb-3" type="text" id="search_status" name="search_status">
                                                    <option value="">All</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>&nbsp;</label><br/>
                                                <input class="form-control mb-3" type="hidden" id="search_audio_id" name="search_audio_id" value="{{$data['audio_id']}}">
                                                <input class="btn btn-md btn-primary px-3 py-1 mb-3" id="clear-form-data" type="reset" value="Clear Search">
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped datatable" id="dataTable" width="100%" cellspacing="0" data-url="audio_episode/fetch">
                                                <thead>
                                                <tr>
                                                    <th class="sorting_disabled" id="id" data-orderable="false" data-searchable="false">Id</th>
                                                    <th id="chapter_name{{\App::getLocale()}}" data-orderable="false" data-searchable="false">Chapter Name ({{ config('translatable.locales_name')[\App::getLocale()] }})</th>
                                                    <th id="chapter_number{{\App::getLocale()}}" data-orderable="false" data-searchable="false">Chapter Number ({{ config('translatable.locales_name')[\App::getLocale()] }})</th>
                                                    <th id="duration" data-orderable="false" data-searchable="false">Duration (In Minute)</th>
{{--                                                    <th id="chapter" data-orderable="false" data-searchable="false">Chapter</th>--}}
{{--                                                    <th id="verses" data-orderable="false" data-searchable="false">Verses</th>--}}
                                                    @if($data['audio_episode_status'] || $data['audio_episode_edit'] || $data['audio_episode_view'] || $data['audio_episode_delete'])
                                                        <th id="action" data-orderable="false" data-searchable="false" width="130px">Action</th>
                                                    @endif
                                                </tr>
                                                </thead>
                                            </table>
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
@endsection
