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
            <link rel="stylesheet" type="text/css" href="/css/bootstrap.rtl.min.css">
            <script type="application/javascript" href="/js/bootstrap.min.js"></script>
            <script type="application/javascript" href="/js/bootstrap.bundle.min.js"></script>
            <script type="application/javascript" href="/js/bootstrap.esm.min.js"></script>
            <script type="application/javascript" href="/js/jquery-3.7.1.min.js"></script>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <?php
                        $pages = json_loader::load("data/pages.json");
                        $this_page = trim($_SERVER['SCRIPT_NAME'], "\r\n\t /");
                        foreach ($pages as $page) {
                            if ($this_page === $page['url']) {
                                print ('<span class="nav-link fw-semibold" aria-current="page">' . $page['title'] . '</span>');
                            } else {
                                print ('<a class="nav-link" href="' . $page['url'] . '">' . $page['title'] . '</a>');
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
        <?php
    }

    private function show_header(): void
    {
        ?>
        <div class="container-fluid text-center bg-primary text-white fw-bold p-2">
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
        <div>
            ПОДВАЛ
        </div>
        <?php
    }

    private function end_page(): void
    {
        print ("</body></html>");
    }
}