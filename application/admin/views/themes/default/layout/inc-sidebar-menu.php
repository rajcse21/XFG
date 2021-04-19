<?php
if (!$this->userauth->checkAuth()) {
    return;
}
//Get page type
$rs = $this->db->get('content_type');
$content_types = array();
$content_types = $rs->result_array();
if (!isset($active_menu)) {
    $active_menu = '';
}
?>
<div class="sidebar" id="accordion">
    <ul class="nav flex-column">
        <li>
            <a href="javascript:void(0);" class="nav-link nav-title <?php echo $active_menu == 'content' ? '' : 'collapsed'; ?>" data-toggle="collapse" data-target="#content" aria-expanded="<?php echo $active_menu == 'content' ? true : false; ?>" aria-controls="content">Content<i class="fas fa-angle-down ml-2"></i></a>
            <ul class="nav collapse <?php echo $active_menu == 'content' ? 'show' : ''; ?>" id="content" aria-labelledby="content" data-parent="#accordion">
                <?php foreach ($content_types as $type) { ?>
                    <li class="nav-item"><a class="nav-link"  href="cms/page/index/<?php echo $type['content_type_id']; ?>"><?php echo $type['content_type_name']; ?></a></li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="cms/menu">Menus</a>
                </li>				
                <li class="nav-item">
                    <a class="nav-link" href="bank-logo">Bank Logos</a>
                </li>				
            </ul>
        </li>		
        <li>
            <a href="javascript:void(0);" class="nav-link nav-title <?php echo $active_menu == 'cn_structure' ? '' : 'collapsed'; ?>" data-toggle="collapse" data-target="#cn_structure" aria-expanded="<?php echo $active_menu == 'cn_structure' ? true : false; ?>" aria-controls="cn_structure">Content Structure<i class="fas fa-angle-down ml-2"></i></a>
            <ul class="nav collapse <?php echo $active_menu == 'cn_structure' ? 'show' : ''; ?>" id="cn_structure" aria-labelledby="cn_structure" data-parent="#accordion">
                <li class="nav-item">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="cms/globalsection">Global Section</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cms/globalblock">Global Block</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cms/template">Templates</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="content_type/content_type">Content Type</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0);" class="nav-link nav-title <?php echo $active_menu == 'misc' ? '' : 'collapsed'; ?>" data-toggle="collapse" data-target="#misc" aria-expanded="<?php echo $active_menu == 'misc' ? true : false; ?>" aria-controls="misc">Misc<i class="fas fa-angle-down ml-2"></i></a>
            <ul class="nav collapse <?php echo $active_menu == 'misc' ? 'show' : ''; ?>" id="misc" aria-labelledby="misc" data-parent="#accordion">
                <li class="nav-item">
                    <a class="nav-link" href="form">Form Entries</a>
                </li>	
                <li class="nav-item">
                    <a class="nav-link" href="setting/settings">Settings</a>
                </li>
            </ul>
        </li>
    </ul>



</div>