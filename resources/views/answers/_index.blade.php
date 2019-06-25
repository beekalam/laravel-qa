<div class="row mt-4 justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">
                    <h2>{{ $answersCount . " " . str_plural('answer',$answersCount) }}</h2>
                </h5>
                <hr>
                @include('layouts._messages')

                @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This answer is useful" class="vote-up">
                                <i class="fa fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">123</span>
                            <a title="This answer is not useful" class="vote-down off">
                                <i class="fa fa-caret-down fa-3x"></i>
                            </a>
                            @can('accept',$answer)
                                <a class="mt-2 {{ $answer->status }}"
                                   onclick="event.preventDefault();document.getElementById('accept-answer-{{ $answer->id }}').submit()"
                                   title="Mark this answer as best answer.">
                                    <i class="fa fa-check fa-3x"></i>
                                </a>
                                <form id="accept-answer-{{ $answer->id }}"
                                      style="display:none;"
                                      action="{{ route('answers.accept', $answer->id) }}" method="post">
                                    @csrf
                                </form>
                            @else
                                @if($answer->is_best)
                                    <a class="mt-2 {{ $answer->status }}"
                                       title="The question owner accepted this answer as bet answer.">
                                        <i class="fa fa-check fa-3x"></i>
                                    </a>
                                @endif
                            @endcan
                        </div>
                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        @can('update',$answer)
                                            <a href="{{ route('questions.answers.edit', [$question->id,$answer->id]) }}"
                                               class="btn btn-sm btn-outline-info">Edit</a>
                                        @endcan

                                        @can('delete',$answer)
                                            <form action="{{ route('questions.answers.destroy', [$question->id,$answer->id]) }}"
                                                  class="form-delete"
                                                  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onClick="return confirm('Are you sure?')">Delete
                                                </button>

                                            </form>
                                        @endcan
                                    </div>
                                </div>

                                <div class="col-4"></div>
                                <div class="col-4">
                                    <span class="text-muted">Answered {{ $answer->created_date }}</span>
                                    <div class="media mt-2">
                                        <a href="{{ $answer->user->url }}" class="pr-2">
                                            <img src="{{ $answer->user->avatar }}" alt="">
                                        </a>
                                        <div class="media-body mt-1">
                                            <a href="{{ $answer->user->url }}"> {{ $answer->user->name }} </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>