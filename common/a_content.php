<?php
namespace common;

abstract class a_content
{
    private array $post = array();
    private array $get = array();
    private array $request = array();
    private array $session = array();
    protected bool $is_opened = false;

    public function __construct()
    {
        session_start();
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

    public function is_opened(): bool{
        return $this->is_opened;
    }

    public function is_authorized(): bool {
        return $this->get_session_data('login') !== '';
    }

    public function get_get_data($key): string{
        if (isset($this->get[$key])) return $this->get[$key];
        return '';
    }
    public function get_post_data($key): string{
        if (isset($this->post[$key])) return $this->post[$key];
        return '';
    }
    public function get_request_data($key): string{
        if (isset($this->request[$key])) return $this->request[$key];
        return '';
    }

    public function get_session_data($key): string{
        if (isset($this->session[$key])) return $this->session[$key];
        return '';
    }

    public function set_session_data($key, $value): void
    {
        $_SESSION[$key] = $value;
        $this->session[$key] = htmlspecialchars($value);
    }

    public function is_form_sent(): bool{
        return isset($_REQUEST['form_sent']);
    }

    private function show_message(string $message, style $type = style::error): void{
        $alert_type = 'alert-danger';
        switch ($type) {
            case style::warning:
                $alert_type = 'alert-warning';
                break;
            case style::info:
                $alert_type = 'alert-info';
                break;
            case style::success:
                $alert_type = 'alert-success';
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

    protected function show_error(string $message): void
    {
        $this->show_message($message);
    }

    protected function show_success(string $message): void
    {
        $this->show_message($message, style::success);
    }

    protected function show_info(string $message): void
    {
        $this->show_message($message, style::info);
    }

    protected function show_warning(string $message): void
    {
        $this->show_message($message, style::warning);
    }

    public abstract function create_content();
}

enum style
{
    case error;
    case warning;
    case info;
    case success;
}