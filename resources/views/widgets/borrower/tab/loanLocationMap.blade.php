@var	$show_map	=	"yes"   

<div class="row">						
	<div class="col-xs-12 col-sm-5 col-lg-3">											
		<label>
			{{ Lang::get('Location Description') }}
		</label>												
	</div>																	
	<div class="col-xs-12 col-sm-7 col-lg-6">	
		<input 	type="text" 
				class="form-control select-width"
				 name="location_description"
				 id="location_description"
				 value="" 
				 />		
		<input id="find" type="button" value="find" style="display:none;" />							
	</div>	
</div>
@if($show_map	==	"yes")		
<div class="row" style="margin-top:20px;margin-bottom:20px">						
	<div class="col-xs-12 col-sm-12 col-lg-12">	
		 <div id="map" style="width: 100%; height: 400px;"></div>	
		  <div class="clearfix">&nbsp;</div>				
	</div>	
</div>
<div class="row">	
						
	<div class="col-xs-12 col-sm-5 col-lg-3">											
		<label>
			{{ Lang::get('Latitude') }}
		</label>												
	</div>																	
	<div class="col-xs-12 col-sm-7 col-lg-3">	
		<input 	type="text" 
				class="form-control select-width"
				data-geo="lat"
				 name="latitude"
				 id="latitude"
				 readonly
				 value="">									
	</div>	
	
	<div class="col-xs-12 col-sm-5 col-lg-3">											
		<label>
			{{ Lang::get('Longitude') }}
		</label>												
	</div>																
	<div class="col-xs-12 col-sm-7 col-lg-3" id="min_for_partial_sub_parent">														 
		<input 	type="text" 
				class="form-control gllpLongitude"
				 name="longitude"
				 id="longitude"
				 data-geo="lng"
				 readonly
				 value="">																				
	</div>
</div>
@endif
	
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtPomFtY3PK40upiQe93aiU0qYieJN4fo&callback=initMap"
  type="text/javascript"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="{{ url('js/jquery.geocomplete.js') }}"></script>
<script>
	$(document).ready(function(){ 
		
		var options = {
			map: "#map",
			details: "form ",
			detailsAttribute: "data-geo",
			markerOptions: {
			draggable: true
			},
			location:""
		};
		
		$("#location_description").geocomplete(options);
	 
		
		//~ $("#location_description").geocomplete(options);
		
		$("#location_description").bind("geocode:dragged", function(event, latLng){
			if(latLng	!=	undefined)	{
				//~ $("#latitude").val(latLng.lat());
				//~ $("#longitude").val(latLng.lng());
				 $("input[name=latitude]").val(latLng.lat());
			  $("input[name=longitude]").val(latLng.lng());
			}
		});
		
		$("#location_description").bind("geocode:click", function(event, latLng){
			if(latLng	!=	undefined)	{
				//~ $("#latitude").val(latLng.lat());
				//~ $("#longitude").val(latLng.lng());
				 $("input[name=latitude]").val(latLng.lat());
			  $("input[name=longitude]").val(latLng.lng());
			}
		});
		 $("#find").click(function(){
			  $("#location_description").trigger("geocode");
			}).click();
	  
		
	}); 

</script>
