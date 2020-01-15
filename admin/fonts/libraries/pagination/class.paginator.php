<?php
/*
 * PHP Pagination Class
 *
 * @author David Carr - dave@daveismyname.com - http://www.daveismyname.com
 * @version 1.0
 * @date October 20, 2012
 */
class Paginator{

        /**
	 * set the number of items per page.
	 *
	 * @var numeric
	*/
	private $_perPage;

	/**
	 * set get parameter for fetching the page number
	 *
	 * @var string
	*/
	private $_instance;

	/**
	 * sets the page number.
	 *
	 * @var numeric
	*/
	private $_page;

	/**
	 * set the limit for the data source
	 *
	 * @var string
	*/
	private $_limit;

	/**
	 * set the total number of records/items.
	 *
	 * @var numeric
	*/
	private $_totalRows = 0;



	/**
	 *  __construct
	 *
	 *  pass values when class is istantiated
	 *
	 * @param numeric  $_perPage  sets the number of iteems per page
	 * @param numeric  $_instance sets the instance for the GET parameter
	 */
	public function __construct($perPage,$instance){
		$this->_instance = $instance;
		$this->_perPage = $perPage;
		$this->set_instance();
	}

	/**
	 * get_start
	 *
	 * creates the starting point for limiting the dataset
	 * @return numeric
	*/
	private function get_start(){
		return ($this->_page * $this->_perPage) - $this->_perPage;
	}

	/**
	 * set_instance
	 *
	 * sets the instance parameter, if numeric value is 0 then set to 1
	 *
	 * @var numeric
	*/
	private function set_instance(){
		$this->_page = (int) (!isset($_GET[$this->_instance]) ? 1 : $_GET[$this->_instance]);
		$this->_page = ($this->_page == 0 ? 1 : $this->_page);
	}

	/**
	 * set_total
	 *
	 * collect a numberic value and assigns it to the totalRows
	 *
	 * @var numeric
	*/
	public function set_total($_totalRows){
		$this->_totalRows = $_totalRows;
	}

	/**
	 * get_limit
	 *
	 * returns the limit for the data source, calling the get_start method and passing in the number of items perp page
	 *
	 * @return string
	*/
	public function get_limit() {
		return "LIMIT ".$this->get_start().",$this->_perPage";
	}

	/**
	 * page_links
	 *
	 * create the html links for navigating through the dataset
	 *
	 * @var sting $path optionally set the path for the link
	 * @var sting $ext optionally pass in extra parameters to the GET
	 * @return string returns the html menu
	*/
	public function page_links($path='?',$ext=null)
	{
	    $adjacents = "2";
	    $prev = $this->_page - 1;
	    $next = $this->_page + 1;
	    $lastpage = ceil($this->_totalRows/$this->_perPage);
	    $lpm1 = $lastpage - 1;

		$pagination = "";
		$pagination .= '<div class="row">';
			$pagination .= '<div class="col-sm-12 col-md-5">';
				if($lastpage > 1) {
				$pagination .= '<div class="dataTables_info" id="m_table_1_info" role="status" aria-live="polite">Showing '.($this->get_start()+1).' to '.($this->get_start()+$this->_perPage).' of '.$this->_totalRows.' entries</div>';
				}
			$pagination .= '</div>';

			$pagination .= '<div class="col-sm-12 col-md-7 dataTables_pager">';
			$pg_url_params = "";
			if(isset($_REQUEST['position'])) {
				$pg_url_params .= "&position=".$_REQUEST['position'];
			}

							$pagination.= "&nbsp;Display <select name=\"pagination_limit\" id=\"pagination_limit\" onchange=\"window.open(this.options[this.selectedIndex].value, '_top');\">";
								$pagination.= '<option value="'.$script_name.'?pagination_limit=5'.$pg_url_params.'" '.($page_list_limit == '5'?'selected="selected"':'').'>5</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=10'.$pg_url_params.'" '.($page_list_limit == '10'?'selected="selected"':'').'>10</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=15'.$pg_url_params.'" '.($page_list_limit == '15'?'selected="selected"':'').'>15</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=20'.$pg_url_params.'" '.($page_list_limit == '20'?'selected="selected"':'').'>20</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=25'.$pg_url_params.'" '.($page_list_limit == '25'?'selected="selected"':'').'>25</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=50'.$pg_url_params.'" '.($page_list_limit == '50'?'selected="selected"':'').'>50</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=100'.$pg_url_params.'" '.($page_list_limit == '100'?'selected="selected"':'').'>100</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=200'.$pg_url_params.'" '.($page_list_limit == '200'?'selected="selected"':'').'>200</option>';
								$pagination.= '<option value="'.$script_name.'?pagination_limit=500'.$pg_url_params.'" '.($page_list_limit == '500'?'selected="selected"':'').'>500</option>';
							$pagination.= "</select>";
						// $pagination.= '</li>';
				$pagination .= '<div class="dataTables_paginate paging_simple_numbers" id="m_table_1_paginate">';
					$pagination .= '<ul class="pagination">';
						if($lastpage > 1) {
						if($this->_page > 1)
							$pagination.= "<li class='paginate_button page-item previous' id='m_table_1_previous'><a class='page-link' href='".$path."$this->_instance=$prev"."$ext'><i class='la la-angle-left'></i></a></li>";
						else
							$pagination.= '<li class="paginate_button page-item previous disabled" id="m_table_1_previous"><a href="#" class="page-link"><i class="la la-angle-left"></i></a></li>';

						if($lastpage < 7 + ($adjacents * 2)) {
							for($counter = 1; $counter <= $lastpage; $counter++) {
								if($counter == $this->_page)
									$pagination.= "<li class='paginate_button page-item active'><a class='page-link' href='#'>$counter</a></li>";
								else
									$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
							}
						} elseif($lastpage > 5 + ($adjacents * 2)) {
							if($this->_page < 1 + ($adjacents * 2)) {
								for($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
									if($counter == $this->_page)
										$pagination.= "<li class='paginate_button page-item active'><a class='page-link' href='#'>$counter</a></li>";
									else
										$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
								}
								$pagination.= "...";
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a></li>";
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a></li>";
							} elseif($lastpage - ($adjacents * 2) > $this->_page && $this->_page > ($adjacents * 2)) {
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=1"."$ext'>1</a></li>";
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=2"."$ext'>2</a></li>";
								$pagination.= "...";

								for($counter = $this->_page - $adjacents; $counter <= $this->_page + $adjacents; $counter++) {
									if($counter == $this->_page)
										$pagination.= "<span class='active'><a class='page-link' href='#'>$counter</a></span>";
									else
										$pagination.= "<a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a>";
								}

								$pagination.= "..";
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$lpm1"."$ext'>$lpm1</a></li>";
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$lastpage"."$ext'>$lastpage</a></li>";
							} else {
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=1"."$ext'>1</a></li>";
								$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=2"."$ext'>2</a></li>";
								$pagination.= "..";

								for($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
									if($counter == $this->_page)
										$pagination.= "<li class='paginate_button page-item active'><a class='page-link' href='#'>$counter</a><li>";
									else
										$pagination.= "<li class='paginate_button page-item'><a class='page-link' href='".$path."$this->_instance=$counter"."$ext'>$counter</a></li>";
								}
							}
						}

						if($this->_page < $counter - 1)
							$pagination.= "<li class='paginate_button page-item next'  id='m_table_1_next'><a class='page-link' href='".$path."$this->_instance=$next"."$ext'><i class='la la-angle-right'></i></a></li>";
						else
							$pagination.= '<li class="paginate_button page-item next disabled"  id="m_table_1_next"><a class="page-link" href="#"><i class="la la-angle-right"></i></a></li>';
						}

						$pagination.= '<li>';
		                	$page_list_limit = $_SESSION['pagination_limit'];
		                	$script_name = $_SERVER['SCRIPT_NAME'];

							// $pg_url_params = "";
							// if(isset($_REQUEST['position'])) {
							// 	$pg_url_params .= "&position=".$_REQUEST['position'];
							// }
							//
		          //       	$pagination.= "&nbsp;Display Num<select style=\"width:75px;margin-left:5px;\" name=\"pagination_limit\" id=\"pagination_limit\" onchange=\"window.open(this.options[this.selectedIndex].value, '_top');\">";
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=5'.$pg_url_params.'" '.($page_list_limit == '5'?'selected="selected"':'').'>5</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=10'.$pg_url_params.'" '.($page_list_limit == '10'?'selected="selected"':'').'>10</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=15'.$pg_url_params.'" '.($page_list_limit == '15'?'selected="selected"':'').'>15</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=20'.$pg_url_params.'" '.($page_list_limit == '20'?'selected="selected"':'').'>20</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=25'.$pg_url_params.'" '.($page_list_limit == '25'?'selected="selected"':'').'>25</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=50'.$pg_url_params.'" '.($page_list_limit == '50'?'selected="selected"':'').'>50</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=100'.$pg_url_params.'" '.($page_list_limit == '100'?'selected="selected"':'').'>100</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=200'.$pg_url_params.'" '.($page_list_limit == '200'?'selected="selected"':'').'>200</option>';
		          //       		$pagination.= '<option value="'.$script_name.'?pagination_limit=500'.$pg_url_params.'" '.($page_list_limit == '500'?'selected="selected"':'').'>500</option>';
		          //       	$pagination.= "</select>";
	            //     	$pagination.= '</li>';
					$pagination.= "</ul>";
				$pagination.= "</div>";
			$pagination.= "</div>";
		$pagination.= "</div>\n";
		return $pagination;
	}
}
