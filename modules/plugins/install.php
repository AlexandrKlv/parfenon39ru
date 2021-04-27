<?php 

$data = array(
	'name' => 'Фидбэк-прот',
	'type' => 'plugin',
	'version' => '1.1',
	'dir'     => 'feedback_prot',
	'description' => 'Фидбэк-прот'
);

if($this->model->install_module($data)) {
	$this->data['message'] = 'Фидбэк успешно установлен';
} else {
	$this->data['errors'] = 'В ходе установки произошла ошибка';
}

 ?>