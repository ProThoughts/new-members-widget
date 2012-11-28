<?php
/*
*	Q2AM New Member Widget
*
*	Add newly registered members avatar widget.
*	File: Plugin output
*	
*	@author			Q2A Market
*	@category		Plugin
*	@Version: 		1.0
*	
*	@Q2A Version	1.5.3
*
*	Do not modify this file unless you know what you are doing
*/

class qa_html_theme_layer extends qa_html_theme_base {

	// registering scripts and css
	function head_css()
	{
		qa_html_theme_base::head_css();
		
		$stylesheet_path = qa_opt('site_url').'qa-plugin/new-members-widget/';
		
        $this->output('<LINK REL="stylesheet" TYPE="text/css" HREF="'.$stylesheet_path.'qa-new-members.css"/>');

	}

	function head_script() {

		qa_html_theme_base::head_script();

		$this->output('
			<SCRIPT TYPE="text/javascript">
				$(function() {
					$(".qa-new-member-avatar").hover(function() {
						$(this).find(".hover-cont").fadeIn("fast");
					}, function() {
						$(this).find(".hover-cont").fadeOut("fast");
					});
				});
			</SCRIPT>
		');
	}

}