<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="user">Home</a></li>
        <li class="breadcrumb-item active">Templates</li>
        <li class="ml-auto">
            <a href="cms/template/add" class="btn btn-dark btn-sm"><i class="fas fa-plus"></i> Add Template</a>
        </li>
    </ol>
</nav>

<div class="container-fluid my-5">
    <div class="row">
        <div class="col-md-12">
            <div class="p-3">
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr class="d-flex">
                            <th scope="col" class="col-9">Templates</th>
                            <th scope="col" class="col-3">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($templates as $row) { ?>
                            <tr class="d-flex">
                                <td class="col-9"><?php echo $row['template_name']; ?></td>
                                <td class="col-1"><a href="cms/template/edit/<?php echo $row['page_template_id']; ?>"><i class="far fa-edit fa-lg" data-toggle="tooltip" title="Edit"></i></a></td>
                                <td class="col-1"><a href="cms/template/delete/<?php echo $row['page_template_id']; ?>" data-toggle="confirmation" onClick='return confirm("Are you sure you want to delete this?");'><i class="far fa-trash-alt fa-lg" data-toggle="tooltip" title="Delete"></i></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php echo $pagination; ?>
            </div>
        </div>
    </div>
</div>