<?php
//得到当前网址
function get_url()
{
	$str = $_SERVER['PHP_SELF'] . '?';
	if ($_GET) {
		foreach ($_GET as $k => $v) {  //$_GET['page']
			if ($k != 'page') {
				$str .= $k . '=' . $v . '&';
			}
		}
	}
	return $str;
}

/*
	
	[1]  2   3   4     5
	 1  [2]  3   4     5   要求显示五页，但是没有这么多数据，就只能按照总页数来排
	


	 1   2  [3]  4     5	 
     2   3  [4]  5     6
     3   4  [5]  6     7
     4   5  [6]  7	   8
     5   6  [7]	 8     9
	   
     6   7	[8]  9     10
	 

     6   7	 8  [9]    10
     6   7	 8   9     [10]
	
	$pages   5

	$pages-5+1;
*/


//分页函数
/**
 *@pargam $current	当前页
 *@pargam $count	记录总数
 *@pargam $limit	每页显示多少条
 *@pargam $size		中间显示多少条
 *@pargam $class	样式
 */
function page($current, $count, $limit, $size, $class = 'sabrosus')
{
	$str = '';
	//如果数据总数大于每页显示的数量才输出分页链接
	if ($count > $limit) {
		$pages = ceil($count / $limit); //算出总页数
		$url = get_url(); //获取当前页面的URL地址（包含参数）

		//开始
		if ($current == 1) {
			//如果说当前页是第一页的话，则输出span标签，无法点击首页及上一页
			$str .= '<li class="paginate_button page-item previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>';
		} else {
			//如果说当前页不是第一页的话，则输出a标签，点击分别跳转到首页及上一页
			$str .= '<li class="paginate_button page-item previous" id="example2_previous"><a href="' . $url . 'page=' . ($current - 1) . '" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Previous</a></li>';
		}

		//中间
		//判断得出 star 与 end
		if ($current <= floor($size / 2)) { //情况1
			//当前页的大小小于等于显示分页的一半（向下取整）的时候从1开始
			$star = 1;
			$end = $pages > $size ? $size : $pages; //看看他两谁小，取谁的
		} else if ($current >= $pages - floor($size / 2)) { // 情况2
			//当前页的大小大于等于显示分页的一半（向下取整）的时候从总页数-显示页数+1开始
			$star = $pages - $size + 1 <= 0 ? 1 : $pages - $size + 1; //避免出现负数
			$end = $pages;
		} else { //情况3
			$d = floor($size / 2);
			$star = $current - $d;
			$end = $current + $d;
		}
		//循环输出中间显示页
		for ($i = $star; $i <= $end; $i++) {
			if ($i == $current) {
				//当前页
				$str .= '<li class="paginate_button page-item active"><a href="#" aria-controls="example2" data-dt-idx="' . $i . '" tabindex="0" class="page-link">' . $i . '</a></li>';
			} else {
				// 非当前页
				$str .= '<li class="paginate_button page-item "><a href="' . $url . 'page=' . $i . '" aria-controls="example2" data-dt-idx="' . $i . '" tabindex="0" class="page-link">' . $i . '</a></li>';
			}
		}

		//最后
		if ($pages == $current) {
			//如果说当前页是最后一页的话，则输出span标签，无法点击尾页及下一页
			$str .= '<li class="paginate_button page-item next disabled" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="' . $i . '" tabindex="0" class="page-link">Next</a></li>';
		} else {
			//如果说当前页不是最后一页的话，则输出a标签，点击分别跳转到尾页及下一页
			$str .= '<li class="paginate_button page-item next" id="example2_next"><a href="' . $url . 'page=' . ($current + 1) . '" aria-controls="example2" data-dt-idx="' . $i . '" tabindex="0" class="page-link">Next</a></li>';
		}
	}

	return $str;
}
