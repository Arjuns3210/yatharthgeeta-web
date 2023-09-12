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
                                            <td><strong>Admin Name</strong></td>
                                            <td>{{$customer->name}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Email</strong></td>
                                            <td>{{$customer->email}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Phone</strong></td>
                                            <td>{{$customer->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Whatsapp No.</strong></td>
                                            <td>{{$customer->whatsapp_no}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Gneder</strong></td>
                                            <td><span><span> {{ $customer->gender == 'M' ? 'Male' : ($customer->gender == 'F' ? 'Female' : 'Others') }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Staff Status</strong></td>
                                            <td>{{displayStatus($customer->status)}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Added At</strong></td>
                                            <td>{{date('d-m-Y H:i A', strtotime($customer->updated_at)) }}</td>
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
