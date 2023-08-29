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
                                            <td><strong>{{trans('labels.admin_name')}}</strong></td>
                                            <td>{{$data->admin_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('labels.nick_name')}}</strong></td>
                                            <td>{{$data->nick_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('labels.role')}}</strong></td>
                                            <td>{{$data->role->role_name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('labels.email_id')}}</strong></td>
                                            <td>{{$data->email}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('labels.phone')}}</strong></td>
                                            <td><span><span> {{ $data->phone }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('labels.staff_status')}}</strong></td>
                                            <td>{{displayStatus($data->status)}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>{{trans('labels.date_time')}}</strong></td>
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
