<?php
function function_return_breadcrumb($service,$action,$data)
{
  $data_count = count($data);
  $data_last = $data_count - 1;
  $page_title = $data[0]['title'];
  $page_title  = strip_tags($page_title);
  $nav_title = $data[$data_last]['title'];
  $output = '';
  $output_repeate = "";
  $output_repeate .= 
  '
    <span class="small text-secondary">'.$page_title.'</span>  
  ';
  for ($i=1; $i < $data_count; $i++)
  { 
    $detail = $data[$i];
    $title = $detail['title'];
    $href = $detail['href'];
    $output_repeate .= 
    '
      <span class="mx-2 text-secondary">|</span><a href="'.$href.'" class="small text-primary  p-1  text-decoration-none">'.$title.'</a>
    ';
  }
   $output_repeate .= 
  '
    <span class="mx-2 text-secondary">|</span>
    <a href="default" class="m-auto small text-primary mx-2">
      <i class="fa fa-home"></i>
    </a>
  ';

  if($data_count == 1)
  {
      $output = 
      '
        <div class="topbar p-0 m-0 row py-3 text-white">
            <nav class="">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 text-start">
                        '.$nav_title.'
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 col-6 text-end medium small d-none">
                        '.$output_repeate.'
                    </div>
                </div>
            </nav>
        </div>
      ';
  }
  elseif($data_count > 1)
  {
      $output = 
      '
        <div class="topbar p-0 m-0 row py-3 text-white">
            <nav class="">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 text-start">
                        '.$nav_title.'
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 col-6 text-end medium small d-none">
                        '.$output_repeate.'
                    </div>
                </div>
            </nav>
        </div>
      ';
  }

  return $output;
}
function function_return_pagination($service,$action,$data)
{
  $page = 1;
  if(array_key_exists('page', $_GET))
  {
      $page = $_GET['page'];
      unset($_GET['page']);
  }
  $count_all = $data['count_all'];
  $limit = $data['limit'];
  
  $offset = $limit * ($page -1);
  $remainder = $count_all % $limit;
  $quotient = ($count_all - $remainder) / $limit;
  $paging = "";
  $url_string = http_build_query($_GET);
  $url_string = "&$url_string";

  if($quotient >= '1' && $quotient < '6' )
  {
    if($page == 1)
    {
      $paging .= 
      '
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">First</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
      ';
    }
    if($page > 1)
    {
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page=1'.$url_string.'" tabindex="-1">First</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page='.($page-1). $url_string .'" tabindex="-1"></a>
        </li>
      ';
    }
    for($q = 0; $q <= $quotient; $q++) 
    {
        $p = $q +1 ;
        if(($page- 1 ) == $q)
        {
          $paging .= 
          '
            <li class="page-item active">
              <a class="page-link" href="#">'.$p.' <span class="sr-only">(current)</span></a>
            </li>
          ';
        }
        else
        {
          $paging .= 
          '
            <li class="page-item">
              <a class="page-link" href="?page='.$p. $url_string .'">'.$p.' <span class="sr-only">(current)</span></a>
            </li>
          ';
        }
    }
    if($quotient < $page)
    {
      $paging .= 
      '
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Next</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Last</a>
        </li>
      ';
    }
    if($quotient >= $page)
    {
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page='.($page+1). $url_string .'">Next</a>
        </li>
      ';
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page='.($quotient+1). $url_string .'">Last</a>
        </li>
      ';
    }
  }
  if($quotient >= '6')
  {
    if($page == 1)
    {
      $paging = 
      '
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">First</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link" href="#" tabindex="-1">Previous</a>
        </li>
      ';
      for($q = $page-1; $q <= '4'; $q++) 
      {
          $p = $q +1 ;
          if(($page- 1 ) > '1')
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.($page- 1). $url_string .'">'.($page- 1).'</a>
              </li>
            ';
          }
          if(($page - 1 ) == $q)
          {
            $paging .= 
            '
              <li class="page-item active">
                <a class="page-link" href="#">'.$p.'</a>
              </li>
            ';
          }
          else
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.$p. $url_string.'">'.$p.'</a>
              </li>
            ';
          }
      }
      if($quotient > 6)
      {
        $paging .= 
        '
          <li class="page-item disabled">
            <a class="page-link" href="#">...</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient). $url_string .'">'.($quotient).'</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient + 1). $url_string .'">'.($quotient + 1).'</a>
          </li>
        ';
      }
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page='.($page+1). $url_string .'" tabindex="-1">Next</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page='.($quotient+1). $url_string.'" tabindex="-1">Last</a>
        </li>
      ';
    }
    if($page > 1 && $page < $quotient-5)
    {
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page=1'. $url_string .'" tabindex="-1">First</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page='.($page-1). $url_string .'" tabindex="-1">Previous</a>
        </li>
      ';      
      if($page > 5)
      {
        $paging .= 
        '
          <li class="page-item">
            <a class="page-link" href="?page=1'. $url_string .'" tabindex="-1">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page=2'. $url_string .'" tabindex="-1">2</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">...</a>
          </li>
        ';
      }
      for($q = $page-1; $q <= $page+3; $q++) 
      {
          $p = $q ;
          if($page == $q)
          {
            $paging .= 
            '
              <li class="page-item active">
                <a class="page-link" href="#" tabindex="-1">'.$page.'</a>
              </li>
            ';
          }
          else
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.$p. $url_string.'" tabindex="-1">'.$p.'</a>
              </li>
            ';
          }
      }
      if($quotient > 6)
      {
        $paging .= 
        '
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">...</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient). $url_string.'">'.($quotient).'</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient + 1). $url_string.'">'.($quotient + 1).'</a>
          </li>
        ';
      }
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page='.($page + 1). $url_string.'">Next</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page='.($quotient + 1). $url_string.'">Last</a>
        </li>
      ';
    }
    if($page > 1 && $page >= $quotient-5)
    {
      $paging .= 
      '
        <li class="page-item">
          <a class="page-link" href="?page=1'.$url_string.'" tabindex="-1">First</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="?page='.($page-1). $url_string .'" tabindex="-1">Previous</a>
        </li>
      ';
      if($page > 5)
      {
        $paging .= 
        '
          <li class="page-item">
            <a class="page-link" href="?page=1'.$url_string.'" tabindex="-1">1</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page=2'.$url_string.'" tabindex="-1">2</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#">...</a>
          </li>
        ';
      }
      for($q = $page-1; $q <= $page+3; $q++) 
      {
          $p = $q ;
          if($page == $q)
          {
            $paging .= 
            '
              <li class="page-item active">
                <a class="page-link" href="#" tabindex="-1">'.$page.'</a>
              </li>
            ';
          }
          if($q > $quotient)
          {
            $paging .= "";
          }
          if($q == $quotient && $page == $q)
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.($p+1). $url_string.'" tabindex="-1">'.($p+1).'</a>
              </li>
            ';
          }
          if($q == $quotient && $page != $q)
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.$p. $url_string.'" tabindex="-1">'.$p.'</a>
              </li>
            ';
          }
          if($q < $quotient && $page < $q)
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.$p. $url_string.'" tabindex="-1">'.$p.'</a>
              </li>
            ';
          }
          if($q < $quotient && $page > $q)
          {
            $paging .= 
            '
              <li class="page-item">
                <a class="page-link" href="?page='.$p. $url_string.'" tabindex="-1">'.$p.'</a>
              </li>
            ';
          }

      }
      if($quotient < $page-5)
      {
        $paging .= 
        '
          <li class="page-item">
            <a class="page-link" href="#">...</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient). $url_string .'">'.($quotient).'</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient + 1). $url_string .'">'.($quotient + 1).'</a>
          </li>
        ';
      }
      if($quotient >= $page)
      {
        $paging .= 
        '
          <li class="page-item">
            <a class="page-link" href="?page='.($page+1). $url_string.'" tabindex="-1">Next</a>
          </li>
          <li class="page-item">
            <a class="page-link" href="?page='.($quotient+1). $url_string.'" tabindex="-1">Last</a>
          </li>
        ';
      }
      if($quotient < $page)
      {
        $paging .= 
        '
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Next</a>
          </li>
          <li class="page-item disabled">
            <a class="page-link" href="#" tabindex="-1">Last</a>
          </li>
        ';
      }
    }
  }

  $output = 
  '
    <nav class="m-auto tex-center" aria-label="...">
      <ul class="pagination m-0 p-0">
        '.$paging.'
      </ul>
    </nav>
  ';
  return $output;
}
?>