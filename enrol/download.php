<?php
require('../config.php');
require_once("$CFG->dirroot/enrol/locallib.php");
require_once("$CFG->dirroot/enrol/users_forms.php");
require_once("$CFG->dirroot/enrol/renderer.php");
require_once("$CFG->dirroot/group/lib.php");
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->libdir.'/authlib.php');
require_once($CFG->dirroot.'/user/filters/lib.php');
require_once($CFG->dirroot.'/user/lib.php');

$format = optional_param('format', '', PARAM_ALPHA);

require_login();
admin_externalpage_setup('userbulk');
require_capability('moodle/user:update', context_system::instance());

//$return = $CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk.php';

if ($format) {
	$fields = array('id'        => 'id',
			'username'  => 'username',
			'email'     => 'email',
			'firstname' => 'firstname',
			'lastname'  => 'lastname');

	if ($extrafields = $DB->get_records('course')) {
		foreach ($extrafields as $n=>$v){
			$fields['profile_field_'.$v->shortname] = 'profile_field_'.$v->shortname;
		}
	}
	
	//$course = $DB->get_record('course', array('id'=>$id), '*', MUST_EXIST);

	//database connections
	$hostname = "localhost";
	$user = "root";
	$pass = "";
	$database = "moodle";
	
	$connection = mysql_connect($hostname, $user, $pass) or die(mysql_error());
	mysql_select_db($database, $connection) or die(mysql_error());	

$table = 'mdl_user';
	switch ($format) {
		case 'csv' : exportMysqlToCsv($table);
		//case 'ods' : user_download_ods($fields);
		case 'xls' :
			$sql_query = "SELECT firstname, lastname, email
		FROM mdl_user u
		JOIN mdl_user_enrolments ue ON ue.userid = u.id
		JOIN mdl_enrol e ON ( e.id = ue.enrolid
		AND e.courseid =2)";
				
			// Gets the data from the database
			$result = mysql_query($sql_query);
			
			// Send Header
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");;
			header("Content-Disposition: attachment;filename=EnrolledUsers.xls "); //
			header("Content-Transfer-Encoding: binary ");
			// XLS Data Cell
			
			xlsBOF();
				
			xlsWriteLabel(1,0,"FirstName");
		xlsWriteLabel(1,1,"LastName");
		xlsWriteLabel(1,2,"Email");
					$xlsRow = 1;
					while(list($firstname,$lastname,$email)=mysql_fetch_row($result)) {
					++$i;
					xlsWriteLabel($xlsRow,0,"$firstname");
					xlsWriteLabel($xlsRow,1,"$lastname");
					xlsWriteLabel($xlsRow,2,"$email");
					$xlsRow++;
			}
			xlsEOF();
			exit();

	}
	die;
}

echo $OUTPUT->header();
//echo $OUTPUT->heading(get_string('download', 'admin'));
echo $OUTPUT->heading(get_string('enrolleddownload', 'admin'));

echo $OUTPUT->box_start();
echo '<ul>';
echo '<li><a href="download.php?format=csv">'.get_string('downloadtext').'</a></li>';
//echo '<li><a href="download.php?format=ods">'.get_string('downloadods').'</a></li>';
echo '<li><a href="download.php?format=xls">'.get_string('downloadexcel').'</a></li>';
echo '</ul>';
echo $OUTPUT->box_end();

echo $OUTPUT->continue_button($return);

echo $OUTPUT->footer();

function user_download_ods($fields) {
	global $CFG, $SESSION, $DB;

	require_once("$CFG->libdir/odslib.class.php");
	require_once($CFG->dirroot.'/user/profile/lib.php');

	$filename = clean_filename(get_string('users').'.ods');

	$workbook = new MoodleODSWorkbook('-');
	$workbook->send($filename);

	$worksheet = array();

	$worksheet[0] = $workbook->add_worksheet('');
	$col = 0;
	foreach ($fields as $fieldname) {
		$worksheet[0]->write(0, $col, $fieldname);
		$col++;
	}

	$row = 1;
	foreach ($SESSION->bulk_users as $userid) {
		if (!$user = $DB->get_record('user', array('id'=>$userid))) {
			continue;
		}
		$col = 0;
		profile_load_data($user);
		foreach ($fields as $field=>$unused) {
			$worksheet[0]->write($row, $col, $user->$field);
			$col++;
		}
		$row++;
	}

	$workbook->close();
	die;
}


function user_download_xls($fields) {
	global $CFG, $SESSION, $DB;

	require_once("$CFG->libdir/excellib.class.php");
	require_once($CFG->dirroot.'/user/profile/lib.php');

	$filename = clean_filename(get_string('users').'.xls');

	$workbook = new MoodleExcelWorkbook('-');
	$workbook->send($filename);

	$worksheet = array();

	$worksheet[0] = $workbook->add_worksheet('');
	$col = 0;
	foreach ($fields as $fieldname) {
		$worksheet[0]->write(0, $col, $fieldname);
		$col++;
	}

	$row = 1;
	foreach ($SESSION->bulk_users as $userid) {
		if (!$user = $DB->get_record('user', array('id'=>$userid))) {
			continue;
		}
		$col = 0;
		profile_load_data($user);
		foreach ($fields as $field=>$unused) {
			$worksheet[0]->write($row, $col, $user->$field);
			$col++;
		}
		$row++;
	}

	$workbook->close();
	die;
}



// get enrolled users

function exportMysqlToCsv($table,$filename = 'export.csv')
{
	$csv_terminated = "\n";
	$csv_separator = ",";
	$csv_enclosed = '"';
	$csv_escaped = "\\";
	$sql_query = "SELECT firstname, lastname, email
	FROM mdl_user u
	JOIN mdl_user_enrolments ue ON ue.userid = u.id
	JOIN mdl_enrol e ON ( e.id = ue.enrolid
	AND e.courseid =2)";

	// Gets the data from the database
	$result = mysql_query($sql_query);
	$fields_cnt = mysql_num_fields($result);


	$schema_insert = '';

	for ($i = 0; $i < $fields_cnt; $i++)
	{
		$l = $csv_enclosed . str_replace($csv_enclosed, $csv_escaped . $csv_enclosed,
				stripslashes(mysql_field_name($result, $i))) . $csv_enclosed;
		$schema_insert .= $l;
		$schema_insert .= $csv_separator;
	} // end for

	$out = trim(substr($schema_insert, 0, -1));
	$out .= $csv_terminated;

	// Format the data
	while ($row = mysql_fetch_array($result))
	{
		$schema_insert = '';
		for ($j = 0; $j < $fields_cnt; $j++)
		{
			if ($row[$j] == '0' || $row[$j] != '')
			{

				if ($csv_enclosed == '')
				{
					$schema_insert .= $row[$j];
				} else
				{
					$schema_insert .= $csv_enclosed .
					str_replace($csv_enclosed, $csv_escaped . $csv_enclosed, $row[$j]) . $csv_enclosed;
				}
			} else
			{
				$schema_insert .= '';
			}

			if ($j < $fields_cnt - 1)
			{
				$schema_insert .= $csv_separator;
			}
		} // end for

		$out .= $schema_insert;
		$out .= $csv_terminated;
	} // end while

	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Length: " . strlen($out));
	// Output to browser with appropriate mime type, you choose ;)
	header("Content-type: text/x-csv");
	//header("Content-type: text/csv");
	//header("Content-type: application/csv");
	header("Content-Disposition: attachment; filename=$filename");
	echo $out;
	exit;

}

function xlsBOF() {
	echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
	return;
}

function xlsEOF() {
	echo pack("ss", 0x0A, 0x00);
	return;
}

function xlsWriteNumber($Row, $Col, $Value) {
	echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
	echo pack("d", $Value);
	return;
}

function xlsWriteLabel($Row, $Col, $Value ) {
	$L = strlen($Value);
	echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
	echo $Value;
	return;
}