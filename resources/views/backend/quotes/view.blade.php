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
                                            <td><strong>Shlok</strong></td>
                                            <td>{{$quotes->shlok ?? ''}}</td>
                                        </tr>                                    
                                        <tr>
                                            <td><strong>Quote Image</strong></td>
                                            <td><img src="{{$media->getFullUrl() ?? ''}}" width="200px" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Quote Sequence</strong></td>
                                            <td>{{$quotes->sequence ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Share Allowance</strong></td>
                                            <td>{{$quotes->share_allowance ?? ''}}</td>
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
