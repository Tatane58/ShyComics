<?php
	class Controller_spritecomics_gallery extends Controller_index
	{
		public function get_index($id_user = null)
		{
			$member = Model_Users::getById($id_user);
			
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics &bull; Galerie',
			]);
			
			if(!empty($member))
			{
				$data = [
					'user_id'		=> $member->prop('id'),
					'user_name'		=> $member->prop('username'),
					'user_files'	=> $member->getFiles(),
					'user_dirs'	    => $member->getFilesDirs(),
					'user_dirs_all'	=> $member->getFilesDirsAll(),
				];
			}
			else
			{
				$data = [
					'user_id'		=> null,
					'user_name'		=> null,
					'user_files'	=> null,
					'user_dirs'	    => null,
					'user_dirs_all'	=> null,
				];
			}
			
			$view	=	\Eliya\Tpl::get('spritecomics/gallery', $data);
			$this->response->set($view);
		}
	}