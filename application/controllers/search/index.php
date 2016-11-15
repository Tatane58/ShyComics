<?php
	class Controller_search_index extends Controller_main
	{
		public function post_index($search = null)
		{
			$result = Model_Files::search($search);

            $view	=	\Eliya\Tpl::get('search/index', [
                'resultsUsers' => $result[0],
                'resultsFiles' => $result[1],
            ]);
            $this->response->set($view);
		}
	}