<?php
require_once 'common/a_content.php';
require_once 'common/page.php';
use common\page;
use common\a_content;
class reg extends a_content
{
    private ?bool $reg = null;
    public function __construct()
    {
        parent::__construct();
        $this->is_opened = true;
        if($this->is_correct()===true){
            $f=fopen('data/users.db','w');
            fwrite($f,$this->get_post_data('login')
                .' '.password_hash($this->get_post_data('password'), PASSWORD_DEFAULT)
                .' '.$this->get_post_data('email')
                .' '.$this->get_post_data('name')
            );
            fclose($f);
        }

    }
    private function is_correct(): bool
    {
        /*1.проверить логин содержит только англ буквы и цифры. Начинается с буквы.+
        2. проверяем пароль не короче 8 симв +
        3. проверяем совпадает ли пароли с повторите пароль+
        4. Не пустые ли все поля +
        5. почта похожа на шаблон почты+
        */
        if($this->get_post_data('login')===''
            || $this->get_post_data('password')===''
            || $this->get_post_data('email')===''
            || $this->get_post_data('name')===''){
            return false;
        }
        if (@mb_ereg('[A-Za-z][A-Za-z0-9]*', $this->get_post_data('login')) === false) {
            return false;
        }
        if (@mb_ereg('.{8}.*', $this->get_post_data('password')) === false) {
            return false;
        }
        if($this->get_post_data('password')!==$this->get_post_data('password2')){
            return false;
        }
        if (@mb_eregi('^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$', $this->get_post_data('email')) === false) {
            return false;
        }
        return true;
    }
    public function create_content(): void
    {
        ?>
        <div class="container border border-primary border-1 w-50 mb-3">
            <form method="post" action="<?php print $_SERVER['SCRIPT_NAME']?>">

                <div class="row w-100 m-auto">
                    <div class="col-3 m-2">
                        <label for="login" class="form-control border-0">Введите логин:</label>
                    </div>
                    <div class="col-8 m-2">
                        <input type="text" name="login" value="<?php print($this->get_post_data('login')); ?>" id="login" class="form-control" placeholder="MyLogin"/>
                    </div>
                </div>

                <div class="row w-100 m-auto">
                    <div class="col-3 m-2">
                        <label for="password" class="form-control border-0">Придумайте пароль:</label>
                    </div>
                    <div class="col-8 m-2">
                        <input type="password" name="password" value="<?php print($this->get_post_data('password')); ?>" id="password" class="form-control" placeholder="MyPassword"/>
                    </div>
                </div>

                <div class="row w-100 m-auto">
                    <div class="col-3 m-2">
                        <label for="password2" class="form-control border-0">Повторите пароль:</label>
                    </div>
                    <div class="col-8 m-2">
                        <input type="password" name="password2" value="<?php print($this->get_post_data('password2')); ?>" id="password2" class="form-control" placeholder="MyPassword"/>
                    </div>
                </div>

                <div class="row w-100 m-auto">
                    <div class="col-3 m-2">
                        <label for="name" class="form-control border-0">Введите своё имя:</label>
                    </div>
                    <div class="col-8 m-2">
                        <input type="text" name="name" value="<?php print($this->get_post_data('name')); ?>" id="name" class="form-control" placeholder="Вася"/>
                    </div>
                </div>

                <div class="row w-100 m-auto">
                    <div class="col-3 m-2">
                        <label for="email" class="form-control border-0">Введите свой e-mail:</label>
                    </div>
                    <div class="col-8 m-2">
                        <input type="email" name="email" value="<?php print($this->get_post_data('email')); ?>" id="email" class="form-control" placeholder="a@b.ru"/>
                    </div>
                </div>

                <div class="row w-100 m-auto text-center">
                    <div class="col mt-2 mb-2">
                        <input type="submit" class="btn-primary" value="Зарегистрироваться"/>
                    </div>
                </div>

            </form>
        </div>

        <div class="row">
            <div class="col text-center w-100">
                <a href='<?php print $this->get_auth_page(); ?>'>Вход</a>
            </div>
        </div>
        <?php
        if ($this->reg !== null) {
            if ($this->reg === true) {
                $this->show_success("Пользователь успешно авторизован!");
            } else {
                $this->show_error("Неверный логин или пароль!");
            }
        }
    }
}

new page(new reg());