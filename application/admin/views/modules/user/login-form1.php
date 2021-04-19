<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-3">&nbsp;</div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login</div>

                <div class="card-body">
                    <?php echo form_open('welcome/login', array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>

                    <?php if (form_error('login')) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo form_error('login', '<span>', '</span>'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>

                    <div class="form-group">
                        <label for="email">Username *</label>
                        <input name="email" type="text" class="form-control <?php echo (form_error('email')) ? "is-invalid" : ""; ?>" id="email" value="<?php echo set_value('email') ?>"  />
                        <?php echo form_error('email'); ?>
                    </div>
                    <div class="form-group">
                        <label for="passwd">Password *</label>
                        <input name="passwd" type="password" class="form-control <?php echo (form_error('passwd')) ? "is-invalid" : ""; ?>" id="passwd" required />
                        <?php echo form_error('passwd'); ?>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <input name="login" type="hidden" value="1" required />
                    </div>
                    <?php echo form_close(); ?>
                </div>

                <div class="card-footer text-right">
                    <a href="user/lostpasswd">Forgot password?</a><br />					
                </div>
            </div>
        </div>
        <div class="col-md-3">&nbsp;</div>
    </div>
</div>