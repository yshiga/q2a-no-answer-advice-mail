<?php
if (!defined('QA_VERSION')) { 
	require_once dirname(empty($_SERVER['SCRIPT_FILENAME']) ? __FILE__ : $_SERVER['SCRIPT_FILENAME']).'/../../qa-include/qa-base.php';
   require_once QA_INCLUDE_DIR.'app/emails.php';
}

$HOURS = qa_opt('q2a-advicemail-hour');	// 閾値：時間
$posts = getXHoursAgoRegisterPosts($HOURS);
foreach($posts as $post){
	$user = getUserInfo($post['userid']);
	$handle = $user[0]['handle'];
	$email = $user[0]['email'];
	$title = '回答が着くように質問を工夫してみましょう';
	$bodyTemplate = qa_opt('q2a-advicemail-body');
	$body = strtr($bodyTemplate, 
		array(
			'^username' => $handle,
			'^sitename' => qa_opt('site_title')
		)
	);
	sendEmail($title, $body, $handle, $email);
}

function sendEmail($title, $body, $toname, $toemail){

	$params['fromemail'] = qa_opt('from_email');
	$params['fromname'] = qa_opt('site_title');
	$params['subject'] = '【' . qa_opt('site_title') . '】' . $title;
	$params['body'] = $body;
	$params['toname'] = $toname;
	$params['toemail'] = $toemail;
	$params['html'] = false;

//	qa_send_email($params);

	$params['toemail'] = 'yuichi.shiga@gmail.com';
	qa_send_email($params);
}
function getUserInfo($userid) {
    $sql = 'select email,handle from qa_users where userid=' . $userid;
    $result = qa_db_query_sub($sql);
    return qa_db_read_all_assoc($result);
}
