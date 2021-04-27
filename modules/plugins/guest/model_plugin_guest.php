<?php

	class model_plugin_guest extends model {

		// public function get_component_info($component) {
		// 	return $this->dbh->row("SELECT * FROM main WHERE component = '" . $this->dbh->escape($component) . "' LIMIT 1");
		// }

		function createTable() {
			$this->dbh->exec('CREATE TABLE IF NOT EXISTS `comments` (
				id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
				name VARCHAR(255) NOT NULL,
				phone VARCHAR(255) NOT NULL,
				usrEmail VARCHAR(255) NOT NULL,
				curDate DATETIME NOT NULL,
				message VARCHAR(511) NOT NULL,
				url VARCHAR(255) NOT NULL,
				city VARCHAR(255) NOT NULL
			)');
			$this->dbh->exec('CREATE TABLE IF NOT EXISTS `answers` (
				id INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
				id_q INTEGER NOT NULL,
				curDate DATETIME NOT NULL,
				answer VARCHAR(255) NOT NULL
			)');			
		}

		function insertAnswer($id_q, $curDate, $answer) {
			$this->dbh->exec('INSERT INTO `answers` (
					id_q,
					curDate,
					answer
					)
				VALUES (
					"' . $id_q . '",
					"' . $curDate . '",
					"' . $answer . '"
			)');
		}

		function insertNote($name, $phone, $usrEmail, $curDate, $message, $url, $city) {
			$this->dbh->exec('INSERT INTO `comments` (
					name,
					phone,
					usrEmail,
					curDate,
					message,
					url,
					city
					)
				VALUES (
					"' . $name . '",
					"' . $phone . '",
					"' . $usrEmail . '",
					"' . $curDate . '",
					"' . $message . '",
					"' . $url . '",
					"' . $city . '"
			)');
		}

		function readNotes($page) {
			if ($page!='/') {
				$page.='/index';
			}
			$sql = 'SELECT * FROM `comments` WHERE url = "' . $page . '" ORDER BY `curDate` DESC';
			return $this->dbh->query($sql);
		}		
		function readAnswers() {
			$sql = 'SELECT * FROM `answers`';
			return $this->dbh->query($sql);
		}
		function lastMessage($name, $phone, $curDate, $message, $url) {
			$sql = 'SELECT `id`, `url`, `usrEmail` FROM `comments` WHERE name = "' . $name . '" AND phone = "' . $phone . '" AND curDate = "' . $curDate . '"AND message = "' . $message . '" AND url = "' . $url . '" ORDER BY `id` DESC LIMIT 1';
			return $this->dbh->query($sql);
		}
		function getMailAndUrl($sendAnswer) {
			$sql = 'SELECT `usrEmail`, `url` FROM `comments` WHERE id = "' . $sendAnswer . '" LIMIT 1';
			return $this->dbh->query($sql);
		}
		function deleteNote($noteId) {
			$this->dbh->exec('DELETE FROM `comments` WHERE id = "' . $noteId . '"');
			$this->dbh->exec('DELETE FROM `answers` WHERE id_q = "' . $noteId . '"');
		}		
		function deleteAnswer($id_q) {
			$this->dbh->exec('DELETE FROM `answers` WHERE id_q = "' . $id_q . '"');
		}
		
		public function action_activate() {
			$this->page['html'] = '';
			return $this->page;
		}
		
		public function action_deactivate() {
			
		}

	}

?>