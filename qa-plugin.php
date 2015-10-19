<?php
/*
	Plugin Name: Advice mail
	Plugin URI: 
	Plugin Description: send advice mail to users that are not answerd within X hours
	Plugin Version: 0.3
	Plugin Date: 2015-10-15
	Plugin Author:
	Plugin Author URI:
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.7
	Plugin Update Check URI: 
*/
/*
## cron setting  

0 * * * * {qa-root-path}/qa-plugin/q2a-advicemail/send-email.php 

*/
if (!defined('QA_VERSION')) {
	header('Location: ../../');
	exit;
}

qa_register_plugin_module('module', 'q2a-advicemail-admin.php', 'q2a_advicemail_admin', 'advice mail');

function getXHoursAgoRegisterPosts($hours) {
	$mysqldate = date('Y-m-d H:i:s', time() - $days * 60 * 60);
	$sql = "select postid,userid from";
	$sql .= " (select * from";
	$sql .= " (select postid,userid from qa_posts where created < '" . $mysqldate . "' and type='Q') as t1";
	$sql .= " left join (select postid as t2postid,parentid from qa_posts where type='A') as t2";
	$sql .= " on t1.postid = t2.parentid) t0";
	$sql .= " where t2postid is NULL and userid is not null order by postid";
	$result = qa_db_query_sub($sql); 
	return qa_db_read_all_assoc($result);
}


