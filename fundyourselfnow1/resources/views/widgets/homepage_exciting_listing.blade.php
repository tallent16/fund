@var $loanurl = "/projectdetails/".base64_encode($loanRow->loan_id)
@var $loanurl = url($loanurl)	

              <script type ="text/javascript">
              	var contract_address = "<?php echo $loanRow->wallet_address ?>"; 
               var eth_bal = "<?php echo $loanRow->eth_baalance ?>";
				var total_fund = "<?php echo $loanRow->apply_amount ?>";	
				var    loan_id = "<?php  echo $loanRow->loan_id ?>";
					my_values(eth_bal,contract_address,total_fund,loan_id);
           
	   // var contract_address = "0xB1021477444C6566509e1b80d2C99E9603A31C47";
	      
		// 
		$('#funded').hide();
          function my_values(eth_bal,contract_address,total_fund,loan_id){
          	var funded = $('#funded').text();
          	
               $.ajax({
				type : 'GET', // define the type of HTTP verb we want to use (POST for our form)
				url : "https://api.etherscan.io/api?module=account&action=balance&address="+contract_address+"&tag=latest&apikey=A29IKN94TG6K54MMXGFHD5PICRNY73G33I" , //Etherium api to get cuurent balance of smart contract adddress
				dataType    : 'json'
			}).done(function(data) {
				if(eth_bal==''){ 
					eth_bal = 0;
				}
			
            if(data.result=='Error!'){
			   	data.result = 0;
			   }
			 
				var eth1 = parseFloat(eth_bal);
				var eth2 = (parseFloat(data.result)/1000000000000000000).toFixed(8);
            	  
				var total_eth = parseFloat(eth1)+parseFloat(eth2);
				$('.eth'+loan_id).html(total_eth);
                              
                    
                     var percent = total_eth/total_fund;
                                   
                     var final_per = parseFloat(percent*100).toFixed(2);
                     
                  $('.total_per'+loan_id).html(final_per+' % '+funded)
                $('#'+loan_id).html('<div style="width:'+final_per+'%" aria-valuemax="100" aria-valuemin="0" aria-valuenow="42" role="progressbar" class="progress-bar progress-bar-danger"><span class="sr-only">'+final_per+'% Complete</span></div>')

			});	
		}
			
					</script>
				 
	
<aside class="col-sm-4 col-xs-6">
						<div class="project_box">
					
							<a>
								<div class="project_imagebox">
									<img style="cursor:pointer" onclick="redirecturl('{{ $loanurl }}')" src="{{config('moneymatch_settings.image_url') }}{{$loanRow->loan_image_url}}" alt="" />
								</div>
							</a>
							<div class="project_contentarea">
								<h4><a  onclick="redirecturl('{{ $loanurl }}')">{{$loanRow->loan_title}}</a></h4>
								<div class="progress_area">
									<p>{{floor($loanRow->apply_amount)}} ETH <span>(<b class="eth<?php  echo $loanRow->loan_id; ?>"></b> ETH)</span></p>
									<div class="progress" id= "<?php  echo $loanRow->loan_id; ?>" style="height:10px;margin-bottom:5px;">
										
									</div>
									<p class="pull-left total_per<?php  echo $loanRow->loan_id; ?>"></p>
									<p class="pull-right">{{$loanRow->days_to_go}} {{Lang::get('project_detail.day_left')}}</p>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
					</aside>
