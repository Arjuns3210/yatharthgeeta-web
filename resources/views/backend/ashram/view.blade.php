<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Ashram</h5>
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
                                                        <td><strong>Name</strong></td>
                                                        <td>{{$ashram->name}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Title</strong></td>
                                                        <td>{{$ashram->title}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Location</strong></td>
                                                        <td>{{$ashram->location}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Contact</strong></td>
                                                        <td>{{$ashram->phone}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Image</strong></td>
                                                        <td><img src="{{$media->getFullUrl() ?? ''}}"  width="200px" alt=""></td>
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
