<?php 

class controller_component_core_backup extends component {
	public function action_index() {
		$this->data['backups'] = array();
		
		$backups = $this->model->get_backups_list();
		
		foreach ($backups as $backup) {
			$this->data['backups'][] = array(
				'name'          => $backup,
				'href_download' => SITE_URL . '/temp/backups/' . $backup,
				'href_delete'   => SITE_URL . '/admin/backup/delete/del=' . $backup,
				'href_restore'  => SITE_URL . '/admin/backup/restore/res=' . $backup,
				'date'          => date('d.m.Y H:i', filemtime(ROOT_DIR . '/temp/backups/' . $backup)),
				'size'          => round(filesize(ROOT_DIR . '/temp/backups/' . $backup) / 1024 / 1024, 2)
			);
		}
		
		$this->data['restore_backup'] = SITE_URL . '/admin/backup/restore';
		$this->data['create_backup'] = SITE_URL . '/admin/backup/create_backup';
		
		$this->page['title'] = 'Резервное копирование';
		$this->page['keywords'] = 'Резервное копирование';
		$this->page['description'] = 'Резервное копирование';
		$this->page['html'] = $this->load_view();
		return $this->page;
	}
	
	public function action_create_backup() {
		if (isset($_POST['type'])) {
			ini_set('max_execution_time', 300);
			
			$domain = parse_url(SITE_URL , PHP_URL_HOST);

			if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $domain, $list)) {
				$zip_name = $domain;
			} else {
				$zip_name = 'backup';
			}
			
			$zip_name .= '_' . date('Y-m-d_H-i_');
			
			if ($_POST['type'] === 'full') {
				$exceptions = array(
					'temp'
				);
				$zip_name .= 'full';
				
			} else {
				$exceptions = array(
					'temp', 'uploads'
				);
				$zip_name .= 'no_uploads';
			}
			
			foreach (scandir(ROOT_DIR . '/user_cms') as $path) {
				if (strpos($path, 'install') === 0 && is_readable(ROOT_DIR . '/user_cms/' . $path)) {
					$install_content = file_get_contents(ROOT_DIR . '/user_cms/' . $path);
					file_put_contents(ROOT_DIR . '/install.php', $install_content);
					break;
				}
			}
			
			$this->create_backup($zip_name, $exceptions);
			
			if (file_exists(ROOT_DIR . '/install.php')) {
				@unlink(ROOT_DIR . '/install.php');
			}
			
			$this->redirect(SITE_URL . '/admin/backup');
		}
		
		$this->page['title'] = 'Резервное копирование';
		$this->page['keywords'] = 'Резервное копирование';
		$this->page['description'] = 'Резервное копирование';
		$this->page['html'] = $this->load_view('backup_form');
		return $this->page;
	}
	
	protected function create_backup ($archive_name, $exceptions = array()) {
		$this->load_helper('zip');
		$zip = new ZipArchive();
		$zip->open(ROOT_DIR . '/temp/backups/' . $archive_name . '.zip', ZIPARCHIVE::CREATE);
		foreach (scandir(ROOT_DIR) as $path) {
			if ($path == '.' || $path == '..') {
				continue;
			}
			
			if (!is_dir(ROOT_DIR . '/' . $path)) {
				$zip->addFile(ROOT_DIR . '/' . $path, $path);
				continue; 
			}

			if (in_array($path, $exceptions)) {
				$zip = $this->helper_zip->zip_directory(ROOT_DIR . '/' . $path . '/', $zip, $path, false);
			} else {
				$zip->addEmptyDir($path);
				$zip = $this->helper_zip->zip_directory(ROOT_DIR . '/' . $path . '/', $zip, $path);
			}
		}
		$zip->close();
	}
	
	public function action_delete() {
		if (isset($this->url['params']['del']) && file_exists(ROOT_DIR . '/temp/backups/' . $this->url['params']['del']) && is_writable(ROOT_DIR . '/temp/backups/' . $this->url['params']['del'])) {
			unlink(ROOT_DIR . '/temp/backups/' . $this->url['params']['del']);
		}

		$this->redirect(SITE_URL . '/admin/backup');
	}
	
	public function action_restore() {
		$this->data['errors'] = array();
		$this->data['success'] = array();
		$archive_types = array(
			'application/force-download',
			'application/x-zip-compressed',
			'application/zip',
			'application/x-zip',
			'multipart/x-zip',
			'application/octet-stream'
		);
		
		$file = null;

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && is_uploaded_file($_FILES['backup']['tmp_name'])) {
			if(!in_array($_FILES['backup']['type'], $archive_types)) {
				$this->data['errors'][] = 'Выбранный файл не является архивом ZIP';
			} elseif (move_uploaded_file($_FILES['backup']['tmp_name'], ROOT_DIR . '/temp/backups/' . $_FILES['backup']['name'])) {
				$file = ROOT_DIR . '/temp/backups/' . $_FILES['backup']['name'];
			} else {
				$this->data['errors'][] = 'Не удалось переместить файл. Проверьте доступна ли для записи папка /temp/backups';
			}
		} elseif (isset($this->url['params']['res'])) {
			$file = ROOT_DIR . '/temp/backups/' . $this->url['params']['res'];
		} else {
			$this->page['html'] = $this->load_view('restore_form');
			return $this->page;
		}
		
		if ($file) {
			$zip = new ZipArchive;
			
			if ($zip->open($file) === TRUE) {
				$zip->extractTo(ROOT_DIR . '/');
				$zip->close();
				$this->data['success'][] = 'Резервная копия восстановлена';
			} else {
				$this->data['errors'][] = 'Не удалось распаковать архив';
			}
		}

		return $this->action_index();
	}
}