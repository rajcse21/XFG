<style>
    .dropzone{
        min-height: 0px;
        background: #eee;
        border: 2px dashed rgba(0,0,0,0.3);        
    }
    .dropzone .dz-message {   
        margin: 0; 
    }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user">Home</a></li>
        <li class="breadcrumb-item active">Bank Logos</li>       
    </ol>
</nav>

<div class="container-fluid p-5">
    <div class="row">
        <div class="col-md-12">
            <div class="">
                <?php $this->load->view('inc-messages'); ?>

                <div id="my-awesome-dropzone" class="mb-3">
                    <div class="dropzone needsclick dz-clickable drop-zone">	

                        <div class="dz-message needsclick font-weight-bold">
                            <i class="fas fa-upload fa-2x"></i><br/>
                            Choose a file or drag it here.<br>
                        </div>
                        <div class="dz-error"><span data-dz-errormessage></span></div>
                    </div>
                </div>
                <div class="dz-progress" style="display:none;">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>

                <div class="card bg-light">
                    <div class="card-header">Bank Logos</div>
                    <div class="card-body">
                        <div class="row mt-3 bank-logos">
                            <?php
                            if (empty($bank_logos)) {
                                echo '<p class="text-danger text-center">No Record Found.</p>';
                            } else {
                                foreach ($bank_logos as $row) {
                                    ?>
                                    <div class="col-sm-3 bank-logo mt-3" id="bank_logo_<?php echo $row['bank_logo_id']; ?>">
                                        <div class="card border-secondary">
                                            <img src="<?php echo $row['bank_logo']; ?>" height="120" class="card-img-top"/>
                                            <div class="card-img text-right p-2">
                                                <a href="bank_logo/delete/<?php echo $row['bank_logo_id']; ?>" onclick="return confirm('Are you sure you want to delete this image ?');" class="card-link"><i class="far fa-trash-alt fa-lg" data-toggle="tooltip" title="Delete"></i></a>
                                            </div>
                                        </div>                    
                                    </div>                    
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <?php echo $pagination; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>