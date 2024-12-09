<?php
namespace common;

require_once "common/style_enum.php";

abstract class a_content
{
    private array $post = array();
    private array $get = array();
    private array $request = array();
    private array $session = array();

    public function __construct()
    {
        if (isset($_GET)){
            foreach ($_GET as $key => $value){
                $this->get[$key] = htmlspecialchars($value);
            }
        }
        if (isset($_POST)){
            foreach ($_POST as $key => $value){
                $this->post[$key] = htmlspecialchars($value);
            }
        }
        if (isset($_REQUEST)){
            foreach ($_REQUEST as $key => $value){
                $this->request[$key] = htmlspecialchars($value);
            }
        }
        if (isset($_SESSION)){
            foreach ($_SESSION as $key => $value){
                $this->session[$key] = htmlspecialchars($value);
            }
        }
    }

    protected function get_get_data($key): string{
        if (isset($this->get[$key])) return $this->get[$key];
        return '';
    }
    protected function get_post_data($key): string{
        if (isset($this->post[$key])) return $this->post[$key];
        return '';
    }
    protected function get_request_data($key): string{
        if (isset($this->request[$key])) return $this->request[$key];
        return '';
    }

    protected function get_session_data($key): string{
        if (isset($this->session[$key])) return $this->session[$key];
        return '';
    }

    protected function is_form_sent(): bool{
        return isset($_REQUEST['form_sent']);
    }

    protected function show_message(string $message, style $type = style::error): void{
        $alert_type = 'alert-danger';
        switch ($type) {
            case style::warning:
                $alert_type = 'alert-warning';
                break;
            case style::info:
                $alert_type = 'alert-info';
                break;
            default:
        }
        ?>
        <div class="container">
            <div class="alert <?php print $alert_type?> text-center">
                <?php print $message;?>
            </div>
        </div>
        <?php
    }

    public abstract function create_content();
}