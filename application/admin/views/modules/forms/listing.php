<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user">Home</a></li>
        <li class="breadcrumb-item active">Form Entries</li>
    </ol>
</nav>
<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="p-3">
                <?php $this->load->view('inc-messages'); ?>
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr class="d-flex">
                            <th scope="col" class="col-4">Name</th>
                            <th scope="col" class="col-4">Submission Date</th>
                            <th scope="col" class="col-4">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($forms) {
                            foreach ($forms as $item) {
                                ?>
                                <tr class="d-flex">
                                    <td class="col-4"><?php echo $item['name']; ?></td>
                                    <td class="col-4"><?php echo date('d-m-Y', $item['submitted_on']); ?></td>
                                    <td class="col-4 text-right">
                                        <a class="btn btn-secondary btn-sm" href="form/details/<?php echo $item['form_entry_id']; ?>" >Details</a>
                                    </td>

                                </tr>
                            <?php }
                        }
                        ?>
                    </tbody>
                </table>
<?php echo $pagination; ?>
            </div>
        </div>
    </div>
</div>