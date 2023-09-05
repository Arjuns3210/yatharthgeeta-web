<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Book</h5>
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
                                                    @foreach($books['translations'] as $key => $data)
                                                    <tr>
                                                        <td><strong>Name ({{ ucfirst($data['locale']) }})</strong></td>
                                                        <td>{{ $data['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Description</strong></td>
                                                        <td>{{ $data['description'] }}</td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td><strong>Link</strong></td>
                                                        <td>{{ $books['link'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Cover Image </strong></td>
                                                        <td><img src="{{$media->getFullUrl() ?? ''}}" width="200px" height="200px" alt=""></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Number of Pages</strong></td>
                                                        <td>{{ $books['pages'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sequence</strong></td>
                                                        <td>{{ $books->sequence ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Status</strong></td>
                                                        <td>{{$data->status==1 ? 'Enable':'Disable'}}</td>
                                                    </tr>

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

