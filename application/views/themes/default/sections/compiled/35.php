<div class="contact-section <?php echo 'global_sec_'.$page_section['global_section_id'] .' '.$page_section['page_section_class'];?> class_py-5">
            <div class="container">
                <?php
                foreach ($blocks as $block) {
                    echo $block['compiled'];
                }
                ?>
                <div class="row form_wrapper">
                    <div class="col-xl-10 col-lg-102 col-md-12 col-sm-12 col-12 ml-auto mr-auto">
                        <?php echo form_open('form/contact_frm', array("autocomplete" => "off", "method" => "POST", "class" => "")); ?>
                        <input type="hidden" name="referrer_url" value="<?php echo $this->session->userdata('REFERRER_URL')?$this->session->userdata('REFERRER_URL'):'';?>"/>
						  <input type="hidden" name="page_name" value="<?php echo isset($page['page_name'])?$page['page_name']:'';?>"/>
						 <input type="hidden" name="page_url" value="<?php echo isset($page['page_uri'])? base_url(). $page['page_uri']:'';?>"/>
                        <input type="hidden" name="form_url" value="<?php echo base_url() .'form/contact_frm';?>"/>
                        <input type="hidden" name="form_type" value="contact_form"/>
                        <div class="row mt-3">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="contact_name">Name*</label>
                                    <input type="text" class="form-control" tabindex="1" name="name" id="contact_name" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="contact_email">Email*</label>
                                    <input type="text" class="form-control" tabindex="3" id="contact_email" name="email" placeholder="">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="contact_phone">Phone*</label>
                                    <input type="text" class="form-control contact_phone" tabindex="2" id="contact_phone" name="phone" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label for="contact_subject">Subject</label>
                                    <input type="text" class="form-control" tabindex="4" name="subject" id="contact_subject" placeholder="">
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="contact_message">How Can I Help?</label>
                                    <textarea class="form-control" id="contact_message" tabindex="5" name="message" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 text-center mt-2">
                                <button type="submit" data-type="contact" class="btn btn-primary frm_submit_btn text-uppercase btn-white btn-animation py-2 border-radius">Submit Contact</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>