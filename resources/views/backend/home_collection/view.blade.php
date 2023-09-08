<section class="users-list-wrapper">
    <div class="users-list-table">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-12 col-sm-7">
                                    <h5 class="pt-2">View Collection</h5>
                                </div>
                                <div class="col-12 col-sm-5 d-flex justify-content-end align-items-center">
                                    <a href="{{URL::previous()}}" class="btn btn-sm btn-primary px-3 py-1"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <tr>
                                                <td><strong>Collection Type</strong></td>
                                                <td>{{$collection->type ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Collection Title</strong></td>
                                                <td>{{$collection->title ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Short Description</strong></td>
                                                <td>{{$collection->description ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Sequence</strong></td>
                                                <td>{{$collection->sequence ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Display In Column</strong></td>
                                                <td>{{$collection->display_in_column ?? ''}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Is Scrollable</strong></td>
                                                <td>{{$collection->is_scrollable ? 'Yes':'No'}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Collection Status</strong></td>
                                                <td>{{($collection->status) ? 'Active' : 'In-Active'}}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Date Time</strong></td>
                                                <td>{{\Carbon\Carbon::parse($collection->created_at)->format('d-m-Y')}}</td>
                                            </tr>
                                            @if(!empty($singleImage))
                                                <tr>
                                                    <td><strong>Collection Image</strong></td>
                                                    @if(!empty($singleImage))
                                                        <td><img src="{{$singleImage->getFullUrl() ?? ''}}" alt="" width="80px"></td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                </tr>
                                            @endif
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
</section>
