var editor = {
	selector: 'textarea.wysiwyg',
	//menubar: false,
	menu: {
		tools: {title: 'Tools', items: 'spellchecker code'}
	},
	height: "300px",
	block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5',
	plugins: "link,image,media,code,responsivefilemanager",
	toolbar: 'undo redo | bold italic | formatselect | styleselect | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink | image media | removeformat',
	image_advtab: true,
	external_filemanager_path: XF_SITE_URL + "filemanager/",
	filemanager_title: "File Manager",
	filemanager_access_key: "jdfkfd0",
	relative_urls: false,
	document_base_url: XF_SITE_URL,
	content_css: XF_SITE_URL + '/assets/themes/default/css/bootstrap.css',
	base: XF_BASE_URL + '/assets/themes/default/js/vendor/tinymce/',
	link_class_list: [
		{title: 'None', value: ''},
		{title: 'Popup', value: 'fancybox'}
	],
	external_plugins: {"filemanager": XF_SITE_URL + "filemanager/plugin.min.js"}
};
var simple_editor = {
	selector: 'textarea.mceSimple1',
	//menubar: false,
	menu: {
		tools: {title: 'Tools', items: 'spellchecker code'}
	},
	height: "300px",
	block_formats: 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5',
	plugins: "link,code",
	toolbar: 'undo redo | bold italic | formatselect | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink | removeformat',
	relative_urls: false,
	document_base_url: XF_SITE_URL,
	content_css: XF_SITE_URL + '/assets/themes/default/css/bootstrap.css',
	link_class_list: [
		{title: 'None', value: ''},
		{title: 'Popup', value: 'fancybox'}
	]

};
jQuery(document).ready(function ($) {
	tinymce.suffix = ".min";
	tinymce.baseURL = XF_BASE_URL + '/assets/themes/default/js/vendor/tinymce/';
	tinymce.init(editor);
	tinymce.init(simple_editor);

});
