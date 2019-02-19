<li id="li-comment-{{ $data['id'] }}" class="comment even borGreen">
    <div  id="comment-{{ $data['id'] }}" class="comment-container">
        <div class="comment-author vcard">            
            <img alt="" src="https://gravatar.com/avatar/{{ $data['hash'] }}?d=mm&s=75" class="avatar" height="75" width="75" />
            <cite class="fn">{{ $data['name'] }}</cite>                 
        </div>
        <!-- .comment-author .vcard -->
        <div class="comment-meta commentmetadata">
            <div class="intro">                
                <div class="commentNumber">#&nbsp;1</div>
            </div>
            <div class="comment-body">
                <p>{{ $data['text'] }}</p>
            </div>
        </div>
    </div>
</li>
