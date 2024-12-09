<?php
require_once 'common/page.php';
require_once 'common/a_content.php';

use common\a_content;
use common\page;

class second extends a_content{

    private string $value;
    public function __construct(){
        parent::__construct();
        if (isset($_POST['data']))
            $this->value = htmlspecialchars($_POST['data']);
    }

    public function create_content(): void
    {
        if (isset($this->value)) print ($this->value);
        ?>
        <form method="get" action="<?php print($_SERVER['SCRIPT_NAME']);?>">
            <input type="text" name="data" />
            <input type="submit" value="Отправить"/>
        </form>
        <?php
    }
}

$p = new page(new second());