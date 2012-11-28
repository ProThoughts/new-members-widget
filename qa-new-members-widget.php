<?php
/*
*	Q2AM New Member Widget
*
*	Add newly registered members avatar widget.
*	File: Plugin widget and options
*	
*	@author			Q2A Market
*	@category		Plugin
*	@Version: 		1.0
*	
*	@Q2A Version	1.5.3
*
*	Do not modify this file unless you know what you are doing
*/

class qa_new_members_widget {

	var $urltoroot;
	
	function option_default($option) {		
		
		switch($option) {
			case 'member_count':
				return '5';

			case 'q2am_show_hover':
				return true;
			
			default:
				return null;
		}
	
	}
	
	function admin_form(){
	
		$saved = false;
		
		if(qa_clicked('new_members_widget_save_button')) {
		
			qa_opt('new_members_widget_title', qa_post_text('new_members_widget_title'));
			qa_opt('member_count', qa_post_text('member_count'));
			qa_opt('q2am_show_hover', (bool)qa_post_text('q2am_show_hover'));
			
			$saved = true;
		
		} else if (qa_clicked('new_members_widget_reset_button')) {
		
			foreach($_POST as $i => $v) {
			
				$def = $this->option_default($i);
				if($def !== null) qa_opt($i, $def);
			
			}
			
			$saved = qa_lang('admin/options_reset');
		
		}
		
		
		// defining options fields
		return array(
		
			'ok' => $saved ? 'Q2AM New Members Widget Settings Saved' :
			null,
			
			'fields' => array(
			
				array(
					'label' => 'Q2AM new members widget title',
					'tags' => 'NAME="new_members_widget_title"',
					'value' => qa_opt('new_members_widget_title'),
				),
				
				array(
					'label' => 'Member count',
					'tags' => 'NAME="member_count"',
					'value' => qa_opt('member_count'),
					'type' => 'number',				
				),
				
				
				array(
					'label' => 'Show hover details',
					'tags' => 'NAME="q2am_show_hover"',
					'value' => qa_opt('q2am_show_hover'),
					'type' => 'checkbox',
				),				
				
				array(
					'type' => 'blank',
				),			
				
			),
			
			'buttons' => array(
				array(
					'label' => 'Save Changes',
					'tags' => 'NAME="new_members_widget_save_button"',
				),
				array(
					'label' => 'Reset',
					'tags' => 'NAME="new_members_widget_reset_button"',
				),
			),
		
		);
	
	} // end admin_form()
	
	
	// setting template
	function allow_template($template){
	
		$allow = false;
		
		switch ($template)
		{
		
			case 'activity':
			case 'qa':
			case 'questions':
			case 'hot':
			case 'ask':
			case 'categories':
			case 'question':
			case 'tag':
			case 'tags':
			case 'unanswered':
			case 'user':
			case 'users':
			case 'search':
			case 'admin':
			case 'custom':
			
				$allow = true;
				break;
		
		}
		
		return $allow;
	
	}
	
	
	// setting region
	function allow_region($region){
	
		$allow = false;

		switch ($region)
		{
			case 'main':
			case 'side':
			case 'full':
			
				$allow = true;
				break;
		}

		return $allow;
	
	}
	
	
	// widget output to front end
	function output_widget($region, $place, $themeobject, $template, $request, $qa_content) {
		
		$query = "SELECT userid,email,handle,avatarblobid,avatarwidth,avatarheight,flags,created
		FROM ^users
		ORDER BY userid
		DESC LIMIT 0, ".qa_opt('member_count')."";			

		$query_fetch = qa_db_query_sub($query);			
				

		if ($region=='side') {			
			
			$widget_title = qa_opt('new_members_widget_title');
		
			if (!empty ($widget_title)){			
				$themeobject->output(
					'<H2 STYLE="margin-top:0; padding-top:0;">',
					$widget_title,
					'</H2>'
				);
			}
			
			$themeobject->output(
				'<DIV CLASS="qa-new-members"> <!-- qa-new-members-->', 
				'<UL CLASS="qa-new-members-list clearfix"> <!-- qa-new-members-list-->'
			);
				
			while ( ($member = qa_db_read_one_assoc($query_fetch,true)) !== null ) {
				// do not list blocked users
				if (!(QA_USER_FLAGS_USER_BLOCKED & $member['flags'])) {

					$original_date = substr($member['created'],0,11);
					$new_date = date('M d, Y', strtotime($original_date));
					
					$themeobject->output('<LI CLASS="qa-new-member-avatar" STYLE="height:'.qa_opt('avatar_users_size').'">');
					
						$themeobject->output(qa_get_user_avatar_html($member['flags'], $member['email'], $member['handle'], $member['avatarblobid'], $member['avatarwidth'], $member['avatarheight'], qa_opt('avatar_users_size'), false));
						
					if(qa_opt('q2am_show_hover')){
						$themeobject->output('<DIV CLASS="hover-cont">');
						
							$themeobject->output(qa_get_one_user_html($member['handle'], false));					
							$themeobject->output('<P> Registerd on ', $new_date, '</P>');									
						$themeobject->output('</DIV>');
					}
                    
                    $themeobject->output('</LI>');
                    					
				}
			}
				
			$themeobject->output(
				'</UL> <!-- END qa-new-members-list-->',
				'</DIV> <!-- END qa-new-members-->'
			);
		
		} else {		
			
			$widget_title = qa_opt('new_members_widget_title');
			
			if (!empty ($widget_title)){			
				$themeobject->output(
					'<H2>',
					$widget_title,
					'</H2>'
				);
			}
			
			$themeobject->output(
				'<DIV CLASS="qa-new-members"> <!-- qa-new-members-->', 
				'<UL CLASS="qa-new-members-list clearfix"> <!-- qa-new-members-list-->'
			);
				
			while ( ($member = qa_db_read_one_assoc($query_fetch,true)) !== null ) {
				// do not list blocked users
				if (!(QA_USER_FLAGS_USER_BLOCKED & $member['flags'])) {

					$original_date = substr($member['created'],0,11);
					$new_date = date('M d, Y', strtotime($original_date));
					
					$themeobject->output('<LI CLASS="qa-new-member-avatar" STYLE="height:'.qa_opt('avatar_users_size').'">');
					
						$themeobject->output(qa_get_user_avatar_html($member['flags'], $member['email'], $member['handle'], $member['avatarblobid'], $member['avatarwidth'], $member['avatarheight'], qa_opt('avatar_users_size'), false));
						
						
					if(qa_opt('q2am_show_hover')){
						$themeobject->output('<DIV CLASS="hover-cont">');
						
							$themeobject->output(qa_get_one_user_html($member['handle'], false));					
							$themeobject->output('<P> Registerd on ', $new_date, '</P>');									
						$themeobject->output('</DIV>');
					}
                    
                    $themeobject->output('</LI>');
                    					
				}
			}
				
			$themeobject->output(
				'</UL> <!-- END qa-new-members-list-->',
				'</DIV> <!-- END qa-new-members-->'
			);
		
		}
	
	}

}