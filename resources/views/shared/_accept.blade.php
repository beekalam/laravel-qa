@can('accept',$model)
    <a class="mt-2 {{ $model->status }}"
       onclick="event.preventDefault();document.getElementById('accept-answer-{{ $model->id }}').submit()"
       title="Mark this answer as best answer.">
        <i class="fa fa-check fa-3x"></i>
    </a>
    <form id="accept-answer-{{ $model->id }}"
          style="display:none;"
          action="{{ route('answers.accept', $model->id) }}" method="post">
        @csrf
    </form>
@else
    @if($model->is_best)
        <a class="mt-2 {{ $model->status }}"
           title="The question owner accepted this answer as bet answer.">
            <i class="fa fa-check fa-3x"></i>
        </a>
    @endif
@endcan