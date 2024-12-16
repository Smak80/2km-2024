<?php

namespace common;

require_once 'json_loader.php';
require_once 'a_content.php';

class page
{
    private a_content $content;

    public function __construct(a_content $content){
        $this->content = $content;
        $this->start_page();
        $this->show_menu();
        $this->show_header();
        $this->show_content();
        $this->show_footer();
        $this->end_page();
    }

    private function start_page(): void
    {
        // Вывод начала страницы (<head>)
        ?>
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <title>
                <?php print("НАЗВАНИЕ СТРАНИЦЫ");?>
            </title>
            <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
            <link rel="stylesheet" type="text/css" href="/css/bootstrap-grid.min.css">
            <link rel="stylesheet" type="text/css" href="/css/bootstrap-reboot.min.css">
            <link rel="stylesheet" type="text/css" href="/css/bootstrap-utilities.min.css">
            <script type="application/javascript" src="/js/bootstrap.bundle.min.js"></script>
            <meta name="viewport" content="width=device-width, initial-scale=1">
        </head>
        <body>
        <?php
    }

    private function show_menu(): void
    {
        ?>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Магистры-2024 (2 курс)</span>
                <div class="d-flex">
                    <div class="m-auto navbar-toggler border-0" data-bs-toggle="collapse">МЕНЮ:</div>
                    <button class="navbar-toggler m-button border-info" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                            aria-label="Меню">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <?php
                        $pages = json_loader::load("data/pages.json");
                        $this_page = trim($_SERVER['SCRIPT_NAME'], "\r\n\t /");
                        foreach ($pages as $page) {
                            if (isset($page['show']) && $page['show'] === 0) continue;
                        ?>
                            <li class="nav-item">
                            <?php
                            if ($this_page === $page['url']) {
                                print ('<span class="nav-link fw-semibold" aria-current="page">' . $page['title'] . '</span>');
                            } else {
                                print ('<a class="nav-link" href="' . $page['url'] . '">' . $page['title'] . '</a>');
                            }
                            ?>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <?php
    }

    private function show_header(): void
    {
        ?>
        <div class="container-fluid text-center bg-primary text-white h2 p-2">
        <?php
        $pages = json_loader::load("data/pages.json");
        $this_page = trim($_SERVER['SCRIPT_NAME'], "\r\n\t /");
        foreach ($pages as $page){
            if ($page['url'] === $this_page){
                print($page['title']);
                break;
            }
        }
        ?>
        </div>
        <?php
    }

    private function show_content(): void
    {
        ?>
        <div>
            <?php $this->content->create_content(); ?>
        </div>
        <?php
    }

    private function show_footer(): void
    {
        ?>
        <div class="container-fluid alert alert-secondary">
            <div class="text-end w-auto fs-6">
                © Маклецов С. В., 2024
            </div>
        </div>
        <?php
    }

    private function end_page(): void
    {
        print ("</body></html>");
    }
}