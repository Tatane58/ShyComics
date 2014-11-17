<?php
	class Controller_spritecomics_addDir extends Controller_index
	{
		public function get_index()
		{
			\Eliya\Tpl::set([
				'page_title'		=>	'Sprites Comics',
			]);
			
			$view	=	\Eliya\Tpl::get('spritecomics/index');
			$this->response->set($view);
		}
		
		public function post_index($name = null, $description = null, $parent_file = null)
		{
			$return = Model_Files::addDir($name, $description, $parent_file);
			
			if($return == Model_Files::ERROR_UPLOAD)
			{
				echo "Erreur &bull; Le dossier n'a pas, ou a mal, été créé. Une erreur est donc survenue. Veuillez réessayer.";
			}
			
			$member = Model_Users::getById($_SESSION['connected_user_id']);
			
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