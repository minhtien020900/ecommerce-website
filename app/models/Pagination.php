<?php
class Pagination
{
    public function createPageLinks($url, $totalRow, $perPage, $page)
    {
        $active='';
        $pagePre = $page-1;
        if ($page == 1) {
           $active ='disabled';
        }
        $output = "<nav aria-label='Page navigation'>
        <ul class='pagination justify-content-center'>
          <li class='page-item $active'>
            <a class='page-link' href='$url?page=$pagePre' aria-label='Previous'>
              <span aria-hidden='true'>&laquo;</span>
              <span class='sr-only'>Previous</span>
            </a>
          </li>";
        
        $totalPage = ceil($totalRow / $perPage);
        for ($i=1; $i <= $totalPage; $i++) {
            $active = '';
            if ($page == $i) {
                $active = 'active';
            }
            $output .= "<li class='page-item $active'><a class='page-link' href='$url?page=$i'>$i</a></li>";
        }
        if ($page == $totalPage) {
            $active='disabled';
        }
        $page+=1;
        $output .= "<li class='page-item $active'>
        <a class='page-link' href='$url?page=$page' aria-label='Next'>
          <span aria-hidden='true'>&raquo;</span>
          <span class='sr-only'>Next</span>
        </a>
      </li>
    </ul>
    </nav>";
        return $output;
    }
}
