<?php

/*

class.PaginationLinks.php

A class containing functions for creating pagination links

Created by Kate Morley - http://iamkate.com/ - and released under the terms of
the CC0 1.0 Universal legal code:

http://creativecommons.org/publicdomain/zero/1.0/legalcode

*/

namespace App\Http\Helpers;

// A class containing functions for creating pagination links.
class PaginationLinks {

  /* Returns a set of pagination links. The parameters are:
   *
   * $page          - the current page number
   * $numberOfPages - the total number of pages
   * $context       - the amount of context to show around page links - this
   *                  optional parameter defauls to 1
   * $linkFormat    - the format to be used for links to other pages - this
   *                  parameter is passed to sprintf, with the page number as a
   *                  second and third parameter. This optional parameter
   *                  defaults to creating an HTML link with the page number as
   *                  a GET parameter.
   * $pageFormat    - the format to be used for the current page - this
   *                  parameter is passed to sprintf, with the page number as a
   *                  second and third parameter. This optional parameter
   *                  defaults to creating an HTML span containing the page
   *                  number.
   * $ellipsis      - the text to be used where pages are omitted - this
   *                  optional parameter defaults to an ellipsis ('...')
   */

  public static function paginationCreate(
      $page,
      $numberOfPages,
      $context    = 1,
      $linkFormat = '<li class="page-item"><a class="page-link" href="?page=%d">%d</a></li>',

      $prevDisableFormat = '<li class="page-item prev active" disabled><a class="page-link">&#8249;</a></li>',
      $prevFormat = '<li class="page-item prev"><a class="page-link" href="?page=%d">&#8249;</a></li>',

      $nextDisableFormat = '<li class="page-item next active" disabled><a class="page-link">&#8250;</a></li>',
      $nextFormat = '<li class="page-item next"><a class="page-link" href="?page=%d">&#8250;</a></li>',

      $pageFormat = '<li class="page-item active"><a class="page-link" href="?page=%d">%d</a></li>',
      $ellipsis   = '<li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>'

  ){

    // create the list of ranges
    $ranges = array(array(1, 1 + $context));
    self::mergeRanges($ranges, $page   - $context, $page + $context);
    self::mergeRanges($ranges, $numberOfPages - $context, $numberOfPages);

    // initialise the list of links
    $links = array();


//    return $ranges;

    // loop over the ranges
    foreach ($ranges as $range){


      // if there are preceeding links, append the ellipsis
      if (count($links) > 0) $links[] = $ellipsis;

      // merge in the new links
      $links =
          array_merge(
              $links,
              self::createLinks($range, $page, $linkFormat, $pageFormat));

    }

    if (count($links) > 0) {
        if ($page == 1)
            array_unshift($links, $prevDisableFormat);
        else
            array_unshift($links,  sprintf($prevFormat,((int) $page)-1));
        if ($page == $numberOfPages)
            array_push($links, $nextDisableFormat);
        else
            array_push($links,  sprintf($nextFormat,((int) $page)+1));
    }
    return implode(' ' , $links);

  }

  /* Merges a new range into a list of ranges, combining neighbouring ranges.
   * The parameters are:
   *
   * $ranges - the list of ranges
   * $start  - the start of the new range
   * $end    - the end of the new range
   */
  private static function mergeRanges(&$ranges, $start, $end){

    // determine the end of the previous range
    $endOfPreviousRange =& $ranges[count($ranges) - 1][1];

    // extend the previous range or add a new range as necessary
    if ($start <= $endOfPreviousRange + 1){
      $endOfPreviousRange = $end;
    }else{
      $ranges[] = array($start, $end);
    }

  }

  /* Create the links for a range. The parameters are:
   *
   * $range      - the range
   * $page       - the current page
   * $linkFormat - the format for links
   * $pageFormat - the format for the current page
   */
  private static function createLinks($range, $page, $linkFormat, $pageFormat){

    // initialise the list of links
    $links = array();

    // loop over the pages, adding their links to the list of links
    for ($index = $range[0]; $index <= $range[1]; $index ++){

      $links[] =
          sprintf(
              ($index == $page ? $pageFormat : $linkFormat),
              $index,
              $index);
    }


    // return the array of links
    return $links;

  }

}

?>
