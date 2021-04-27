<div class="guest-comments"><h3>Вопросы и комментарии</h3>
<form method="post" action="<?php echo $URI; ?>#comments" id="showTextForm">
<table id="guestTable">
	<?php while($num < $countArr) : ?>
	<?php if ($num < 5) : ?>
		<tr>
	<?php else : ?>
		<tr class="hiddenTR">
	<?php endif; ?>
		<td class="dataMessage" id="td_#<?php echo $showMessage['id'][$num]; ?>">
			<a id="<?php echo $showMessage['id'][$num] ?>"></a>
			<a id="comments"></a>
			<b>Дата: </b><?php echo date('H:i:s d.m.Y', $showMessage['curDate'][$num]); ?><br>
			<!-- <b>Дата: </b><?php echo $showMessage['curDate'][$num]; ?><br> -->
			<b>Имя: </b><?php echo $showMessage['name'][$num]; ?><br>
			<!-- <?php if ($show_form) : ?>
				<b>Телефон: </b><?php echo $showMessage['phone'][$num]; ?><br>
				<b>Email: </b><?php echo $showMessage['usrEmail'][$num]; ?><br>
			<?php endif; ?> -->
			<!-- <b>Город: </b><?php echo $showMessage['city'][$num]; ?><br> -->
			<b>Сообщение: </b><?php echo $showMessage['message'][$num]; ?>
			<?php foreach ($answersArr as $id_q => $answer) : if ($id_q == $showMessage['id'][$num]) : ?>
				<div class="divAnswer"><b>Ответ: </b>
					<?php echo $answer; ?> 
					<?php if (!empty($_SESSION['access']) && $_SESSION['access'] == 2) : ?>
						<button class='deleteAnswer' name='deleteAnswer' value="<?php echo $id_q; ?>">Удалить</button>
					<?php endif; ?>
				</div>
			<?php endif; endforeach; ?>
			<?php if ($show_form) : ?>
				<div class="buttons-comments-edit">
					<button class="questionBtn" name="deleteMessage" value="<?php echo $showMessage['id'][$num]; ?>">Удалить</button>
					<input type="button" name="answer" id="btn_<?php echo $showMessage['id'][$num]; ?>" onclick='showAnswer(this,<?php echo $showMessage['id'][$num]; ?>)' value="Открыть форму ответа" class="showTextarea">
					<div class="showAnswer" id="hdn_<?php echo $showMessage['id'][$num]; ?>">
						<textarea name="answerArea[]" class="textareaForAnswer"></textarea>
						<button class="questionBtn" name="sendAnswer" value="<?php echo $showMessage['id'][$num]; ?>">Ответить</button>
					</div>
				</div>
			<?php endif; ?>
		<?php $num++; ?>
		</td>
	</tr>
	<?php endwhile; ?>
	<?php if ($countArr > 5) : ?>
	<tr>
		<td style="text-align: center;">
			<input type="button" value="Показать остальные отзывы" class="questionBtn" onclick='showAll(this)'>
		</td>
	</tr>
	<?php endif; ?>
</table>
</form>
<?php if (!empty($errorText)) { echo $errorText; } elseif (!empty($success)) { echo $success; }?>
<form name="good-comment" method="post" action="<?php echo $URI; ?>#comments">
	<h3 class="head1">Задайте вопрос или оставьте отзыв:</h3>
	<table id="tableGuest">
		<tr><td>Введите ваше ФИО: *</td><td><input type="text" name="name" value="<?php if (!empty($nameText)) { echo $nameText; } ?>"></td></tr>
		<tr><td>Ваш город: *</td><td><input type="text" name="city" value="<?php if (!empty($cityText)) { echo $cityText; } else { echo 'Калининград'; } ?>"></td></tr>
		<tr><td>Ваш телефон: </td><td><input type="text" name="phone" value="<?php if (!empty($phoneText)) { echo $phoneText; } ?>"></td></tr>
		<tr><td>Ваш email: *</td><td><input type="text" name="usrEmail" value="<?php if (!empty($usrEmailText)) { echo $usrEmailText; } ?>"></td></tr>
		<tr><td>Ваш отзыв или вопрос: *<br>
		</td><td><textarea name="message"><?php if (!empty($messageText)) { echo $messageText; } ?></textarea></td></tr>
		<tr><td>Введите буквы на изображении (капчу): *</td><td><img src="<?php echo $viewDir; ?>/captcha.php" alt="Капча" id="imgCapth"><input type="text" name="captcha" id="textCapth"></td></tr>
		<tr><td colspan=2><input type="submit" name="submit" id="submit" value="Отправить"></td></tr>
	</table>
	<sub>* - обязательные для заполнения поля.</sub>
</form>
<script>

	if (window.location.hash) {
		// alert(window.location.hash);
		document.getElementById('td_' + window.location.hash).className = 'selectedTd';
		// document.getElementById('hdn_'+id).className = 'showAnswerExp';
	};

	function showAnswer(Obj,id) {
		if (Obj.value == 'Открыть форму ответа') {
	        Obj.value = 'Закрыть форму ответа';
	        document.getElementById('hdn_'+id).className = 'showAnswerExp';
	    } else {
	        Obj.value = 'Открыть форму ответа';
	        document.getElementById('hdn_'+id).className = 'showAnswer';
	    }
	}

	function showAll(Obj){
		var hiddenTR = document.querySelectorAll('tr.hiddenTR');
		if (Obj.value == 'Показать остальные отзывы') {
			Obj.value = 'Скрыть остальные отзывы';
		    for (var i = 0; i < hiddenTR.length; i++) {
		        hiddenTR[i].style.display = 'block';
		    }
		} else {
			Obj.value = 'Показать остальные отзывы';
			for (var i = 0; i < hiddenTR.length; i++) {
		        hiddenTR[i].style.display = 'none';
		    }
		}
	}
</script></div>