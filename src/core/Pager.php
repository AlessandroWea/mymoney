<?php

namespace Alewea\Mymoney\core;

class Pager
{
    public int $page;
    public int $limit;
    public int $offset;

    public function __construct($limit)
    {
        $this->page = $_GET['page'] ?? 1;
        $this->limit = $limit;
        $this->offset = ($this->page - 1) * $this->limit;
    }

    public function display()
    {
        $str = '<nav aria-label="Page navigation example">
        <ul class="pagination">';
        if($this->page == 1)
            $str .= '<li class="page-item"><a class="page-link" href="?page=1">Previous</a></li>';
        else
            $str .= '<li class="page-item"><a class="page-link" href="?page=' . $this->page-1 . '">Previous</a></li>';
        $str .= '<li class="page-item active"><a class="page-link" href="?page=' . $this->page . '">' . $this->page .'</a></li>';
        $str .= '<li class="page-item"><a class="page-link" href="?page=' . $this->page+1 . '">' . $this->page+1 .'</a></li>';
        $str .= '<li class="page-item"><a class="page-link" href="?page=' . $this->page+2 . '">' . $this->page+2 .'</a></li>';
        $str .= '<li class="page-item"><a class="page-link" href="?page=' . $this->page+1 .'">Next</a></li>';
       $str .= ' </ul></nav>';

       echo $str;
    }

}