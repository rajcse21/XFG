<div class="container pb-4 pb-md-5">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12 offset-xl-2 offset-lg-2">
                    <h3 class="orange-hr my-2 my-sm-4">FILL IN THE FORM BELOW</h3>
                    <?php echo form_open('form/contact_frm', array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>
                    <input type="hidden" name="referrer_url" value=""/>
                    <input type="hidden" name="form_url" value=""/>
                    <input type="hidden" name="form_type" value="contact_form"/>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="edl-label" for="contact_frm_name">Your Full Name</label>
                                <input type="text" name="name" class="form-control" id="contact_frm_name" value="" placeholder="">
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="edl-label" for="contact_frm_email">Your Email Address</label>
                                <input type="text" name="email" class="form-control" id="contact_frm_email" value="" placeholder="">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="edl-label" for="contact_frm_phone">Your Contact Number</label>
                                <input type="text" name="phone" id="contact_frm_phone" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="edl-label" for="contact_frm_subject">Subject</label>
                                <input type="text" name="subject" id="contact_frm_subject" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="form-group">
                                <label class="edl-label" for="contact_frm_message">Message</label>
                                <textarea name="message" class="form-control" id="contact_frm_message" rows="3" placeholder=""></textarea>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                            <p><button type="submit" data-type="contact_frm" class="btn btn-primary btn-animation frm_submit_btn btn-blue font-semi-bold px-5 py-2 text-uppercase">Submit</button></p>
                        </div>
                    </div>
                    <?php echo form_close(); ?>	
                </div>
            </div>
        </div>