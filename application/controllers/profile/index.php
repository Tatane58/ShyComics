<?php
	class Controller_profile_index extends Controller_index
	{
		use Trait_checkIdUser;

		public function get_index($id_user = null, $fromPage = null)
		{
			$member	=	$this->_getMemberFromId($id_user, 'profile/');

			if(empty($member))
				return;

			\Eliya\Tpl::set([
				'page_title'		=>	Library_i18n::get('profile.index.page_title', $member->prop('username')),
				'page_description'	=>	Library_i18n::get('profile.index.page_description', $member->prop('username')),
			]);

			$is_own_profile	=	false;
			$has_followed 	=	false;
			$tpl_follow 	= 	null;
			
			if($this->_current_member->isConnected() && ! $this->_current_member->equals($member))
			{
				$is_own_profile		=	$this->_current_member->equals($member);
				$has_followed 		=	$member->isFollowedByUser($this->_current_member);
				
				$tpl_follow	=	\Eliya\Tpl::get('profile/details/follow', [
					'is_own_profile'	=> $is_own_profile,
					'has_followed'		=> $has_followed,
					'user_id'			=> $member->getId(),
				]);
			}
            
            if($member->prop('sexe') == Model_Users::GENDER_MALE)
                $sexe = Library_i18n::get('login.register.helpers.sexe.male');
            elseif($member->prop('sexe') == Model_Users::GENDER_FEMALE)
                $sexe = Library_i18n::get('login.register.helpers.sexe.female');
            else
                $sexe = Library_i18n::get('login.register.helpers.sexe.undefined');
            
			$view	=	\Eliya\Tpl::get('profile/index', [
				'user_id'		    => $member->getId(),
				'user_name'		    => $member->prop('username'),
				'user_avatar'	    => $member->getAvatarURL(),
				'user_age'	        => $member->getAge()[0]->age,
				'user_sexe'	        => $sexe,
				'user_interest'	    => $member->prop('interest'),
				'user_about'	    => Library_Parser::parse($member->prop('about'), $this->request->getBaseURL()),
				'user_sub_date'	    => $member->getSubDate(),
				'user_last_login'	=> $member->getLastLogin(),
				'tpl_follow'	    => $tpl_follow,
				'user_follows'	    => $member->load('follows')
			]);
			$this->response->set($view);
		}
	}