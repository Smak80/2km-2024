<?php
require_once 'common/page.php';
require_once 'common/a_content.php';

use common\a_content;
use common\page;

class second extends a_content{
    public function create_content()
    {
        ?>
        ЭТО СТРАНИЦА №2
        <?php
    }
}

$p = new page(new second());