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
                                            <td><strong>Title</strong></td>
                                            <td>{{$banners->title ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Cover</strong></td>
                                            <td><img src="{{$media->getFullUrl() ?? ''}}" alt=""></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Sequence</strong></td>
                                            <td>{{$banners->sequence ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status</strong></td>
                                            <td>{{$banners->status ?? ''}}</td>
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
