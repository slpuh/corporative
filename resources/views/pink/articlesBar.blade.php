<div class="widget-first widget recent-posts">
    <h3>{{ Lang::get('ru.latest_projects') }}</h3>
    <div class="recent-post group">
        @if(!$portfolios->isEmpty())
        @foreach($portfolios as $portfolio)
        <div class="hentry-post group">
            <div class="thumb-img"><img style="width:55px" src="{{ asset(config('settings.theme')) }}/images/projects/{{ $portfolio->img->mini }}" alt="001" title="{{ $portfolio->title }}" /></div>
            <div class="text">
                <a href="{{ route('portfolios.show',['alias' => $portfolio->alias ]) }}" title="{{ $portfolio->title }}" class="title">{{ $portfolio->title }}</a>
                <p>{{ str_limit($portfolio->text, 150) }} </p>
                <a class="read-more" href="{{ route('portfolios.show',['alias' => $portfolio->alias ]) }}">&rarr; {{ Lang::get('ru.read_more') }}</a>
            </div>
        </div>                
        @endforeach          
        @endif                   
    </div>
</div>	        

<div class="widget-last widget recent-comments">
    <h3>{{ Lang::get('ru.latest_comments') }}</h3>
    <div class="recent-post recent-comments group">
        @if(!$comments->isEmpty())
        @foreach($comments as $comment)
        <div class="the-post group">
            <div class="avatar">
                @set($hash, ($comment->email) ? md5($comment->email) : ($comment->user->email))
                <img alt="" src="https://gravatar.com/avatar/{{ $hash }}?d=mm&s=55" class="avatar" />   
            </div>
            <span class="author"><strong><a href="#">{{ isset($comment->user) ? $comment->user->name : $comment->name}}</a></strong> in</span> 
            <a class="title" href="{{ route('articles.show',['alias' => $comment->article->alias ]) }}">{{ $comment->article->title }}</a>
            <p class="comment">
                {{ str_limit($comment->text,100) }} <a class="goto" href="{{ route('articles.show',['alias' => $comment->article->alias ]) }}">&#187;</a>
            </p>
        </div>
        @endforeach          
        @endif         
    </div>
</div>