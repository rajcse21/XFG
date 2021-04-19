<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pagemodel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function fetchById($pid) {
        $this->db->from('page_i18n');
        $this->db->join('page', 'page_i18n.page_id = page.page_id');
        $this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id', 'left');
        $this->db->where('page_i18n.page_i18n_id', intval($pid));
        $rs = $this->db->get();
        if ($rs && $rs->num_rows() == 1) {
            return $rs->row_array();
        }
        return FALSE;
    }

    function getadditionalTab() {
        $field_tab = array(
            'additional_tab' => 'Additional Tab',
            'main_tab' => 'Main Tab',
            'link_tab' => 'Link Tab',
            'layout_tab' => 'Layout Tab',
            'image_tab' => 'Images Tab',
            'template_tab' => 'Template Tab',
            'misc_tab' => 'Misc Tab'
        );
        return $field_tab;
    }

    //Function get page fields
    function getPageFields($content_id) {
        $this->db->from('page_template_data');
        $this->db->join('page_template_field', 'page_template_field.template_field_id = page_template_data.template_field_id');
        $this->db->where('page_id', $content_id);
        $rs = $this->db->get();

        return $rs->result_array();
    }

    //Function get additional fields data
    function getPageFieldData($page_i18n_id, $content_type_id) {
        $content_fields = $this->getContentFields($content_type_id);
        $this->db->select('*');
        $this->db->from('page_field_data');
        $this->db->join('content_field', 'content_field.content_field_id = page_field_data.content_field_id');
        $this->db->where('page_i18n_id', $page_i18n_id);
        $rs = $this->db->get();
        $output = array();

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
        return $rs->result_array();
    }

    function details($pid) {
        $this->db->from('page_i18n');
        $this->db->join('page', 'page_i18n.page_id = page.page_id');
        $this->db->join('content_type', 'content_type.content_type_id = page.content_type_id');
        $this->db->join('page_template', 'page_template.page_template_id = page.page_template_id', 'left');
        $this->db->where('page_i18n.page_i18n_id', intval($pid));
        $rs = $this->db->get();
        if ($rs && $rs->num_rows() == 1) {
            $page = $rs->row_array();

            $fields = array();
            $fields = $this->getPageFields($page['page_id']);
            if (!empty($fields)) {
                foreach ($fields as $field) {
                    $page[$field['template_field_alias']] = $field['template_field_contents'];
                }
            }

            $additional_fields = $this->getPageFieldData($page['page_i18n_id'], $page['content_type_id']);
            foreach ($additional_fields as $key => $field) {
                $page['additional_fields'][$key] = $field;
            }
            return $page;
        }
        return FALSE;
    }

    function indexPage($id, $update = false) {
        return;
        $data = $this->details($id);

        $image = "";
        $excerpt = $data['meta_description'];
        $type = $data['content_type_alias'];
        $url = $this->config->item('site_url') . $data['page_uri'];

        if ($data['page_status'] != 'Publish') {
            $this->Lucenemodel->removeFromIndex("$type-{$data['page_i18n_id']}");
            return;
        }
        $html = $this->_loadHtmlContent($url);

        $contents = array();
        $contents['docid'] = "$type-{$data['page_i18n_id']}";
        $contents['type'] = $type;
        $contents['type_id'] = $data['page_i18n_id'];
        $contents['url'] = $url;
        $contents['title'] = $data['page_title'];
        $contents['excerpt'] = $excerpt;
        $contents['image'] = $image;
        $contents['contents'] = $html;
        $contents['timestamp'] = ($data['page_updated_on']) ? $data['page_updated_on'] : $data['page_added_on'];

        if ($update) {
            $this->Lucenemodel->removeFromIndex($contents['docid']);
        }
        $this->Lucenemodel->addToIndex($contents);
        $this->Lucenemodel->optimize();
    }

    function _loadHtmlContent($url) {
        //Load Page Content
        $html = '';
        $html_content = file_get_contents($url);

        //Create DOM Document and fetch crawlable sections
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;

        $internalErrors = libxml_use_internal_errors(true);
        $doc->loadHTML($html_content);
        libxml_use_internal_errors($internalErrors);

        //use DomXPath to find the table element with your class name
        $xpath = new DomXPath($doc);
        $classname = 'lucene_crawl';
        $xpath_results = $xpath->query("//div[contains(@class, '$classname')]");
        if ($div = $xpath_results->item(0)) {
            $html .= strip_tags($doc->saveHTML($div), '<p><a>') . "\r\n";
            return trim($html);
        }
        return false;
    }

    //Count All Records
    function countAll() {
        $this->db->where('page_i18n.page_status <>', 'Temp');
        $this->db->from('page');
        return $this->db->count_all_results();
    }

    //List All Records
    function listAll($content_type_id) {
        $this->db->from('page_i18n');
        $this->db->join('page', 'page_i18n.page_id = page.page_id');
        $this->db->where('page_i18n.page_status <>', 'Temp');
        $this->db->where('content_type_id', $content_type_id);
        $this->db->where('page_i18n.language_code', config_item('DEFAULT_LANG'));
        $this->db->order_by('page_sort_order', 'ASC');
        $rs = $this->db->get();

        return $rs->result_array();
    }

    function addTempPage($content_type_id, $lang) {
        $user_id = $this->session->userdata('ADMIN_USER_ID');

        $this->db->trans_start();

        $data = array();
        $data['parent_id'] = 0;
        $data['content_type_id'] = $content_type_id;
        $data['page_template_id'] = 0;
        $data['page_name'] = '';
        $data['page_level'] = 0;
        $data['page_path'] = 0;
        $data['page_sort_order'] = 0;
        $status = $this->db->insert('page', $data);
        if ($status) {
            $page_id = $this->db->insert_id();
        }

        //Add page_i18n
        $page_i18n = array();
        $page_i18n['page_id'] = $page_id;
        $page_i18n['language_code'] = $lang;
        $page_i18n['page_title'] = '';
        $page_i18n['page_uri'] = '';
        $page_i18n['browser_title'] = '';
        $page_i18n['include_in_site_map'] = 0;
        $page_i18n['meta_keywords'] = '';
        $page_i18n['meta_description'] = '';
        $page_i18n['before_head_close'] = '';
        $page_i18n['before_body_close'] = '';
        $page_i18n['page_status'] = 'Temp';
        $page_i18n['page_added_by'] = $user_id;
        $page_i18n['page_added_on'] = time();
        $page_i18n_status = $this->db->insert('page_i18n', $page_i18n);
        if ($page_i18n_status) {
            $page_i18n_id = $this->db->insert_id();
        }


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            return false;
        }

        return $this->fetchById($page_i18n_id);
    }

    function insertRecord($content_type, $additional_fields = array(), $additional_tabs = array()) {
        $data = array();

        $parent = false;
        if ($this->input->post('parent_id', true) > 0) {
            $parent = $this->fetchById($this->input->post('parent_id', true));
        }
        echo '<pre>';
        $data['parent_id'] = $this->input->post('parent_id', TRUE);
        $data['content_type_id'] = $content_type['content_type_id'];
        if ($this->input->post('page_template_id', TRUE)) {
            $data['page_template_id'] = $this->input->post('page_template_id', TRUE);
        }
        $data['page_name'] = $this->input->post('page_name', TRUE);
        if (!$parent) {
            $data['page_level'] = 0;
            $data['page_path'] = 0;
        } else {
            $data['page_level'] = $parent['page_level'] + 1;
            $data['page_path'] = $parent['page_path'] . '.' . $this->input->post('parent_id', true);
        }
        $data['page_sort_order'] = $this->getSortOrder($this->input->post('parent_id', TRUE));

        $status = $this->db->insert('page', $data);
        if (!$status) {
            return FALSE;
        }
        $page_id = $this->db->insert_id();

        $page_i18n = array();
        $page_i18n['page_id'] = $page_id;
        $page_i18n['page_title'] = $this->input->post('page_title', TRUE);

        if ($parent) {
            $page_i18n['page_uri'] = $parent['page_uri'] . '/' . url_title($this->input->post('page_uri', TRUE), 'dash', true);
        } else {
            $page_i18n['page_uri'] = url_title($this->input->post('page_uri', TRUE), 'dash', true);
        }
        $page_i18n['browser_title'] = $this->input->post('browser_title', TRUE) ? $this->input->post('browser_title', TRUE) : $this->input->post('page_title', TRUE);
        if ($content_type['node_type'] == TYPE_PAGE) {

            $page_i18n['include_in_site_map'] = $this->input->post('include_in_site_map', TRUE);
            $page_i18n['meta_keywords'] = $this->input->post('meta_keywords', TRUE);
            $page_i18n['meta_description'] = $this->input->post('meta_description', TRUE);
            $page_i18n['before_head_close'] = $this->input->post('before_head_close', TRUE);
            $page_i18n['before_body_close'] = $this->input->post('before_body_close', TRUE);
        }
        $page_i18n['page_status'] = $this->input->post('page_status', TRUE);
        $page_i18n['page_added_on'] = time();
        $page_i18n['enable_page_cache'] = $this->input->post('enable_page_cache', TRUE);
        $page_i18n['cache_for'] = $this->input->post('cache_for', TRUE);
        $page_i18n['page_content'] = $this->input->post('page_content', FALSE);

        $status = $this->db->insert('page_i18n', $page_i18n);
        if (!$status) {
            return FALSE;
        }
        $page_i18n_id = $this->db->insert_id();

        //$this->_addMainTabFieldData($page_i18n_id, $additional_fields);
        //Insert data to additional tab's fields
        //$this->_additionalTabFieldData($content_type['content_type_id'], $page_i18n_id, $additional_tabs);
        //$this->_addDefaultGlobalSection($page_i18n_id);

        $this->indexPage($page_i18n_id);

        return $page_i18n_id;
    }

    function _addMainTabFieldData($page_i18n_id, $additional_fields) {
        if (!empty($additional_fields)) {
            foreach ($additional_fields as $field) {
                if ($this->input->post($field['field_alias'], TRUE)) {
                    $content_field_data = array();
                    $content_field_data['page_i18n_id'] = $page_i18n_id;
                    $content_field_data['content_field_id'] = $field['content_field_id'];
                    $content_field_data['field_contents'] = trim($this->input->post($field['field_alias'], FALSE));
                    $content_field_data['field_updated_on'] = time();
                    $status = $this->db->insert('page_field_data', $content_field_data);
                    if (!$status) {
                        log_message('Error', "Insert data to main tab's fields failed");
                        //$this->db->trans_rollback();
                        return FALSE;
                    }
                }
            }
        }
    }

    //Insert data to main tab's fiellds
    function _additionalTabFieldData($content_type_id, $page_i18n_id, $additional_tabs) {
        if (empty($additional_tabs)) {
            return false;
        }

        foreach ($additional_tabs as $value) {
            $additional_fields = $this->Fieldmodel->listGroupFields($content_type_id, $value['content_fieldgroup_id']);
            if (empty($additional_fields)) {
                continue;
            }

            foreach ($additional_fields as $field) {
                if (is_null($this->input->post($field['field_alias'], TRUE))) {
                    continue;
                }

                $existing_field = false;
                $this->db->where('page_i18n_id', $page_i18n_id);
                $this->db->where('content_field_id', $field['content_field_id']);
                $field_rs = $this->db->get('page_field_data');
                if ($field_rs && $field_rs->num_rows() > 0) {
                    $existing_field = true;
                }

                $content_field_data = array();
                $content_field_data['page_i18n_id'] = $page_i18n_id;
                $content_field_data['content_field_id'] = $field['content_field_id'];
                $content_field_data['field_contents'] = trim($this->input->post($field['field_alias'], FALSE));
                $content_field_data['field_updated_on'] = time();
                if ($existing_field) {
                    $this->db->where('page_i18n_id', $page_i18n_id);
                    $this->db->where('content_field_id', $field['content_field_id']);
                    $status = $this->db->update('page_field_data', $content_field_data);
                } else {
                    $status = $this->db->insert('page_field_data', $content_field_data);
                }
                if (!$status) {
                    log_message('Error', "Insert data to additional fields failed");
                    //$this->db->trans_rollback();
                    return FALSE;
                }
            }
        }
    }

    function _addDefaultGlobalSection($page_i18n_id) {
        //Fetch Default Section
        $this->db->where('default_section', 1);
        $rs = $this->db->get('global_section');
        //echo $this->db->last_query();exit();
        if ($rs->num_rows() == 1) {
            $global_section = $rs->row_array();
            if ($global_section) {
                $data = array();

                $data['page_i18n_id'] = $page_i18n_id;
                $data['global_section_id'] = $global_section['global_section_id'];
                $data['page_section_name'] = $global_section['section_name'];
                $data['page_section_alias'] = $global_section['section_alias'];


                $data['page_section_background'] = $global_section['section_background'];
                $data['page_section_img_medium'] = $global_section['section_img_medium'];
                $data['page_section_img_small'] = $global_section['section_img_small'];

                $data['page_section_sort_order'] = $this->getSectionSortOrder($page_i18n_id);
                $data['page_section_template'] = '';
                $data['page_section_block_template'] = '';

                $data['page_section_updated_on'] = time();
                //print_r($data); die;
                $status = $this->db->insert('page_section', $data);
                if ($status) {
                    $page_section_id = $this->db->insert_id();


                    //Fetch Global Blocks By Global Section Id
                    $this->load->model('cms/Pagesectionmodel');
                    $global_blocks = $this->Pagesectionmodel->fetchGlobalBlocksByGsid($global_section['global_section_id']);

                    if (!$global_blocks) {
                        return;
                    }
                    foreach ($global_blocks as $global_block) {
                        $blocks = array();

                        $blocks['page_global_block_id'] = $global_block['global_block_id'];

                        $blocks['page_i18n_id'] = $page_i18n_id;
                        $blocks['page_section_id'] = $page_section_id;
                        $blocks['page_block_type_id'] = $global_block['block_type_id'];

                        $blocks['page_block_name'] = $global_block['block_name'];
                        $blocks['page_block_title'] = $global_block['block_title'];
                        $blocks['page_block_alias'] = $global_block['block_alias'];
                        $blocks['page_block_content'] = $global_block['block_content'];
                        $blocks['page_block_image'] = $global_block['block_image'];
                        $blocks['page_block_image_medium'] = $global_block['block_image_medium'];
                        $blocks['page_block_image_small'] = $global_block['block_image_small'];
                        $blocks['page_block_link'] = $global_block['block_link'];
                        $blocks['page_block_link_text'] = isset($global_block['block_link_text']) ? $global_block['block_link_text'] : '';
                        $blocks['page_block_template'] = '';
                        $blocks['page_block_css_class'] = $global_block['block_css_class'];
                        $blocks['page_block_css_style'] = $global_block['block_css_style'];
                        $blocks['page_block_sort_order'] = $this->getBlockOrder($page_section_id);

                        $blocks['page_block_is_active'] = $global_block['block_is_active'];

                        $blocks['page_block_col_lg'] = $global_block['block_col_lg'];
                        $blocks['page_block_col_md'] = $global_block['block_col_md'];
                        $blocks['page_block_col_sm'] = $global_block['block_col_sm'];
                        $blocks['page_block_col_xs'] = $global_block['block_col_xs'];

                        $blocks['page_block_col_lg_padding'] = $global_block['block_col_lg_padding'];
                        $blocks['page_block_col_md_padding'] = $global_block['block_col_md_padding'];
                        $blocks['page_block_col_sm_padding'] = $global_block['block_col_sm_padding'];
                        $blocks['page_block_col_xs_padding'] = $global_block['block_col_xs_padding'];
                        $blocks['page_block_updated_on'] = time();
                        $blocks['page_additional_fields'] = $global_block['additional_fields'];
                        $this->db->insert('page_block', $blocks);
                    }
                }
            }
        }
    }

    function getSectionSortOrder($page_i18n_id) {
        $this->db->select_max('page_section_sort_order');
        $this->db->where('page_i18n_id', intval($page_i18n_id));
        $query = $this->db->get('page_section');
        $sort_order = $query->row_array();
        return $sort_order['page_section_sort_order'] + 1;
    }

    function getBlockOrder($sid) {
        $this->db->select_max('page_block_sort_order');
        $this->db->where('page_section_id', $sid);
        $query = $this->db->get('page_block');
        $sort_order = $query->row_array();
        return $sort_order['page_block_sort_order'] + 1;
    }

    //Function get additional fields data
    function getAdditionalFieldData($page_i18n_id) {
        $this->db->select('*');
        $this->db->from('page_field_data');
        $this->db->join('content_field', 'content_field.content_field_id = page_field_data.content_field_id');
        $this->db->where('page_i18n_id', $page_i18n_id);
        $rs = $this->db->get();
        $output = array();

        foreach ($rs->result_array() as $row) {
            $output[$row['content_field_id']] = $row;
        }
        return $output;
    }

    function updateRecord($page_details, $additional_fields = array(), $additional_tabs = array()) {
        $parent = false;
        if ($this->input->post('parent_id', true) > 0) {
            $parent = $this->fetchById($this->input->post('parent_id', true));
        }
        $user = $this->userauth->checkAuth();


        $user_id = $user['admin_user_id'];

        $data = array();

        $data['parent_id'] = $this->input->post('parent_id', TRUE);
        $data['page_name'] = $this->input->post('page_name', TRUE);

        //$data['page_sort_order'] = $this->getSortOrder($this->input->post('parent_id', TRUE));

        $data['page_template_id'] = 0;
        if ($this->input->post('page_template_id', TRUE)) {
            $data['page_template_id'] = intval($this->input->post('page_template_id', TRUE));
        }
        if ($this->input->post('parent_id', true) != $page_details['parent_id']) {
            if ($this->input->post('parent_id', true) == 0) {
                $data['page_level'] = 0;
                $data['page_path'] = 0;
            } else {
                $data['page_level'] = $parent['page_level'] + 1;
                $data['page_path'] = $parent['page_path'] . '.' . $this->input->post('parent_id', true);
            }
        }

        $this->db->where('page_id', $page_details['page_id']);
        $status = $this->db->update('page', $data);
        if (!$status) {
            return FALSE;
        }

        $page_i18n = array();
        $page_i18n['page_title'] = $this->input->post('page_title', TRUE);
        // $page_i18n['page_uri'] = url_title($this->input->post('page_uri', TRUE));

        $page_i18n['page_uri'] = $this->_editPageUri($page_details, $parent);
        $page_i18n['browser_title'] = $this->input->post('browser_title', TRUE);

        if ($page_details['node_type'] == TYPE_PAGE) {
            $page_i18n['browser_title'] = $this->input->post('browser_title', TRUE);
            $page_i18n['include_in_site_map'] = $this->input->post('include_in_site_map', TRUE);
            $page_i18n['meta_keywords'] = $this->input->post('meta_keywords', TRUE);
            $page_i18n['meta_description'] = $this->input->post('meta_description', TRUE);
            $page_i18n['before_head_close'] = $this->input->post('before_head_close', TRUE);
            $page_i18n['before_body_close'] = $this->input->post('before_body_close', TRUE);
        }
        $page_i18n['page_status'] = $this->input->post('page_status', TRUE);
        $page_i18n['page_updated_on'] = time();
        $page_i18n['page_updated_by'] = $user_id;
        $page_i18n['enable_page_cache'] = $this->input->post('enable_page_cache', TRUE);
        $page_i18n['cache_for'] = $this->input->post('cache_for', TRUE);
        $page_i18n['page_content'] = $this->input->post('page_content', FALSE);

        $this->db->where('page_i18n_id', $page_details['page_i18n_id']);
        $status = $this->db->update('page_i18n', $page_i18n);
        if (!$status) {
            return FALSE;
        }
        $this->_addMainTabFieldData($page_details['page_i18n_id'], $additional_fields);

        //Insert data to additional tab's fields
        $this->_additionalTabFieldData($page_details['content_type_id'], $page_details['page_i18n_id'], $additional_tabs);
        $this->indexPage($page_details['page_i18n_id'], true);
        return TRUE;
    }

    function _editPageUri($page_details, $parent) {
        $page_uri = ltrim($this->input->post('page_title', TRUE), '/');
        if ($this->input->post('page_uri', TRUE)) {
            $page_uri = ltrim($this->input->post('page_uri', TRUE), '/');
        }

        if ($parent['page_id'] != $page_details['parent_id']) {
            $old_parent = $this->fetchById($page_details['parent_id']);

            if ($old_parent) {
                $page_uri = ltrim(str_replace($old_parent['page_uri'] . '/', $parent['page_uri'], $this->input->post('page_uri', TRUE)), '/');
            } else if ($parent['page_uri']) {
                $page_uri = $parent['page_uri'] . '/' . url_title(ltrim($this->input->post('page_uri', TRUE), '/'));
            }
        } else if ($parent && strpos($page_uri, '/') === false) {
            $page_uri = $parent['page_uri'] . '/' . url_title(ltrim($this->input->post('page_uri', TRUE), '/'));
        }
        //check if already
        $this->db->join('page', 'page.page_id=page_i18n.page_id');
        $this->db->where('page_uri', $page_uri);
        $this->db->where('parent_id', $this->input->post('parent_id', true));
        $this->db->where('page_i18n_id !=', $this->input->post('page_i18n_id', true));
        $rs = $this->db->get('page_i18n');
        if ($rs && $rs->num_rows() > 0) {
            $page_uri = $page_uri . '-1';
        }
        return $page_uri;
    }

    function _slugEdit($parent, $pid, $pname, $lang) {
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);
        if ($parent) {
            $slug = $parent['page_uri'] . '/' . $slug;
        }

        $this->db->limit(1);
        $this->db->where('page_uri', $slug);
        $this->db->where('language_code', $lang);
        $rs = $this->db->get('page_i18n');
        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('page_uri', $alt_slug);
                $this->db->where('language_code', $lang);
                $rs = $this->db->get('page_i18n');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

    function deleteRecord($page) {


        //Find child pages and move them to root.
        $this->db->from('page');
        $this->db->where('parent_id', $page['page_id']);
        $rs = $this->db->get();
        foreach ($rs->result_array() as $child) {
            $data = array();
            $data['parent_id'] = 0;
            $data['page_level'] = 0;
            $data['page_path'] = 0;
            $data['page_sort_order'] = $this->getSortOrder(0);

            $this->db->where('page_id', $child['page_id']);
            $this->db->update('page', $data);
        }


        $this->db->where('page_id', $page['page_id']);
        $this->db->delete('page');

        $this->db->where('page_id', $page['page_id']);
        $this->db->delete('page_i18n');

        $this->db->where('page_i18n_id', $page['page_i18n_id']);
        $this->db->delete('page_section');

        $this->db->where('page_i18n_id', $page['page_i18n_id']);
        $this->db->delete('page_block');


        //$this->Lucenemodel->removeFromIndex("page-{$page['page_i18n_id']}");
    }

    //function to get sort order
    function getSortOrder($pid) {
        $this->db->select_max('page_sort_order');
        $this->db->where('parent_id', intval($pid));
        $query = $this->db->get('page');

        $sort_order = $query->row_array();
        return $sort_order['page_sort_order'] + 1;
    }

    //function for page alias
    function _slug($parent, $pname) {
        $page_name = ($pname) ? $pname : '';

        $replace_array = array('.', '*', '/', '\\', '"', '\'', ',', '{', '}', '[', ']', '(', ')', '~', '`', '#');

        $slug = $page_name;
        $slug = trim($slug);
        $slug = str_replace($replace_array, "", $slug);
        $slug = url_title($slug, 'dash', true);
        if ($parent) {
            $slug = $parent['page_uri'] . '/' . $slug;
        }

        $this->db->limit(1);
        $this->db->where('page_uri', $slug);
        $rs = $this->db->get('page_i18n');

        if ($rs->num_rows() > 0) {
            $suffix = 2;
            do {
                $slug_check = false;
                $alt_slug = substr($slug, 0, 200 - (strlen($suffix) + 1)) . "-$suffix";
                $this->db->limit(1);
                $this->db->where('page_uri', $alt_slug);
                $rs = $this->db->get('page_i18n');
                if ($rs->num_rows() > 0)
                    $slug_check = true;
                $suffix++;
            }while ($slug_check);
            $slug = $alt_slug;
        }

        return $slug;
    }

    // Used in Menu_item Controller
    function allPagesAsArray($content_type, $parent_id) {
        $this->db->select('page.page_id, parent_id, page_name, page_level,page_i18n.*');
        $this->db->from('page');
        $this->db->join('page_i18n', 'page_i18n.page_id = page.page_id');
        $this->db->join('language', 'language.language_code = page_i18n.language_code', 'LEFT');
        $this->db->where('page.content_type_id', $content_type);
        $this->db->where('page_i18n.page_status <>', 'Temp');
        $this->db->where('page_i18n.language_code', $this->config->item('DEFAULT_LANG'));
        $this->db->order_by('page_sort_order', 'ASC');
        $query = $this->db->get();

        $pages = array();
        foreach ($query->result_array() as $row) {
            $pages[$row['parent_id']][] = $row;
        }


        $output = array();
        $this->_PagesAsArray($pages, $parent_id, $output);
        return $output;
    }

    function _PagesAsArray($pages, $parent_id, &$output = array()) {
        if (array_key_exists($parent_id, $pages)) {
            foreach ($pages[$parent_id] as $row) {
                $output[$row['page_id']] = $row;
                $this->_PagesAsArray($pages, $row['page_id'], $output);
            }
        }
        return $output;
    }

    function enableInclude($page_details, $include) {
        //delete
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('include_id', $include['include_id']);
        $this->db->delete('page_include');

        $data = array();
        $data['page_id'] = $page_details['page_id'];
        $data['include_id'] = $include['include_id'];

        $status = $this->db->insert('page_include', $data);
        if (!$status) {
            return FALSE;
        }
    }

    function disableInclude($page_details, $include) {
        $this->db->where('page_id', $page_details['page_id']);
        $this->db->where('include_id', $include['include_id']);
        $this->db->delete('page_include');
    }

}
