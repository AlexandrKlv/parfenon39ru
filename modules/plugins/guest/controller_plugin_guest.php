<?php

	class controller_plugin_guest extends plugin {

		function __construct($config, $url, $plugin_name, $dbh) 
		{
			parent::__construct($config, $url, $plugin_name, $dbh);
	  		$this -> view_dir         = ROOT_DIR .          '/modules/plugins/'.$plugin_name.'/views';
	  		$this -> view_dir_core    = ROOT_DIR . '/user_cms/modules/plugins/'.$plugin_name.'/views';
	  		$this -> view_dir_simple  = '/modules/plugins/'.$plugin_name.'/views';
	  		$this -> page['html']             = '';
			$this -> page['head']             = '';
			$this -> plugin_dir            = ROOT_DIR . '/modules/plugins/'.$plugin_name.'/'.END_NAME;
			$this -> plugin_dir_core       = ROOT_DIR . '/user_cms/modules/plugins/'.$plugin_name.'/'.END_NAME;
			$this -> plugin_name           = $plugin_name;
			$this -> model                 = $this->load_model();
			$this -> url                 = $url;
			
	  	}

		function mailPro($mailTo, $mailFrom, $nameFrom, $subject, $text, $charset='utf-8') {
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= "Content-type: text/html; charset=".$charset."\r\n";
			$headers .= "From: =?".$charset."?b?" . base64_encode($nameFrom) . "?=" . " <".$mailFrom.">\r\n" ;
			if(mail($mailTo,$subject,$text,$headers)) {
				return true;
			} else {
				return false;
			}
		}

		public function action_index() 
		{
			$secret='3zIsF5lXok4W';
			// core::print_r($this -> url);
			// echo $_SERVER['REQUEST_URI'];
			// echo $_SERVER['SERVER_NAME'];
			// echo date('');
			// echo time();
			$this->page['title'] = 'Гостевая книга ' . SITE_NAME;
			$this->page['keywords'] = 'Гостевая книга';
			$this->page['description'] = 'Гостевая книга';

	  		
	  		//$page = $_SERVER['REQUEST_URI'];
	  		$page =  '/' . $this ->url['component'] .'/'. implode('/',$this ->url['actions']) ;
			$page = ($page == '//index') ? '/' : $page;
			// echo $page;
			$this->data['URI'] = $page;

			//$this->model->createTable();

			if (isset($_POST['deleteMessage'])) {
				$this->model->deleteNote($_POST['deleteMessage']);
				$this->data['success'] = '<div class="divInfo">Сообщение было удалено.</div>';
			} 			
			if (isset($_POST['deleteAnswer'])) {
				$this->model->deleteAnswer($_POST['deleteAnswer']);
				$this->data['success'] = '<div class="divInfo">Ответ был удален.</div>';
			} 

			if (!empty($_POST['answerArea']) && isset($_POST['sendAnswer'])) {
				$answer = '';
				foreach($_POST['answerArea'] as $textArea) {
					$answer .= htmlspecialchars($textArea);
				}
				$sendAnswer = htmlspecialchars($_POST['sendAnswer']);
				$curDate = date('Y-m-d H:i:s'); 
				$this->model->insertAnswer($sendAnswer, $curDate, $answer);
				$serverName = $_SERVER['SERVER_NAME'];
				$getMailAndUrl = $this->model->getMailAndUrl($sendAnswer);
				// print_r($getMailAndUrl);
				// echo $serverName . $getMailAndUrl[0]['url'] . '#' . $sendAnswer;
				$this->mailPro($getMailAndUrl[0]['usrEmail'], 'pro1@unibix.ru', 'robot', 'На сайте ' . $serverName . ' вам был дан ответ', 'Для просмотра на ответа вы можете перейти по <a style="font-size: 18px;" href="http://' . $serverName . $getMailAndUrl[0]['url'] . '#' . $sendAnswer . '">этой</a> ссылке.', $charset='utf-8');
				$this->data['success'] = '<div class="divInfo">Ответ добавлен.</div>';
			}

			if (isset($_POST['submit'])) {

				$name = htmlspecialchars($_POST['name']);
				$this->data['nameText'] = $name;
				$city = htmlspecialchars($_POST['city']);
				$this->data['cityText'] = $city;			
				$phone = htmlspecialchars($_POST['phone']);
				$this->data['phoneText'] = $phone;						
				$usrEmail = htmlspecialchars($_POST['usrEmail']);
				$this->data['usrEmailText'] = $usrEmail;			
				$message = htmlspecialchars($_POST['message']);
				$this->data['messageText'] = $message;

				$errors = array();

				// Проверка почты
				if (empty($usrEmail)) {
					$this->data['postError'] = 'Введите почту.';
					array_push($errors, $this->data['postError']);
				} elseif (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $usrEmail)) {
					$this->data['postError'] = 'Введенная почта некорректна.';
					array_push($errors, $this->data['postError']);
				}
				
				// Проверка телефона
				// $phoneCharArr = array('1', '2', '3', '4', '5' ,'6', '7', '8', '9', '0', '-', '+', ' ', '(', ')', '');
				// $phoneMatch = preg_split('//', $phone);  
				// $phonePushArr = array();
				// foreach ($phoneMatch as $key => $value) {
				// 	if (!in_array($value, $phoneCharArr)) {
				// 		array_push($phonePushArr, $value);
				// 	}
				// }
				// if (empty($phone)) {
				// 	$this->data['phoneError'] = 'Введите телефон.';
				// 	array_push($errors, $this->data['phoneError']);
				// } elseif (!empty($phonePushArr)) {
				// 	$this->data['phoneError'] = 'Введенный телефон некорректен.';
				// 	array_push($errors, $this->data['phoneError']);
				// }

				if (empty($city)) {
					$this->data['cityError'] = 'Введите город.';
					array_push($errors, $this->data['cityError']);
				}			

				if (empty($message)) {
					$this->data['messageError'] = 'Введите сообщение.';
					array_push($errors, $this->data['messageError']);
				}				

				if (empty($name)) {
					$this->data['nameError'] = 'Введите ваше имя.';
					array_push($errors, $this->data['nameError']);
				}

				if ($_POST['captcha'] != $_SESSION['captcha']) {
					$this->data['captchaError'] = 'Капча введена неверно.';
					array_push($errors, $this->data['captchaError']);
				}

				if (!empty($errors)) {
					$div = '<div class="divError">'; 
					foreach ($errors as $errText) {
						$div .= $errText . '<br>';
					}
					$div .= '</div>';
					$this->data['errorText'] = $div;
				} else {
					// $curDate = date('Y-m-d H:i:s'); 
					// $curDate = date(''); 
					$curDate = time(''); 
					$url = $_SERVER['REQUEST_URI'];
					$this->model->insertNote($name, $phone, $usrEmail, $curDate, $message, $url, $city);
					$this->data['success'] = '<div class="divSuccess">Спасибо за оставленный отзыв!</div>';

					$lastMessage = $this->model->lastMessage($name, $phone, $curDate, $message, $url);
					$dateLink = date('Y-m-d');
					$answerLink = 'http://' . $_SERVER['SERVER_NAME'] . '/' . mb_substr($lastMessage[0]['url'], 1) . '/autologin=1/date_comment=' . $dateLink . '/md5=' . md5($dateLink.$secret) . '#' . $lastMessage[0]['id'];
					$this->mailPro('pro1@unibix.ru, pro3@unibix.ru', 'info@unibix.ru', 'robot', 'На вашем сайте оставили сообщение', 'Для ответа на сообщение вы можете перейти по <a style="font-size: 18px;" href="' . $answerLink . '">этой</a> ссылке.');

					$this->data['nameText'] = '';
					$this->data['cityText'] = '';			
					$this->data['phoneText'] = '';			
					$this->data['usrEmailText'] = '';			
					$this->data['messageText'] = '';
				}
			
			}		

			if (mb_strpos($page, '/index') !== FALSE) {
				// echo mb_strpos($page, '/index');
				$pageLen = mb_strlen($page);
				$pageForResult = mb_substr($page, 0, $pageLen-6);
				// echo $pageForResult;
			} else {
				$pageForResult = $page;
			}
			// echo '<pre>';
			// echo $page;
			// print_r($results);
			// echo '</pre>';

			// Вывод сообщений из БД
			$results = $this->model->readNotes($pageForResult);
			$resultAnswers = $this->model->readAnswers();
			$this->data['resultAnswers'] = $resultAnswers;
			// $answersArr = array(
					// 'id' => array(),
					// 'answer' => array()
				// );

			$answersArr = array();
			foreach ($resultAnswers as $item) {
				if (!isset($answersArr[ $item['id_q'] ])) {
					$answersArr[ $item['id_q'] ] = '';
					$answersArr[ $item['id_q'] ] .= $item['answer'];
				}
			}

			// echo '<pre>';
			// print_r($answersArr);
			// echo '</pre>';

			if ((!empty($_SESSION['access']) && $_SESSION['access'] == 2) 
				OR 
				(isset($this->url['params']['autologin'])
				&&
					strtotime($this->url['params']['date_comment']) > time() - 3600*24*7
				&& 
					md5($this->url['params']['date_comment'].$secret) == $this->url['params']['md5'] //
				) 
			) {	
				$this->data['show_form'] = TRUE;
			} else {
				$this->data['show_form'] = FALSE;
			}
			// echo md5($this->url['params']['date_comment'].$secret);
			// print_r($answersArr);
			$this->data['answersArr'] = $answersArr;

			// $rgOutput = array();
			// foreach ($resultAnswers as $singleAnswer) {
			// 	// echo '<pre>';
			// 	// print_r($singleAnswer);
			// 	// echo '</pre>';
			// 	$rgOutput[ $singleAnswer['id_q'] ] = '';
			// 	if (!isset($rgOutput[ $singleAnswer['id_q'] ])) {
			// 		$rgOutput[ $item['id_q'] ] = '';
			// 		$rgOutput[ $item['id_q'] ] .= $item['answer'];
			// 	}
			// }
			// print_r($rgOutput);

			// foreach ($resultAnswers as $singleAnswer) {
				// print_r($singleAnswer) . '<br>';
				// echo $singleAnswer['id_q'] . '<br>';
			// }
			// print_r($resultAnswers);

			$showMessage = array(
				'id' => array(),
				'curDate' => array(),
				'name' => array(),
				'message' => array(),
				'phone' => array(),
				'usrEmail' => array(),
				'city' => array()				
			);
			foreach ($results as $row) {
				array_push($showMessage['id'], $row['id']);	
				array_push($showMessage['curDate'], $row['curDate']);	
				array_push($showMessage['name'], $row['name']);	
				array_push($showMessage['city'], $row['city']);	
				array_push($showMessage['phone'], $row['phone']);	
				array_push($showMessage['usrEmail'], $row['usrEmail']);	
				array_push($showMessage['message'], $row['message']);	
			}
			$countArr = count($showMessage['id']); 
			$this->data['countArr'] = $countArr;
			$this->data['num'] = 0;
			$this->data['showMessage'] = $showMessage;

			$this->data['viewDir'] = $this->view_dir_simple;
		
			$this->page['head'] = $this->add_css_file(SITE_URL . '/modules/plugins/guest/views/guest.css');
			$this->page['html'] = $this->load_view();
			return $this->page;
		}
	}
	
?>