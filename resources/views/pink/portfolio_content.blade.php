<div id="content-page" class="content group">
    <div class="clear"></div>
    <div class="posts">
        <div class="group portfolio-post internal-post">
            @if($portfolio)
            <div id="portfolio" class="portfolio-full-description">

                <div class="fulldescription_title gallery-filters">
                    <h1>{{ $portfolio->title }}</h1>
                </div>

                <div class="portfolios hentry work group">
                    <div class="work-thumbnail">
                        <a class="thumb"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->max }}" alt="0081" title="0081" /></a>
                    </div>
                    <div class="work-description">
                        <p>{{ $portfolio->text }}</p>
                        <p>Sed <a href="http://yourinspirationweb.com/demo/sheeva/work/xmas-icons/#">porttitor eros </a>ut purus elementum a consectetur purus vulputate</p>
                        <div class="clear"></div>
                        <div class="work-skillsdate">
                            <p class="skills"><span class="label">Filter:</span> {{ $portfolio->filter->title }}</p>
                            <p class="workdate"><span class="label">Customer:</span> {{ $portfolio->customer }}</p>
                            <p class="workdate"><span class="label">Year:</span> {{ $portfolio->created_at->format('Y') }}</p>

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>
                @if($portfolios)
                <h3>Other Projects</h3>

                <div class="portfolio-full-description-related-projects">
                    @foreach($portfolios as $portfolio)
                    <div class="related_project">
                        <a class="related_proj related_img" href="{{ route('portfolios.show',['alias'=>$portfolio->alias]) }}" title="Love"><img src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->mini }}" alt="0061" title="0061" /></a>
                        <h4><a href="{{ route('portfolios.show',['alias'=>$portfolio->alias]) }}">{{ $portfolio->title}}</a></h4>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @endif
            <div class="clear"></div>
        </div>
    </div>
</div>

