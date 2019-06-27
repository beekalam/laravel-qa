<a class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->is_favorited ? 'favorited' : '') }}"
   onclick="event.preventDefault(); document.getElementById('favorite-question-{{$model->id}}').submit();"
   title="Click to mark as favorite question(Click again to undo)">
    <i class="fa fa-star fa-3x"></i>
    <span class="favorites-count">{{ $model->favorites_count }}</span>
</a>
<form id="favorite-question-{{ $model->id }}"
      style="display: none;"
      action="/questions/{{ $model->id }}/favorites" method="POST">
    @csrf
    @if($model->is_favorited)
        @method('DELETE')
    @endif
</form>