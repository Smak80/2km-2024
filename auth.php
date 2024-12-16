<?php
require_once 'common/a_content.php';
require_once 'common/page.php';
use common\page;
class auth extends \common\a_content
{
    private string $correct_login = "user";
    private string $correct_password = "password";
    private ?bool $auth;

    public function __construct(){
        parent::__construct();
        $this->auth = $this->auth();
    }

    private function auth(): bool|null{
        $login = $this->get_post_data('login');
        $password = $this->get_post_data('password');
        if ($login !== '')
            return $login === $this->correct_login && $password === $this->correct_password;
        return null;
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
                        <input type="text" name="login" id="login" class="form-control" placeholder="MyLogin"/>
                    </div>
                </div>

                <div class="row w-100 m-auto">
                    <div class="col-3 m-2">
                        <label for="password" class="form-control border-0">Введите пароль:</label>
                    </div>
                    <div class="col-8 m-2">
                        <input type="password" name="password" id="password" class="form-control" placeholder="MyPassword"/>
                    </div>
                </div>

                <div class="row w-100 m-auto text-center">
                    <div class="col mt-2 mb-2">
                        <input type="submit" class="btn-primary" value="Войти"/>
                    </div>
                </div>

            </form>
        </div>
        <?php
        if ($this->auth !== null) {
            if ($this->auth === true) {
                $this->show_success("Пользователь успешно авторизован!");
            } else {
                $this->show_error("Неверный логин или пароль!");
            }
        }
    }
}

new page(new auth());