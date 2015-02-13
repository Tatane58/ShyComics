<?php

trait Trait_checkIdUser
{
	protected function _getMemberFromId($id_user, $path_to_redirect_if_empty_id)
	{
		if(empty($id_user))
		{
			$url	=	$this->request->getBaseURL() . $path_to_redirect_if_empty_id;

			// We can redirect only if users is connected
			if( ! empty($this->_current_member))
			{
				$this->response->redirect($url . $this->_current_member->getId());
				exit;
			}

			$this->response->error('Vous devez être connecté pour accéder à cette partie du site.', 403);
			return null;
		}

		$member = Model_Users::getById($id_user);

		if(empty($member))
		{
			$this->response->error('Le membre souhaité ne semble pas exister.', 404);
			return null;
		}

		return $member;
	}
}