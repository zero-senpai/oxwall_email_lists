<?php
/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is a proprietary licensed product. 
 * For more information see License.txt in the plugin folder.

 * ---
 * Copyright (c) 2018-2020, Jake Brunton
 * All rights reserved.
 * jbtech.business@gmail.com

 * Redistribution and use in source and binary forms, with or without modification, are not permitted provided.

 * This plugin should be bought from the developer. For details contact jbtech.business@gmail.com.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
class EMAILLISTS_CTRL_Admin extends ADMIN_CTRL_Abstract{
	
		//build config form
		function build_settings_form(){
			$lang = OW::getLanguage();
			
			$form = new Form("emaillists_settings");
			$export_type = new Selectbox("export_type");
			$export_type->setLabel($lang->text("emaillists", "export_type_settings"));
			$export_type->setOptions(array(
				"ALL"=>$lang->text("emaillists", "all_data"),
				"EONLY"=>$lang->text("emaillists", "emails_only"),
				"ENAME"=>$lang->text("emaillists", "emails_names"),
				"MALE"=>$lang->text("emaillists", "male_users"),
				"FEMALE"=>$lang->text("emaillists", "female_users")));
			$export_type->setRequired(true);

			$submit = new Submit("submit");
			$submit->setLabel($lang->text("emaillists", "settings_submit"));
			
			$form->addElement($export_type);
			//$form->addElement($limit);
			$form->addElement($submit);
			return $form;
		}
		

	public function index(){
		$this->init("index");
		$langs = OW::getLanguage();
		$config = OW::getConfig();
		$content = "";
		$setting = $config->getValue("emaillists", "export_type");
		
		//grab settings form
		$form = $this->build_settings_form();
		$this->addForm($form);
		
		if(OW::getRequest()->isPost() && $form->isValid($_POST)){
			$values = $form->getValues();
			$form->reset();
			OW::getConfig()->saveConfig("emaillists", "export_type", $values["export_type"]);
			//OW::getConfig()->saveConfig("emaillists", "sql_limit", $values["limit"]);
		}
		$settings = OW::getConfig()->getValues("emaillists");
		$form->getElement("export_type")->setValue( $settings["export_type"] );
		//$form->getElement("limit")->setValue( $settings["sql_limit"] );

		//setup Table Ordering Queries and Top Page elements
		$this->setPageTitle($langs->text('emaillists', 'admin_config_title'));
		$this->setPageHeading($langs->text('emaillists', 'admin_config_head'));
		if(isset($_GET['orderSexMale'])){
			$BU = OW_DB_PREFIX."base_user";
			$BQ = OW_DB_PREFIX."base_question_data";
			$sql = "
				SELECT {$BU}.id, username, email FROM {$BU}
				INNER JOIN {$BQ} ON {$BU}.id = {$BQ}.userId
				WHERE questionName='sex' AND intValue='1' ORDER BY id ASC;";
			$orderBy = $langs->text('emaillists', 'orderby_male');
			$showsex = true;
		}
		elseif(isset($_GET['orderSexFemale'])){
			$BU = OW_DB_PREFIX."base_user";
			$BQ = OW_DB_PREFIX."base_question_data";
			$sql = "
				SELECT {$BU}.id, username, email FROM {$BU}
				INNER JOIN {$BQ} ON {$BU}.id = {$BQ}.userId
				WHERE questionName='sex' AND intValue='2' ORDER BY id ASC;";
			$orderBy = $langs->text('emaillists', 'orderby_female');
			$showsex = true;
		}
		elseif(isset($_GET['orderID'])){
			$sql = "
				SELECT * FROM ".OW_DB_PREFIX."base_user ORDER BY id ASC";
			$orderBy = $langs->text('emaillists', 'orderby_id');
			$showsex = false;
		}
		elseif(isset($_GET['orderUname'])){
			$sql = "
				SELECT * FROM ".OW_DB_PREFIX."base_user ORDER BY username ASC";
			$orderBy = $langs->text('emaillists', 'orderby_uname');
			$showsex = false;
		}
		elseif(isset($_GET['orderEmail'])){
			$sql = " SELECT * FROM ".OW_DB_PREFIX."base_user ORDER BY email ASC";
			$orderBy = $langs->text('emaillists', 'orderby_email');
			$showsex = false;
		}
		else{
			$sql = " SELECT * FROM ".OW_DB_PREFIX."base_user ORDER BY activityStamp DESC";
			$orderBy = $langs->text('emaillists', 'orderby_activity');
			$showsex = false;
		}
		
		$query_data = OW::getDbo()->queryForList($sql);
		$data = $query_data[0];

		$content .="<div><a href=\"".OW_URL_HOME."admin/plugins/email_lists?orderSexMale\">".$langs->text("emaillists", "use_male")."</a> &nbsp; &nbsp;  <a href=\"".OW_URL_HOME."admin/plugins/email_lists?orderSexFemale\">".$langs->text("emaillists", "use_female")."</a></div><br><p>".$langs->text('emaillists', 'ordering')." ". $orderBy ." <span style=\"float:right;\"><a style=\"display:block;padding:5px;border:2px solid orange;text-style:none;background:#ccc;color:#fff;\" href=\"".OW_URL_HOME."admin/plugins/email_lists/jbtech\">JB-Tech Help!</a></span></p><br>";

					
					
		$content .= "<div>
						<span class=\"ow_button\"><input type=\"button\" class=\"ow_button\" onclick=\"window.location='".OW_URL_HOME."admin/plugins/email_lists?export_csv'\" value=\"".$langs->text('emaillists', 'export_csv')."\" /></span>
						<span class=\"ow_button\"><input type=\"button\" class=\"ow_button\" onclick=\"window.location='".OW_URL_HOME."admin/plugins/email_lists?export_txt'\" value=\"".$langs->text('emaillists', 'export_txt')."\" /></span>
					</div>
					";
		
		$content .="<table class=\"ow_table_1\" style=\"margin-left:7%;\">
				<tr><th><a href=\"".OW_URL_HOME."admin/plugins/email_lists?orderID\">".$langs->text("emaillists", "id")."</a></th><th><a href=\"".OW_URL_HOME."admin/plugins/email_lists?orderUname\">".$langs->text("emaillists", "usernames")."</a></th><th><a href=\"".OW_URL_HOME."admin/plugins/email_lists?orderEmail\">".$langs->text("emaillists", "email_addresses")."</a></th>";
			if($showsex == true){
				$content.="<th>".$langs->text("emaillists", "sex")."</a></th></tr>";
			}else{$content.="</tr>";}
		if(isset($_GET["orderSexMale"])){$sex = OW::getLanguage()->text("emaillists", "male");}
		elseif(isset($_GET["orderSexFemale"])){$sex = OW::getLanguage()->text("emaillists", "female");}
		else{$sex= OW::getLanguage()->text("emaillists", "select_a_sex");}
		foreach ($query_data as $ud){
			$content .="<tr class=\"ow_alt_2\">";
			$content .="<td>". $ud['id'] ."</td><td>". $ud['username'] ."</td><td>". $ud['email'] ."</td>";
			if($showsex == true){
				$content .="<td>".$sex."</td>";
			}else{
				$content .="</tr>";
			}
		}
		
		$content .="</table>";

					
		//Export CSV					
		if(isset($_GET['export_csv'])){
			$oldLimit = ini_get( 'memory_limit' );
			ini_set( 'memory_limit', '1024M' );
			if($setting == "EONLY"){
				$sql2 = "
						SELECT email FROM ".OW_DB_PREFIX."base_user ORDER BY email ASC";
			}
			if($setting == "ENAME"){
				$sql2 = "
						SELECT username, email FROM ".OW_DB_PREFIX."base_user ORDER BY username ASC";
			}
			if($setting == "ALL"){
				$sql2 = "
						SELECT id, username, email FROM ".OW_DB_PREFIX."base_user ORDER BY username ASC";
			}
			if($setting == "MALE"){
				$BU = OW_DB_PREFIX."base_user";
				$BQ = OW_DB_PREFIX."base_question_data";
				$sql2 = "
					SELECT {$BU}.id, username, email FROM {$BU}
					INNER JOIN {$BQ} ON {$BU}.id = {$BQ}.userId
					WHERE questionName='sex' AND intValue='1';";
			}
			if($setting == "FEMALE"){
				$BU = OW_DB_PREFIX."base_user";
				$BQ = OW_DB_PREFIX."base_question_data";
				$sql2 = "
					SELECT {$BU}.id, username, email FROM {$BU}
					INNER JOIN {$BQ} ON {$BU}.id = {$BQ}.userId
					WHERE questionName='sex' AND intValue='2';";
			}

			$query_data = OW::getDbo()->queryForList($sql2);
			$data1 = $query_data[0];
			
			function cleanData(&$str)
			{
				if($str == 't') $str = 'TRUE';
				if($str == 'f') $str = 'FALSE';
				if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
				$str = "'$str";
				}
			if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
			}

			// filename for download
			$filename = "User List ".$langs->text('emaillists', 'website_name')."" . date('Ymd') . ".csv";

			header("Content-Disposition: attachment; filename=\"$filename\"");
			header("Content-Type: text/csv");

			$out = fopen("php://output", 'w');

			$flag = false;
			foreach($query_data as $row) {
			if(!$flag) {
				// display field/column names as first row
				fputcsv($out, array_keys($row), ',', '"');
				$flag = true;
			}
			array_walk($row, 'cleanData');
			fputcsv($out, array_values($row), ',', '"');
			}

			fclose($out);
			ini_set( 'memory_limit', $oldLimit );
			exit;
		}
		//Export TXT
		if(isset($_GET['export_txt'])){
			$oldLimit = ini_get( 'memory_limit' );
			ini_set( 'memory_limit', '1024M' );
			if($setting == "EONLY"){
				$sql2 = "
						SELECT email FROM ".OW_DB_PREFIX."base_user ORDER BY email ASC";
			}
			if($setting == "ENAME"){
				$sql2 = "
						SELECT username, email FROM ".OW_DB_PREFIX."base_user ORDER BY username ASC";
			}
			if($setting == "ALL"){
				$sql2 = "
						SELECT id, username, email FROM ".OW_DB_PREFIX."base_user ORDER BY username ASC";
			}
			if($setting == "MALE"){
				$BU = OW_DB_PREFIX."base_user";
				$BQ = OW_DB_PREFIX."base_question_data";
				$sql2 = "
					SELECT {$BU}.id, username, email FROM {$BU}
					INNER JOIN {$BQ} ON {$BU}.id = {$BQ}.userId
					WHERE questionName='sex' AND intValue='1' ORDER BY username ASC;";
			}
			if($setting == "FEMALE"){
				$BU = OW_DB_PREFIX."base_user";
				$BQ = OW_DB_PREFIX."base_question_data";
				$sql2 = "
					SELECT {$BU}.id, username, email FROM {$BU}
					INNER JOIN {$BQ} ON {$BU}.id = {$BQ}.userId
					WHERE questionName='sex' AND intValue='2' ORDER BY username ASC;";
			}
			
			$query_data = OW::getDbo()->queryForList($sql2);
			$data1 = $query_data[0];
			$uName = $data1['username'];
			$uID = $data1['id'];
			$email = $data1['email'];
			
			function cleanData(&$str)
				{
					$str = preg_replace("/\t/", "\\t", $str);
					$str = preg_replace("/\r?\n/", "\\n", $str);
					if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
				}
				
				$filename = "User List " .$langs->text('emaillists', 'website_name')."" . date('Ymd') . ".txt";

				header("Content-Disposition: attachment; filename=\"$filename\"");
				header("Content-Type: application/text");

				$flag = false;
				foreach($query_data as $row) {
					if(!$flag) {
					// display field/column names as first row
					echo implode("\t\t\t", array_keys($row)) . "\r\n";
					$flag = true;
					}
				array_walk($row, __NAMESPACE__ . '\cleanData');
				echo implode("\t\t\t", array_values($row)) . "\r\n";
				}
				ini_set( 'memory_limit', $oldLimit );
				exit;
		}
		
		$this->assign("content", $content);
	}

	
	
	
	
}