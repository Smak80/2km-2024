<?php
require_once 'common/page.php';
require_once 'common/a_content.php';

use common\a_content;
use common\page;

class index extends a_content{

    function __construct() {
        parent::__construct();
        $this->is_opened = true;
    }
    public function create_content()
    {
        ?>
        ЭТО СТАРТОВАЯ СТРАНИЦА НАШЕГО САЙТА
        <?php
    }
}

$p = new page(new index());