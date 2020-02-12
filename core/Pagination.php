<?php


class Pagination
{
    private $current_page;
    private $per_page;
    private $total_count;
    private $con;

    public function __construct($current_page = 1, $per_page = 5, $total_count = 0) {
        $this->current_page = $current_page;
        $this->per_page = $per_page;
        $this->total_count = $total_count;

        // $this->con = $pdo;
    }

    public function offset() {
        return $this->per_page * ($this->current_page - 1);
    }

    public function total_pages() {
        return ceil($this->total_count / $this->per_page);
    }

    public function previous_page() {
        $prev = $this->current_page - 1;
        return ($prev > 0) ? $prev : false;
    }

    public function next_page() {
        $next = $this->current_page + 1;
        return ($next <= $this->total_pages()) ? $next : false;
    }

    public function previous_link($controller, $action) {
        $link = "";
        if($this->previous_page() != false) {
            $url = "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "&page=" . $this->previous_page();
            $link .= "<a href='{$url}'>Previous</a>";
        }
        return $link;
    }

    public function next_link($controller, $action) {
        $link = "";
        if($this->next_page() != false) {
            $url = "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "&page=" . $this->next_page();
            $link .= "<a href='{$url}'>Next</a>";
        }
        return $link;
    }

    public function number_links($controller, $action) {
        $output = "";
        for($i = 1; $i <= $this->total_pages(); $i++) {
            if($i == $this->current_page) {
                $output .= "<span>{$i}</span>";
            } else {
                $url = "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "&page=" . $i;
                $output .= "<a href='{$url}'>$i</a>";
            }
        }
        return $output;
    }

    public function current_link() {
        $output = "";
        for($i = 1; $i <= $this->total_pages(); $i++) {
            if($i == $this->current_page) {
                $output .= $i;
            }
        }
        return $output;
    }

    public function LinkBuilder($controller, $action, $page = null) {
        $output = "";
        if($this->total_pages() > 1) {
            // $output .= "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "&page=" . $this->previous_link();
            $output .= $this->previous_link($controller, $action);
            $output .= $this->number_links($controller, $action);
            // $output .= "http://localhost/" . SITEURL . "/" . $controller . "/" . $action . "&page=" . $this->next_link();
            $output .= $this->next_link($controller, $action);
        }
        return $output;
    }
}