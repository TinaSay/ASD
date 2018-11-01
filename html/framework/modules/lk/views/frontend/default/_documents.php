<?php
/** @var $documents array */
?>
<?php if (!empty($documents)) : ?>
    <?php foreach ($documents as $key => $row) : ?>
        <li>
            <a href="<?= $row['url'] ?>">
                <div class="lk-doc__inner">
                    <div class="left">
                        <span class="type pdf"><?= $row['ext']['extension'] ?></span>
                        <span class="name"><?= $row['ext']['filename'] ?></span>
                    </div>
                    <div class="right">
                        <span class="size"><?= round($row['size'] / 1024) ?>кб</span>
                        <span class="download icon-download"></span>
                    </div>
                </div>
            </a>
        </li>
    <?php endforeach; ?>
<?php endif; ?>