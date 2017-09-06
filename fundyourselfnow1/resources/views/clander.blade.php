@extends('layouts.dashboard')
@section('bottomscripts') 

<script>
$(document).ready(function(){
  $('.dropdown-submenu a.dropdown-submenulink').on("click", function(e){
    $(this).next('ul').toggle();
    e.stopPropagation();
    e.preventDefault();
  });
  $(".mobile_search i").click(function(){
  	$(".mobile_search_box").show();
  });
  $(".close_btn").click(function(){
  	$(".mobile_search_box").hide();
  });
});
</script>
@endsection
@section('body')

                    <!-- .navbar -->
                   @include('header')
                    <!-- /.navbar -->
                



<div class="inner_page">
	<!-- start ico calendar area here -->
	<section class="ico_calendar">
		<div class="container">
			<h3>Ongoing Projects</h3>
			<div class="responsive-table">
				<table width="100%" cellspacing="0" cellpadding="0" class="table_area">
					<thead>
						<tr>
							<th width="10%" class="project_mobile_btn_box"></th>
							<th width="10%"></th>
							<th width="15%">Digital asset</th>
							<th width="15%">Opened</th>
							<th width="15%">Closes</th>
							<th width="35%">Description</th>
							<th width="10%" class="project_web_btn_box"></th>
						</tr>
					</thead>
					<tbody> 
					  @foreach ($home as $loanRow)

      <?php


			$nowtime = date('Y-m-d H:i:s');

			$datetime1 = $loanRow->crowd_start_date;
			$datetime2 = $loanRow->crowd_end_date;

			$cur_time   = strtotime($nowtime);
			$time_ago    = strtotime($datetime1);
			$time_pend = strtotime($datetime2);

			$time_elapsed   = $cur_time - $time_ago;
			$time_pending   = $time_pend - $cur_time;

			$seconds    = $time_elapsed ;
			$minutes    = round($time_elapsed / 60 );
			$hours      = round($time_elapsed / 3600);
			$days       = round($time_elapsed / 86400 );
			$weeks      = round($time_elapsed / 604800);
			$months     = round($time_elapsed / 2592000);
			$years      = round($time_elapsed / 31536000);
			// Seconds
			if($seconds <= 60){
			$from = "just now";
			}
			//Minutes
			else if($minutes <=60){
			
			$from = "$minutes min ago";
			
			}
			//Hours
			else if($hours <=24){
			
			$from = "$hours hrs ago";
			
			}
			//Days
			else if($days <= 7){
			
			$from = "$days days ago";
			
			}
			//Weeks
			else if($weeks <= 4.3){
			
			$from = "$days days ago";
			
			}
			//Months
			else if($months <=12){
			
			$from = "$months months ago";
			
			}
			//Years
			else{
			if($years==1){
			$from = "1 year ago";
			}else{
			$from = "$years years ago";
			}
			}

			$seconds2    = $time_pending ;
			$minutes2    = round($time_pending / 60 );
			$hours2      = round($time_pending / 3600);
			$days2       = round($time_pending / 86400 );
			$weeks2      = round($time_pending / 604800);
			$months2     = round($time_pending / 2592000);
			$years2      = round($time_pending / 31536000);
			// Seconds
			if($seconds2 <= 60){
			$to = "Closed";
			}
			//Minutes
			else if($minutes2 <=60){
			
			$to = " in $minutes2 min";
			
			}
			//Hours
			else if($hours2 <=24){
			
			$to = "in $hours2 hre";
			
			}
			//Days
			else if($days2 <= 7){
			
			$to = "in $days2 days";
			
			}
			//Weeks
			else if($weeks2 <= 4.3){
			
			$to = "$days2 days to go";
			
			}
			//Months
			else if($months2 <=12){
			
			$to = "in $months2 months";
			
			}
			//Years
			else{
			if($years2==1){
			$to = "in 1 year";
			}else{
			$to = "in $years years";
			}
			}
			if(@$loanRow->follow && $loanRow->follow == '1'){
				$status = '0';
			}else{
				$status = '1';
			}
			 
		


		?>
							 
				<tr>
							<td class="project_mobile_btn_box" style=" white-space: nowrap;overflow: hidden;width: 125px;height: 25px;">
								<a href="#" class="yellow_btn project_mobile_btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
							</td>
							<td>
								<img class="project_image_icon" src="https://s3-ap-southeast-1.amazonaws.com/devfyn/{{$loanRow->loan_image_url}}" alt="" />
							</td>
							<td><a href="{{url('projectdetails')}}/{{base64_encode($loanRow->loan_id)}}">{{$loanRow->loan_title}}</a></td>
							<td>{{$loanRow->crowd_start_date}}<span class="date_grey">{{$from}}</span></td>
							<td>{{$loanRow->crowd_end_date}}<span class="date_grey">{{$to}}</span></td>
							<td><div style="max-height: 75px;overflow: hidden;max-width: 300px;">{{str_limit(strip_tags($loanRow->loan_description), $limit = 50, $end = '...') }}<br> <a href="{{url('projectdetails')}}/{{base64_encode($loanRow->loan_id)}}">View more</a></div></td>
							<td class="project_web_btn_box"><a href="{{url('followNow')}}/{{base64_encode($loanRow->loan_id)}}/{{$status}}" class="yellow_btn">
							<?php if($status == '0'){
								echo "Unfollow";
							}else{
								echo "Follow Now";
							} ?>
							</a></td>
						</tr>
							@endforeach
						
					</tbody>
				</table>
			</div>
		</div>
	</section>
	<!-- end ico calendar area here -->
</div>




@endsection
@stop