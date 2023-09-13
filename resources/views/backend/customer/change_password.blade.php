
<div class="main-content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <section class="users-list-wrapper">
        	<div class="users-list-table">
                <div class="row">
                    <div class="col-12">
                        <form method="post" id="changePwdForm" action="customer/changePassword?id={{$customer['id']}}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <label>New Password<span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="new_password">
                                </div>
                                <div class="col-md-6">
                                    <label>Confirm Password<span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="confirm_password">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                    <button type="button" class="btn btn-success" onclick="submitForm('changePwdForm','post')">Reset Password</button>
                                        <!-- <button type="submit" class="btn btn-success btn-sm">Reset Password</button> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>