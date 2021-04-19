<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
    <li class="breadcrumb-item active">Settings</li>	
</ol>
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Edit Config Settings</div>
                <div class="card-body">
                    <?php $this->load->view('inc-messages'); ?>
                    <ul class="nav nav-tabs">
                        <?php
                        $i = 0;
                        $total_groups = count($groups);
                        foreach ($groups as $group) {
                            $i++;
                            $class = '';
                            if ($i == 1) {
                                $class = 'active';
                            }
                            if (isset($settings[$group['config_group_id']])) {
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $class; ?>" href="#tabs-<?php echo $i; ?>" aria-controls="<?php echo $group['config_group']; ?>" role="tab" data-toggle="tab"><?php echo $group['config_group']; ?></a>
                                </li>			
                                <?php
                            }
                        }
                        ?>
                        
                    </ul>
                    <?php echo form_open("setting/settings/index/{$group_id}"); ?>

                    <div class="tab-content">
                        <?php
                        $i = 0;
                        foreach ($groups as $group) {
                            $i++;
                            $class = '';
                            if ($i == 1) {
                                $class = 'active';
                            }
                            if (isset($settings[$group['config_group_id']])) {
                                ?>

                                <div role="tabpanel" class="tab-pane <?php echo $class; ?>" id="tabs-<?php echo $i; ?>">
                                    &nbsp;
                                    <?php
                                    foreach ($settings[$group['config_group_id']] as $row) {

                                        $key = $row['config_key'];
                                        $label = $row['config_label'];
                                        $val = $row['config_value'];
                                        $field_type = $row['config_field_type'];
                                        $field_options = $row['config_field_options'];
                                        $comment = $row['config_comments'];
                                        ?>
                                        <div class="form-group">
                                            <label for="block_name" class="control-label" ><?php echo $label; ?><?php if ($comment) { ?> <a href="javascript:void(o)" data-toggle="modal" data-target="#myModal_<?php echo $key; ?>"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></a><?php } ?></label>
                                            <?php include("settings/$field_type.php"); ?>
                                        </div>
                                        <?php if ($comment) { ?>
                                            <div class="modal fade" id="myModal_<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel"><?php echo $label; ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?php echo $comment; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?> 
                                    <?php } ?> 
                                </div>
                                <?php
                            }
                        }
                        ?>
                       
                            
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-default btn-primary">Submit</button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>