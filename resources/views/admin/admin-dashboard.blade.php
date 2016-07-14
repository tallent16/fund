@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('borrower-dashboard.page_heading') )
@section('section')           
<div class="col-sm-12 space-around"> 

	<!--row--->
	<div class="row">
		<!-----first col----->
		<div class="col-lg-6 col-md-6">
			<h4>{{Lang::get('PERIODIC SNAPSHOT')}}</h4>

			<div class="panel-group" id="{{$periodic_snapshot['panel_group_id']}}">
			@if(isset($periodic_snapshot["panel_group_id"]))
			@foreach($periodic_snapshot["panels"] as $panelRow) 

			@var 	$groupID		=	$periodic_snapshot["panel_group_id"];
			@var 	$panelID		=	$panelRow['panel_id'];
			@var 	$panelTitle		=	$panelRow['panel_title'];
			@var 	$panelWidget	=	$panelRow['panel_body_widget'];
			@var 	$panelBody		=	$panelRow['panel_body_content'];
			@var	$panelColClass	=	"";
			@if( isset($panelRow['panel_collapse_class']))
				@var $panelColClass	=	$panelRow['panel_collapse_class'];
			@endif
			@include('widgets.accordion_widget', array(
														"panel_group_id"	=>	$groupID,
														"panel_id"			=>	$panelID,
														"panel_title"		=>	$panelTitle,
														"panel_body_widget"	=>	$panelWidget,
														"panel_body_content"=>	$panelBody,
														"panel_collapse_class"=>$panelColClass
														
														))
			@endforeach
			@endif
			</div>
		</div>
		<!-----first col end----->
		<!-----second col-------->
		<div class="col-lg-6 col-md-6">
			<div class="panel panel-default">
				<div class="panel-body">
				@section ('cchart4_panel_title',Lang::get('Admin Chart'))
				@section ('cchart4_panel_body')
				@include('widgets.charts.cbarchart')
				@endsection
				@include('widgets.panel', array('header'=>true, 'as'=>'cchart4'))
				</div>								
			</div>				
		<!--second col end--->				
		</div>
	</div>
	
	<!--row--->
	<div class="row">
		<div class="col-lg-12 col-md-12">
			<h4>BORROWER</h4>			
			<div class="panel-group" id="accordion">
				<!-----------1 accordion---------------------->
				@var $panel_body_content = "";
				@var $panelBody		=	$dashMod->recentlyApprovedBor;
				@include('widgets.accordion_widget', array(
										"panel_group_id"	=>	"accordion",
										"panel_id"			=>	"collapseOne",
										"panel_title"		=> 	"RECENTLY APPROVED BORROWERS",
										"panel_body_widget"	=>	"widgets.admin.accordion.recently_approved_bor",
										"panel_body_content"=>	$panelBody,
										"panel_collapse_class"=> "in"
										
										))

				<!-----------2 accordion---------------------->
				@var $panelBody		=	$dashMod->toBeApprovedBor;
				@include('widgets.accordion_widget', array(
										"panel_group_id"	=>	"accordion",
										"panel_id"			=>	"collapseTwo",
										"panel_title"		=> 	"TO BE APPROVED BORROWERS",
										"panel_body_widget"	=>	"widgets.admin.accordion.to_be_approved_bor",
										"panel_body_content"=>	$panelBody,
										"panel_collapse_class"=> ""
										
										))

				<!-----------3 accordion---------------------->									
				@var $panel_body_content2 = "";
				@var $panelBody		=	$panel_body_content2.'Table content3';
				@include('widgets.accordion_widget', array(
											"panel_group_id"	=>	"accordion",
											"panel_id"			=>	"collapseThree",
											"panel_title"		=> 	"RECENT ACTIVITIES OF ALL BORROWERS",
											"panel_body_widget"	=>	
																"widgets.admin.accordion.recent_activities_bor",
											"panel_body_content"=>	$panelBody,
											"panel_collapse_class"=> ""
											
											))
			</div>              
		</div>              

		
		<div class="col-lg-12 col-md-12">

			<h4>INVESTOR</h4>			
			<div class="panel-group" id="invaccordion">
				<!-----------1 accordion---------------------->
				@var $panel_body_contentinv = "";
				@var $panelBody		=	$panel_body_contentinv.'Table content';
				@include('widgets.accordion_widget', array(
										"panel_group_id"	=>	"invaccordion",
										"panel_id"			=>	"invcollapseOne",
										"panel_title"		=> 	"RECENTLY APPROVED INVESTORS",
										"panel_body_widget"	=>	"widgets.admin.accordion.recently_approved_inv",
										"panel_body_content" =>	$panelBody,
										"panel_collapse_class" => "in"
										
										))

				<!-----------2 accordion---------------------->
				@var $panel_body_content1inv = "";
				@var $panelBody		=	$panel_body_content1inv.'Table content2';
				@include('widgets.accordion_widget', array(
										"panel_group_id"	=>	"invaccordion",
										"panel_id"			=>	"invcollapseTwo",
										"panel_title"		=> 	"TO BE APPROVED INVESTORS",
										"panel_body_widget"	=>	"widgets.admin.accordion.to_be_approved_inv",
										"panel_body_content" =>	$panelBody,
										"panel_collapse_class" => "panel-collapse"
										
										))

				<!-----------3 accordion---------------------->									
				@var $panel_body_content2inv = "";
				@var $panelBody		=	$panel_body_content2inv.'Table content3';
				@include('widgets.accordion_widget', array(
										"panel_group_id"	=>	"invaccordion",
										"panel_id"			=>	"invcollapseThree",
										"panel_title"		=> 	"RECENT ACTIVITIES OF ALL INVESTORS",
										"panel_body_widget"	 =>	"widgets.admin.accordion.recent_activities_inv",
										"panel_body_content" =>	$panelBody,
										"panel_collapse_class" => "panel-collapse"
										))
			</div> 
		</div>              
	</div>              
</div>              
  @endsection   
@stop
