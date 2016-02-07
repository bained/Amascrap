<?php
class pagination
{
	public function __construct()
	{
	}
	public function calculate_pages($total_rows, $rows_per_page, $page_num)
	{
		$arr = array();
		// calculate last page
		$last_page = ceil($total_rows / $rows_per_page);
		// make sure we are within limits
		$page_num = (int) $page_num;
		if ($page_num < 1)
		{
		   $page_num = 1;
		} 
		elseif ($page_num > $last_page)
		{
		   $page_num = $last_page;
		}
		$upto = ($page_num - 1) * $rows_per_page;
		$arr['limit'] = 'LIMIT '.$upto.',' .$rows_per_page;
		$arr['current'] = $page_num;
		if ($page_num == 1)
			$arr['previous'] = $page_num;
		else
			$arr['previous'] = $page_num - 1;
		if ($page_num == $last_page)
			$arr['next'] = $last_page;
		else
			$arr['next'] = $page_num + 1;
		$arr['last'] = $last_page;
		$arr['info'] = 'Page ('.$page_num.' of '.$last_page.')';
		$arr['pages'] = $this->get_surrounding_pages($page_num, $last_page, $arr['next']);
		$arr['five_links_style'] = $this->get_five_links($page_num, $last_page); // $cuurent, $pages
		return $arr;
	}
	function get_surrounding_pages($page_num, $last_page, $next)
	{
		$arr = array();
		$show = 5; // how many boxes
		// at first
		if ($page_num == 1)
		{
			// case of 1 page only
			if ($next == $page_num) return array(1);
			for ($i = 0; $i < $show; $i++)
			{
				if ($i == $last_page) break;
				array_push($arr, $i + 1);
			}
			return $arr;
		}
		// at last
		if ($page_num == $last_page)
		{
			$start = $last_page - $show;
			if ($start < 1) $start = 0;
			for ($i = $start; $i < $last_page; $i++)
			{
				array_push($arr, $i + 1);
			}
			return $arr;
		}
		// at middle
		$start = $page_num - $show;
		if ($start < 1) $start = 0;
		for ($i = $start; $i < $page_num; $i++)
		{
			array_push($arr, $i + 1);
		}
		for ($i = ($page_num + 1); $i < ($page_num + $show); $i++)
		{
			if ($i == ($last_page + 1)) break;
			array_push($arr, $i);
		}
		return $arr;
	}
	
	// NED Pagination - 5 links
	function get_five_links($current, $pages){
		$p_links = array();

		if ($pages > 3) {
			// this specifies the range of pages we want to show in the middle
			$min = max($current - 2, 2);
			$max = min($current + 2, $pages-1);

			// we always show the first page
			$p_links[] = "1";

			// we're more than one space away from the beginning, so we need a separator
			if ($min > 2) {
				$p_links[] = "...";
			}

			// generate the middle numbers
			for ($i=$min; $i<$max+1; $i++) {
				$p_links[] = "$i";
			}

			// we're more than one space away from the end, so we need a separator
			if ($max < $pages-1) {
				$p_links[] = "...";
			}
			// we always show the last page
			$p_links[] = "$pages";
		} else {
			// we must special-case three or less, because the above logic won't work
			if ($pages == 3) $p_links = array("1", "2", "3");
			if ($pages == 2) $p_links = array("1", "2");
			if ($pages == 1) $p_links = array("1");
		}
		return $p_links;
	}
}
?>