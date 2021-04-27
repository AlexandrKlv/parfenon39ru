<?php

	class controller_component_search extends component {
	
		public function action_index() {
			$this->page['title'] = 'Поиск ' . SITE_NAME;
			$this->page['keywords'] = 'Поиск';
			$this->page['description'] = 'Поиск';

			// mb_internal_encoding('utf-8');
			if (!empty($_POST['siteSearch'])) {
				// echo $_POST['siteSearch'];
			}

			$search_info = $this->model->get_component_info('search');
			$this->data['page_name'] = $search_info['name'];
			// echo $search_info['name'];

			if (isset($_POST['submit']) && !empty($_POST['search']) || !empty($_POST['siteSearch'])) {

				$getUrl = $this->model->get_pages();
				$getText = $this->model->get_text();

				$serverName = $_SERVER['SERVER_NAME'];
				$this->data['serverName'] = $serverName;

				if (!empty($_POST['search'])) {
					$search = htmlspecialchars($_POST['search']);
				} elseif (!empty($_POST['siteSearch'])) {
					$search = htmlspecialchars($_POST['siteSearch']);
				}
				// $search = htmlspecialchars($_POST['search']);
				// echo $search;
				$this->data['searchText'] = $search;

				$pagesFound = array(
					'title' => array(),
					'url' => array(),
					'realUrl' => array(),
					'text' => array()
					);

				foreach ($getText as &$text) {
					foreach ($getUrl as $url) {
						if ($text['date_add'] == $url['date_add']) {
							$text['url'] = $url['url'];
						}
					}
				}

				// echo '<pre>';
				// print_r($getText);
				// echo '</pre>';

				foreach ($getText as $value) {
					// echo $value['text'] . '<br>';
					// echo mb_stripos($value['title'], $search) . '<br>';
					// print_r($value);
					if (mb_stripos($value['title'], $search) !== FALSE || mb_stripos($value['text'], $search) !== FALSE) {
						// echo '1' . '<br>';
						$strippedText = strip_tags($value['text']);
						$strippedTitle = strip_tags($value['title']);
						array_push($pagesFound['title'], $this->model->search_word_replace($search, $strippedTitle));
						array_push($pagesFound['url'], $this->model->divideUrl($serverName, $value['url']));
						array_push($pagesFound['realUrl'], $value['url']);
						// preg_match('/[А-ЯЁ][^А-ЯЁ]*федерация.*/u', $stripped, $textOutArr);
						$textReplace = $this->model->search_word_replace($search, $strippedText);
						preg_match('/[А-ЯЁ]?[^А-ЯЁ]*' . mb_strtolower($search) . '.*/u', $textReplace, $textOutArr);
						if (!empty($textOutArr[0])) {
							$textReplace = $textOutArr[0];
						}
						// preg_match('/[А-ЯЁ][^А-ЯЁ]*' . $search . '.*/u', $value['text'], $textOutArr);
						// print_r($textOutArr);
						// echo $textOutArr[0];
						// echo $this->model->search_word_replace($search, $strippedTitle);
						// echo $this->model->get_search_text($search, $stripped) . '<br>';
						// echo '<pre>';
						// print_r($textOutArr);
						// echo '</pre>';
						// if (empty($textOutArr)) {
						// 	$textCut = $stripped;
						// } else {
						// 	$textCut = $textOutArr[0];
						// }
						if (mb_strpos($textReplace, '{plugin:feedback=') !== FALSE) {
							// preg_replace('/{plugin:feedback=[0-9]+[}]/ui', '//', $textOut);
							// echo $textOut;
							$textReplace = preg_replace('/{plugin:feedback=[0-9]+[}]/ui', '', $textReplace);
						}
						if (mb_strlen($textReplace) >= 230) {
							$textReplace = mb_substr($textReplace, 0, 230) . '...';
						} else {
							$textReplace = $textReplace;
						}
						array_push($pagesFound['text'], $textReplace);							
					}
				}

				$countArr = count($pagesFound['title']);
				$this->data['countArr'] = $countArr;
				$this->data['pagesFound'] = $pagesFound;

				// echo '<pre>';
				// print_r($pagesFound);
				// echo '</pre>';

				if (count($pagesFound['title']) === 0) {
					$this->data['emptyText'] = 'По запросу <b>' . $search . '</b> ничего не найдено.';	
				}

 			} elseif (isset($_POST['submit']) && empty($_POST['search']) || empty($_POST['siteSearch'])) {

				$this->data['emptyText'] = 'Введите фразу для поиска.';	
 			
 			}

			$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/components/search/front_end/views/search.css');
			$this->page['html']  = $this->load_view();
			return $this->page;
		}

	}
	
?>