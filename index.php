<?php
require_once 'common/page.php';
require_once 'common/a_content.php';

use common\a_content;
use common\page;

class index extends a_content{
    public function create_content()
    {
        ?>
        ЭТО СТАРТОВАЯ СТРАНИЦА НАШЕГО САЙТА
        <?php
    }
}

$p = new page(new index());