<div class="leftBar">  
    <!--<h1>Комментарии</h1>-->
    <?php foreach ($allNotesArr as $key => $value) : ?>
        <a href="<?php echo $value['url'] . '#' . $value['id'];?>" class="aAllNotes">
            <div class="divBlockAllNotes">
                <div class="divAllNotes"><b>ФИО: </b><?php echo $value['name']; ?></div> 
                <div class="divAllNotes"><b>Дата: </b><?php echo date('H:i:s d.m.Y', $value['curDate']); ?></div> 
                <!-- <div class="divAllNotes"><b>Дата: </b><?php echo $value['curDate']; ?></div>  -->
                <div class="divAllNotes"><b>Сообщение: </b>
                    <?php if (mb_strlen($value['message']) <= 50) : ?>
                    <?php echo $value['message']; ?>
                    <?php else : ?>
                    <?php echo mb_substr($value['message'], 0, 50) . '...'; ?>
                    <?php endif; ?>
                </div> 
            </div>
        </a>
    <?php endforeach; ?>
</div>
