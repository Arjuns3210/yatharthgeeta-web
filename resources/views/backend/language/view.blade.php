<section class="users-list-wrapper">
	<div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div>
                    <div class="card-content">
                    	<div class="card-body">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <td><strong>Language Name</strong></td>
                                            <td>{{$data->language_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Language Code</strong></td>
                                            <td>{{$data->language_code}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Created At</strong></td>
                                            <td>{{date('d-m-Y H:i A', strtotime($data->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Updated At</strong></td>
                                            <td>{{date('d-m-Y H:i A', strtotime($data->updated_at)) }}</td>
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
</section>
