<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Category</h5>
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
                                                    @foreach($category['translations'] as $key => $data)
                                                    <tr>
                                                        <td><strong>Name ({{ ucfirst($data['locale']) }})</strong></td>
                                                        <td>{{ $data['name'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Title</strong></td>
                                                        <td>{{ $data['title'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Subtitle</strong></td>
                                                        <td>{{ $data['subtitle'] }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Description</strong></td>
                                                        <td>{{ $data['description'] }}</td>
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
