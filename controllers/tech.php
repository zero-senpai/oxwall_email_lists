<?php
/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is a proprietary licensed product. 
 * For more information see License.txt in the plugin folder.

 * ---
 * Copyright (c) 2018-2019, Jake Brunton
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
class EMAILLISTS_CTRL_Tech extends ADMIN_CTRL_Abstract{

	public function index(){
	
		$langs = OW::getLanguage();
		$content = "";
		$this->setPageTitle($langs->text('emaillists', 'jbtech_title'));
		$this->setPageHeading($langs->text('emaillists', 'jbtech_heading'));
		
		$content .="
			<p><a href=\"".OW_URL_HOME."admin/plugins/email_lists\">&lt; Back to Plugin</a></p><br>
			<div style=\"display:block;width:95%;margin-left:6%;border:1px solid #ccc;padding:10px;\">
				<h3>JB-Tech Support</h3><br>
				<ul class=\"faq\">

  <li class=\"q\">
    &middot; 
    How do I export my Email data?
  </li>
  <li class=\"a\">Simply press 'Export .CSV' or 'Export .TXT'. Your browser will prompt you to download or open the file. Download it and you're set!</li>
  
  <li class=\"q\">
    &middot;  
    How do I change the order or the table?
  </li>
  <li class=\"a\">Click on the column header you wish to order by. Example: to order the table by 'Username' click the Username header.</li>

  <li class=\"q\">
    &middot; 
    Where do I go for support?
  </li>
  <li class=\"a\">Feel free to <a href=\"http://jbtech.online/contact\" target=\"_blank\">contact me</a> for support or questions.</li>

</ul>
			</div><br><br>
			<div style=\"display:block;position:absolute;left:45%;width:50%;padding:3px;\">
			<h3>Premium Support and Management</h3>
			<p>JB-Tech offers <strong>quality</strong> support and management plans for your Oxwall/Skadate website! Our convenient pre-paid plans get you weeks worth of professional support, administration, and more. If you need an additional Administrator who will also provide support, theme modification, troubleshooting, installations/updates, software installs, backup and more, then JB-Tech's Oxwall/Skadate support plans are for you! Consider our best value plan to the left, or <a href=\"http://jbtech.online/pricing\">check out all we offer!</a></p><br>
			<strong>VALUED CUSTOMER</strong>! If you wish to try out our services, please use the following code for 5% off the total price:<br>
			<span style=\"display:block;padding:10px;background:#B3B3B3;border:1px dashed #000;border-radius:8%;text-align:center;width:250px;color:green;\">JBOWALL1ST</span><br>
			When contacting us about a plan (that you wish to purchase), attach this code plus your license key for this plugin to receive the discount! Only first-time customers of the specified plan picked by the Client are applicable for this deal.<br>
            Thanks for using our plugin!
            <br><br>
            <div>
            <div class=\"modal-content\">
            <span class=\"close-button\">&star;</span>
            <h1>STAY UP TO DATE</h1>
			<span style=\"font-size:12.3px;\">Check out <a href=\"http://jbtech.online/\">JB Tech Online</a> for our plugin updates, dev stories, deals and more!</span>
</div>
</div>
			</div>
			<div class=\"columns\" align=\"right\"><ul class=\"price\"><li class=\"header\" style=\"background-color: #4caf50;\">Support +</li><li class=\"grey\">$215.00/bi-weekly</li><li>Support (via Email, Skype)</li><li>Website Adminsitration (complete)</li><li>Plugin/Theme Installations, Updates</li><li>Page Modifications</li><li>Content Setup (widgets, plugin settings)</li><li>Minor theme modifications</li><li>Email Marketing (when applicable)</li><li><a href=\"https://developers.oxwall.com/store/item/1511\">Email Lists</a> FREE (1 License)</li><li class=\"grey\"><a class=\"button\" href=\"http://jbtech.online/contact\">Email Me!</a></li></ul></div>";
			
			$content .="
				<script>
						// Accordian Action
var action = 'click';
var speed = \"500\";


$(document).ready(function(){

// Question handler
  $('li.q').on(action, function(){

    // gets next element
    // opens .a of selected question
    $(this).next().slideToggle(speed)
    
    // selects all other answers and slides up any open answer
    .siblings('li.a').slideUp();
  
    // Grab img from clicked question
    var img = $(this).children('img');

    // remove Rotate class from all images except the active
    $('img').not(img).removeClass('rotate');

    // toggle rotate class
    img.toggleClass('rotate');

  });

});
</script>";

	$content .="<style type=\"text/css\">
	.faq li { padding: 20px; }

.faq li.q {
  background: #4FC2E;
  font-weight: bold;
  font-size: 120%;
  border-bottom: 1px #ddd solid;
  cursor: pointer;
}

.faq li.a {
  background: #3BB0D6;
  display: none;
  color:#fff;
}

* {
    box-sizing: border-box;
}

.columns {
    float: left;
    width: 33.3%;
    padding: 8px;
}

.price {
    list-style-type: none;
    border: 1px solid #eee;
    margin: 0;
    padding: 0;
    -webkit-transition: 0.3s;
    transition: 0.3s;
}

.price:hover {
    box-shadow: 0 8px 12px 0 rgba(0,0,0,0.2)
}

.price .header {
    background-color: #111;
    color: white;
    font-size: 25px;
}

.price li {
    border-bottom: 1px solid #eee;
    padding: 20px;
    text-align: center;
}

.price .grey {
    background-color: #eee;
    font-size: 20px;
}

.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 25px;
    text-align: center;
    text-decoration: none;
    font-size: 18px;
}
.modal-content {
    display:inline-flex;
    background-color: white;
    padding: 1rem 1.5rem;
    width: 70%;
    border-radius: 0.5rem;
    border: 0.5px solid #000;
}
.close-button {
    width: 1.5rem;
    line-height: 1.5rem;
    text-align: center;
    cursor: pointer;
    border-radius: 0.25rem;
    background-color: #EDE734;
    display:inline-block;
    height:50%;
    margin-right:7px;
</style>";
	
	
	
	









		$this->assign("content", $content);

	}

}