<?php

class Pagemodel extends CI_Model {

    function getNode($node_type, $alias, $lang = 'en') {
        $page = array();

        $this->db->from('page_i18n');
        $this->db->join('page', 'page.page_id = page_i18n.page_id');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id', 'LEFT');
        $this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
        $this->db->where('page_uri', $alias);
        $this->db->order_by('page_added_on', 'DESC');
        $this->db->where('language_code', $lang);
        $this->db->where('page_status', 'Publish');
        $this->db->where('node_type', $node_type);
        $this->db->limit(1);
        $rs = $this->db->get();
        if ($rs->num_rows() == 1) {
            $page = $rs->row_array();

            $additional_fields = $this->getPageFieldData($page['page_i18n_id'], $page['content_type_id']);
            foreach ($additional_fields as $key => $field) {
                $page['additional_fields'][$key] = $field;
            }
            return $page;
        }
        return false;
    }

    function getCMSPage($alias, $lang = 'en') {
        return $this->getNode(1, $alias, $lang);
    }

    function getTextNode($alias, $lang = 'en') {
        return $this->getNode(2, $alias, $lang);
    }

    function getWYSIWYGNode($alias, $lang = 'en') {
        return $this->getNode(3, $alias, $lang);
    }

    function getPageModuleSettings($page_id, $module_name) {

        $this->db->where('page_id', $page_id);
        $this->db->where('module_name', $module_name);
        $rs = $this->db->get('page_module_data');
        if ($rs && $rs->num_rows() > 0) {
            $module = new stdClass;
            $module->module_name = $module_name;
            foreach ($rs->result_array() as $row) {
                $module->$row['page_setting'] = $row['page_setting_value'];
            }

            return $module;
        }
        return FALSE;
    }

    function fetchBlockByAlias($page_id, $alias, $section_alias = FALSE) {
        if ($section_alias) {
            $section = $this->fetchSectionById($page_id, $section_id);
            $this->db->where('page_section_id', $section['page_section_id']);
        }
        $this->db->where('page_i18n_id', $page_id);
        $this->db->where('block_is_active', 1);
        $this->db->where('block_alias', $alias);
        $rs = $this->db->get('page_block');

        if ($rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    function fetchBlocksBySectionId($section_id) {
        $this->db->where('page_section_id', $section_id);
        $this->db->where('block_is_active', 1);
        $this->db->order_by('block_sort_order', 'ASC');
        $rs = $this->db->get('page_block');
        return $rs->result_array();
    }

    function fetchSectionById($page_i18n_id, $section_id) {
        $this->db->from('page_section');
        $this->db->join('global_section', 'global_section.global_section_id = page_section.global_section_id', 'LEFT');
        if (!defined('ADMIN') || !ADMIN) {
            $this->db->where('page_section_is_active', 1);
        }
        $this->db->where('page_i18n_id', $page_i18n_id);
        $this->db->where('page_section_id', $section_id);
        $rs = $this->db->get();

        if ($rs->num_rows() == 1) {
            $section_ids = array();
            $sections = array();
            $all_sections = array();
            foreach ($rs->result_array() as $row) {
                $section_ids[] = $row['page_section_id'];
                $sections[] = $row;
            }

            //Fetch All Blocks
            $section_blocks = $this->fetchblocksbySections($section_ids);

            if ($sections) {
                foreach ($sections as $row) {
                    $tmp = $row;
                    if (isset($section_blocks[$row['page_section_id']])) {
                        $tmp['blocks'] = $section_blocks[$row['page_section_id']];
                    }
                    $all_sections[] = $tmp;
                }
            }
            return $all_sections;
        }
        return false;
    }

    function fetchblocksbySections($section_ids) {
        $section_blocks = array();
        $this->db->from('page_block');
        $this->db->join('global_block', 'global_block.global_block_id = page_block.page_global_block_id', 'LEFT');
        $this->db->where_in('page_section_id', $section_ids);
        $this->db->where('page_block_is_active', 1);
        $this->db->order_by('page_block_sort_order', 'ASC');
        $blocks_rs = $this->db->get();
        if ($blocks_rs && $blocks_rs->num_rows() > 0) {
            foreach ($blocks_rs->result_array() as $block) {
                $section_blocks[$block['page_section_id']][] = $block;
            }
            return $section_blocks;
        }
        return false;
    }

    function fetchSectionByAlias($page_i18n_id, $section_alias) {
        $this->db->join('global_section', 'global_section.global_section_id = page_section.global_section_id', 'LEFT');
        $this->db->where('page_i18n_id', $page_i18n_id);
        if (!defined('ADMIN') || !ADMIN) {
            $this->db->where('page_section_is_active', 1);
        }
        $this->db->where('page_section_alias', $section_alias);
        $rs = $this->db->get('page_section');


        $section = $rs->row_array();
        $section_ids = array();


        $section_ids[] = $section['page_section_id'];

        //Fetch All Blocks
        $section_blocks = $this->fetchblocksbySections($section_ids);

        if (isset($section_blocks[$section['page_section_id']])) {
            $section['blocks'] = $section_blocks[$section['page_section_id']];
        }
        return $section;

        return false;
    }

    function fetchChildSections($content_section_id) {
        $this->db->where('parent_id', $content_section_id);
        $this->db->order_by('page_section_sort_order', 'ASC');
        $rs = $this->db->get('page_section');
        return $rs->result_array();
    }

    function fetchSections($page_i18n_id) {
        $this->db->where('page_section_is_active', 1);
        $this->db->where('page_i18n_id', $page_i18n_id);
        $this->db->order_by('page_section_sort_order', 'ASC');
        $rs = $this->db->get('page_section');
        if ($rs && $rs->num_rows() > 0) {
            return $rs->result_array();
        }
        return FALSE;
    }

    function getfeaturedClasses() {
        $this->db->where('is_featured', '1');
        $this->db->limit(4);
        $rs = $this->db->get('class');
        return $rs->result_array();
    }

    function allclassesByPrograms() {
        $this->db->select("class.*, GROUP_CONCAT(ar_program.program_alias SEPARATOR ' ') AS program_aliases");
        $this->db->from('class');
        $this->db->join('class_programs', 'class.class_id = class_programs.class_id');
        $this->db->join('program', 'class_programs.program_id = program.program_id');
        $this->db->group_by('class.class_id');
        $rs = $this->db->get();
        return $rs->result_array();
    }

    function getAllPages($node_type, $content_type_alias, $lang = 'en', $params = false) {
        $page = array();
        //$this->db->select("page_i18n.page_i18n_id,page_i18n.page_uri");
        $this->db->from('page_i18n');
        $this->db->join('page', 'page.page_id = page_i18n.page_id');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id', 'LEFT');
        $this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
        //$this->db->join('page_section', 'page_section.page_i18n_id = page_i18n.page_i18n_id');
        $this->db->where('language_code', $lang);
        $this->db->where('page_status', 'Publish');
        //$this->db->where('active', 1);
        $this->db->where('node_type', $node_type);
        $this->db->where('content_type.content_type_alias', $content_type_alias);
        if (isset($params['limit'])) {
            $this->db->limit($params['limit']);
        }
        if (isset($params['sort'])) {
            $this->db->order_by('page_sort_order', $params['sort']);
        } else {
            $this->db->order_by('page_sort_order', 'ASC');
        }
        $rs = $this->db->get();
        $output = array();
        if ($rs && $rs->num_rows() > 0) {
            if (isset($params['limit']) == 1) {

                $page = $rs->row_array();

                $additional_fields = $this->getPageFieldData($page['page_i18n_id'], $page['content_type_id']);
                foreach ($additional_fields as $key => $field) {
                    //$page['additional_fields'][$key] = $field;
                    $page['additional_fields'][$key] = $field;
                }
                return $page;
            }
            foreach ($rs->result_array() as $row) {
                $page = $row;

                $additional_fields = $this->getPageFieldData($page['page_i18n_id'], $page['content_type_id']);
                foreach ($additional_fields as $key => $field) {
                    //$page['additional_fields'][$key] = $field;
                    $page['additional_fields'][$key] = $field;
                }

                $pages[] = $page;
            }
            return $pages;
        }
        return FALSE;
    }

    //Function get additional fields data
    function getPageFieldData($page_i18n_id, $content_type_id) {
        $output = array();
        $content_fields = $this->getContentFields($content_type_id);
        if (!$content_fields) {
            return $output;
        }
        $this->db->select('*');
        $this->db->from('page_field_data');
        $this->db->join('content_field', 'content_field.content_field_id = page_field_data.content_field_id');
        $this->db->where('page_i18n_id', $page_i18n_id);
        $rs = $this->db->get();


        foreach ($content_fields as $content_field) {
            $output[$content_field['field_alias']] = '';
            foreach ($rs->result_array() as $row) {
                $output[$row['field_alias']] = $row['field_contents'];
            }
        }

        return $output;
    }

    //Function contentFields
    function getContentFields($content_type_id) {
        $this->db->where('content_type_id', $content_type_id);
        $rs = $this->db->get('content_field');
        if ($rs->num_rows() > 0) {
            return $rs->result_array();
        }return false;
    }

    function getAllContentPages($node_type, $content_type_id, $lang = 'en') {
        $page = array();

        $this->db->from('page_i18n');
        $this->db->join('page', 'page.page_id = page_i18n.page_id');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id', 'LEFT');
        $this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
        $this->db->where('language_code', $lang);
        $this->db->where('page_status', 'Publish');
        //$this->db->where('active', 1);
        $this->db->where('node_type', $node_type);
        $this->db->where('page.content_type_id', $content_type_id);
        $this->db->order_by('page_sort_order', 'ASC');
        $rs = $this->db->get();
        $output = array();
        if ($rs && $rs->num_rows() > 0) {
            return $rs->result_array();
        }
        return FALSE;
    }

    function fetchAllBlocks($section_id) {
        $this->db->where('page_section_id', $section_id);
        $this->db->where('page_block_enable', 1);
        $rs = $this->db->get('page_block');
        if ($rs && $rs->num_rows() > 0) {
            return $rs->result_array();
        }
        return FALSE;
    }

    function pageContentType($node_type, $alias, $lang = 'en') {
        $page = array();

        $this->db->from('page_i18n');
        $this->db->join('page', 'page.page_id = page_i18n.page_id');
        $this->db->join('page_template', 'page_template.page_template_id = page_i18n.page_template_id', 'LEFT');
        $this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
        $this->db->where('page_uri', $alias);
        $this->db->order_by('page_added_on', 'DESC');
        $this->db->where('language_code', $lang);
        $this->db->where('page_status', 'Publish');
        $this->db->where('active', 1);
        $this->db->where('node_type', $node_type);
        $this->db->limit(1);
        $rs = $this->db->get();

        //echo $this->db->last_query();
        if ($rs->num_rows() == 1) {
            $page = $rs->row_array();

            $additional_fields = $this->getPageFieldData($page['page_i18n_id'], $page['content_type_id']);
            foreach ($additional_fields as $key => $field) {
                $page['additional_fields'][$key] = $field;
            }
            return $page;
        }
        return FALSE;
    }

    /* function fetchBlockById($block_id){
      $this->db->where('page_block_id',$block_id);
      $rs = $this->db->get('page_block');
      if($rs && $rs->num_rows() == 1){
      return $rs->row_array();
      }
      return FALSE;
      } */
}

?>