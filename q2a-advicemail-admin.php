<?php
class q2a_advicemail_admin {
	function init_queries($tableslc) {
		return null;
	}
	function option_default($option) {
		switch($option) {
			case 'q2a-advicemail-hour':
				return 6; 
			default:
				return null;
		}
	}
		
	function allow_template($template) {
		return ($template!='admin');
	}       
		
	function admin_form(&$qa_content){                       
		// process the admin form if admin hit Save-Changes-button
		$ok = null;
		if (qa_clicked('q2a-advicemail-save')) {
			qa_opt('q2a-advicemail-body', qa_post_text('q2a-advicemail-body'));
			qa_opt('q2a-advicemail-hour', (int)qa_post_text('q2a-advicemail-hour'));
			$ok = qa_lang('admin/options_saved');
		}
		
		// form fields to display frontend for admin
		$fields = array();
		
		$fields[] = array(
			'type' => 'textarea',
			'label' => '本文',
			'tags' => 'name="q2a-advicemail-body"',
			'value' => qa_opt('q2a-advicemail-body'),
		);

		$fields[] = array(
			'type' => 'number',
			'label' => 'mail hour',
			'tags' => 'name="q2a-advicemail-hour"',
			'value' => qa_opt('q2a-advicemail-hour'),
		);
		
		return array(     
			'ok' => ($ok && !isset($error)) ? $ok : null,
			'fields' => $fields,
			'buttons' => array(
				array(
					'label' => qa_lang_html('main/save_button'),
					'tags' => 'name="q2a-advicemail-save"',
				),
			),
		);
	}
}

