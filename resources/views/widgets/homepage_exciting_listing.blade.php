<!--
@var $loanurl = "/projectdetails/".base64_encode($loanRow->loan_id)
@var $loanurl = url($loanurl)
				
-->
@var $loanurl = "/projectdetails/".base64_encode($loanRow->loan_id)
@var $loanurl = url($loanurl)	
	
	<div class="col-md-4 portfolio-item" style="padding:20px;">
	<div class="row" style="width:300px;height:150px;overflow:hidden;border:1px solid #ccc;border-radius: 5px;">
		<a>
			<img alt="" onclick="redirecturl('{{ $loanurl }}')" 
				style="cursor:pointer" 
				class="thumbnail pull-left image-responsive"  src="{{url()."/".$loanRow->loan_image_url}}">
				
		</a>		
	</div><!--row-->
	
	<div class="row" style="width:300px">
		<h5 style="min-height:40px;line-height:20px;">
			<a style="color:#222;cursor:pointer;text-decoration:none;" 
			onclick="redirecturl('{{ $loanurl }}')" >
			<strong>{{$loanRow->loan_title}}</strong></a>
		</h5>
			
		<strong>{{floor($loanRow->total_bid)}}</strong> ETH
		<div class="progress" style="height:10px;margin-bottom:0">
			<div style="width:{{$loanRow->perc_funded}}%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar progress-bar-danger">
			<span class="sr-only">{{$loanRow->perc_funded}}% {{ Lang::get('borrower-loanlisting.complete') }}</span>
			</div>
		</div>
		<div>
		<p class="pull-left">{{$loanRow->perc_funded}}% Funded</p>
		<p class="pull-right">{{$loanRow->funding_duration}} Days Left</p>
		</div>		
		
	</div><!--row-->
	</div><!--portfolio-->            	


