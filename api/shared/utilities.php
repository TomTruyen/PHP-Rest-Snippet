<?php

namespace api\shared;

class Utilities
{

    public function getPaging($total_rows, $page_url, $current_start, $current_limit)
    {
        $paging_arr = array();

        $total_pages = ceil($total_rows / $current_limit);

        $paging_arr['total'] = $total_pages;

        $previous_start = $current_start - $current_limit;
        if ($current_start > $previous_start && $current_start > 0) {
            $paging_arr['previous'] = [
                'start' => $previous_start,
                'limit' => $current_limit,
                'url' => "$page_url?start=$current_start&limit=$current_limit"
            ];
        }

        $next_start = $current_start + $current_limit;
        if ($current_start < $total_pages * $current_limit && $total_pages - ceil($current_start * $current_limit) - 1 > 0) {
            $paging_arr['next'] = [
                'start' => $next_start,
                'limit' => $current_limit,
                'url' => "$page_url?start=$current_start&limit=$current_limit"

            ];
        }


        // todo get amount of total pages, and check on what page we are

        // if there is a next page then add a property called 'next' page with teh url

        // same goes for previous

        return $paging_arr;
    }
}
