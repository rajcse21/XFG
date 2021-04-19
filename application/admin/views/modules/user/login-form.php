<div class="row justify-content-center">
    <div class="col-md-6">        
             <div class="card mx-4">
                <div class="card-body p-4">
                    <?php echo form_open('welcome/login', array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>
                    <h1>Login</h1>
                    <p class="text-muted">Sign In to your account</p>
                    <?php if (form_error('login')) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?php echo form_error('login', '<span>', '</span>'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-user"></i>
                            </span>
                        </div>
                        <input name="email" type="text" class="form-control <?php echo (form_error('email')) ? "is-invalid" : ""; ?>" id="email" value="<?php echo set_value('email') ?>"  />
                    </div>
                    <?php echo form_error('email'); ?>
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="icon-lock"></i>
                            </span>
                        </div>
                        <input name="passwd" type="password" class="form-control <?php echo (form_error('passwd')) ? "is-invalid" : ""; ?>" id="passwd" required />
                    </div>
                    <?php echo form_error('passwd'); ?>
                    <div class="row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary px-4">Login</button>
                            <input name="login" type="hidden" value="1" required />
                        </div>
                        <div class="col-6 text-right">
                            <a href="user/lostpasswd" class="btn btn-link px-0">Forgot password?</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
           
    </div>
</div>