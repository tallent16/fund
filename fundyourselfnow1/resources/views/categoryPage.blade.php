@extends('layouts.plane')

@section('body')
@include('header',array('class'=>'',))

<div class="inner_page">

<!-- start projects area here -->
	<section class="project_area">
		<div class="container">

		<!-- explore categories area here -->
				<article class="project_boxouter">
                            @var $exploreurl = "/categories/"
                             @var $exploreurl = url($exploreurl)
				<h3>Explore Categories <!--<a href="{{ $exploreurl }}" class="see_all">See All</a>--></h3>
				<div class="row">
                                  @foreach ($home-> filterIndustryList as $loanRow)
					<aside class="col-sm-3 col-xs-6">
                                              @var $loanurl = "/explorecategories/".base64_encode($loanRow->codelist_value)
                                                  @var $exploreurl = url($loanurl)
						<div class="category_box">
                                                  <a  href="{{ url($loanurl) }}">
							<img src="{{config('moneymatch_settings.image_url') }}{{$loanRow->expression}}" alt="" /></a>
							<div class="category_caption">
								<a href="{{ url($loanurl) }}">
									<span class="icon-cat"><i class="fa fa-cogs" aria-hidden="true"></i></span><br/>
									{{$loanRow->codelist_value}}
								</a>
							</div>
						</div>
					</aside>
	                            @endforeach
					
				</div>
			</article>
		<!-- explore categories area here -->

		</div>
	</section>
<!-- end projects area here -->

</div>
<footer class="footer">
@include('footer')

</footer>
@endsection
@stop