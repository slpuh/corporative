@foreach($items as $item)
<li id="li-comment-{{ $item->id }}" class="comment even {{ ($item->user_id == $article->user_id) ? 'bypostauthor odd' : '' }}">
    <div  id="comment-{{ $item->id }}" class="comment-container">
        <div class="comment-author vcard">
            @set($hash, ($item->email) ? md5($item->email) : ($item->user->email))
            <img alt="" src="https://gravatar.com/avatar/{{ $hash }}?d=mm&s=75" class="avatar" height="75" width="75" />
            <cite class="fn">{{ $item->user['name'] ? $item->user['name'] : $item->name }}</cite>                 
        </div>
        <!-- .comment-author .vcard -->
        <div class="comment-meta commentmetadata">
            <div class="intro">
                <div class="commentDate">
                    <a href="#comment-2">
                        {{ $item->created_at->format('F d, Y \a\t H:i') }}</a>                        
                </div>
                <div class="commentNumber">#&nbsp;1</div>
            </div>
            <div class="comment-body">
                <p>{{ $item->text }}</p>
            </div>
            <div class="reply group">
                <a class="comment-reply-link" href="#respond" onclick="return addComment.moveForm(&quot;comment-{{ $item->id }}&quot;, &quot;{{ $item->id }}&quot;, &quot;respond&quot;, &quot;{{ $item->article->id }}&quot;)">Reply</a>                    
            </div>
            <!-- .reply -->
        </div>
        <!-- .comment-meta .commentmetadata -->
    </div>
    <!-- #comment-##  -->
    @if(isset($com[$item->id]))
    <ul class="children">        
        @include(config('settings.theme').'.comment',['items' => $com[$item->id]])
    </ul>    
    @endif
</li>
@endforeach

