@extends ('layouts.plane')
@section ('body')
<!-- Register Content -->
<div class="container">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-7 register-style">		
            <!-- Register Block -->
            <div class="block block-themed">
				<div class="row header-register">
					<div class="block-header">	
						<div class="row">
							<div class="col-md-3"><h5 class="block-title">&nbsp;</h5></div> 
							<div class="col-md-9 text-right"> </div>
						</div>
					</div>      
				</div>                            
            </div>
                          
                <div class="row col-md-offset-4"> 
					<a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a> 
				</div>
                <div class="block-content block-content-full block-content-narrow">                    
				{{ Html::image('img/404.jpg',"",['class' => 'img-responsive']) }} 
				<p class="text-center">Visit Homepage <a href="{{ url('') }}">Click</a></p>
                </div>
                
            </div>
            <!-- END Register Block -->
        </div>
          
    </div>
</div>
<!-- END Register Content -->
@endsection
@stop
