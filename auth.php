<?php
require_once 'common/a_content.php';
require_once 'common/page.php';
use common\page;
class auth extends \common\a_content
{
    public function create_content(): void
    {
        ?>
        <div class="container border border-primary border-1 w-50">
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
    }
}

new page(new auth());