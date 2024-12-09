<?php
require_once './common/a_content.php';
require_once './common/page.php';
use common\a_content;
use common\page;

class paginating_page extends \common\a_content
{
    private int $max_file_size = 102400;
    private string $error_msg;
    public function __construct()
    {
        parent::__construct();
        try {
            $this->upload_file();
        } catch (\Exception $e) {
            $this->error_msg = $e->getMessage();
        }
    }
    public function create_content(): void
    {
        if (isset($this->error_msg)){
            $this->show_error($this->error_msg);
        }
        ?>
            <div class="container">
                <form action="<?php print($_SERVER['SCRIPT_NAME']);?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="102400">
                <div class="row justify-content-evenly">
                    <div class="col-auto">
                        <label for="file" class="text-primary">Укажите файл для загрузки: </label>
                        <input type="file" name="file" id="file" class="text-bg-secondary text-white">
                    </div>
                    <div class="col-auto">
                        <input type="submit" value="Отправить" class="btn-primary">
                    </div>
                </div>
                    <input type="hidden" name="form_sent" value="true">
                </form>
            </div>
        <?php
    }

    /**
     * @throws Exception
     */
    private function upload_file(): void
    {
        if ($this->is_form_sent()){
            $upload_dir = 'uploads/';
            if (isset($_FILES['file'])) {
                if ($_FILES['file']['size'] > $this->max_file_size) {
                    throw new Exception("Файл слишком большой. Загрузить не получится. :(");
                }
                $upload_file = $upload_dir . basename($_FILES['file']['name']);
                if (!@move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
                    throw new Exception("Ошибка загрузки файла");
                }
            }
        }
    }
}

new page(new paginating_page());