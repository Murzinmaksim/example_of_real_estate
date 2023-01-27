<?php
 function universal_link_bar($page, $count, $pages_count, $show_link) {
    if ($pages_count == 1) return false;
      $sperator = ' '; 
      $style = 'style="color: #808000; text-decoration: none;"';
      $begin = $page - intval($show_link / 2);
      unset($show_dots); 
    if ($pages_count <= $show_link + 1) $show_dots = 'no';
    if (($begin > 2) && !isset($show_dots) && ($pages_count - $show_link > 2)) {
      echo '<a '.$style.' href='.$_SERVER['php_self'].'?page=1> |< </a> ';
    }

    for ($j = 0; $j < $page; $j++) {
      if (($begin + $show_link - $j > $pages_count) && ($pages_count-$show_link + $j > 0)) {
        $page_link = $pages_count - $show_link + $j; 
        if (!isset($show_dots) && ($pages_count-$show_link > 1)) {
           echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.($page_link - 1).'><b>...</b></a> ';
           $show_dots = "no";
        }

        echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.$page_link.'>'.$page_link.'</a> '.$sperator;
      } else continue;

    }
    for ($j = 0; $j <= $show_link; $j++) {
      $i = $begin + $j; 
      if ($i < 1) {
        $show_link++;
        continue;
      } 
      if (!isset($show_dots) && $begin > 1) {
       echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.($i-1).'><b>...</b></a> ';
       $show_dots = "no";
      }
      if ($i > $pages_count) break;
        if ($i == $page) {
         echo ' <a '.$style.' ><b>'.$i.'</b></a> ';
        } else {
         echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.$i.'>'.$i.'</a> ';
          }
      if (($i != $pages_count) && ($j != $show_link)) echo $sperator;

      if (($j == $show_link) && ($i < $pages_count)) {
       echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.($i+1).'><b>...</b></a> ';
      }
    }

    if ($begin + $show_link + 1 < $pages_count) {
     echo ' <a '.$style.' href='.$_SERVER['php_self'].'?page='.$pages_count.'> >| </a>';
    }
  return true;
} 
?>