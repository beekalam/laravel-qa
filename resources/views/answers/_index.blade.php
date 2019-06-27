@if($answersCount > 0)
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
                                <a title="This answer is useful"
                                   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('upvote-answer-{{$answer->id}}').submit();">
                                    <i class="fa fa-caret-up fa-3x"></i>
                                </a>
                                <form id="upvote-answer-{{ $answer->id }}"
                                      style="display: none;"
                                      action="/answers/{{ $answer->id }}/vote" method="POST">
                                    @csrf
                                    <input type="hidden" name="vote" value="1">
                                </form>
                                <span class="votes-count">{{ $answer->votes_count }}</span>
                                <a title="This answer is not useful"
                                   class="vote-up {{ Auth::guest() ? 'off' : '' }}"
                                   onclick="event.preventDefault(); document.getElementById('downvote-answer-{{$answer->id}}').submit();">
                                    <i class="fa fa-caret-down fa-3x"></i>
                                </a>
                                <form id="downvote-answer-{{ $answer->id }}"
                                      style="display: none;"
                                      action="/answers/{{ $answer->id }}/vote" method="POST">
                                    @csrf
                                    <input type="hidden" name="vote" value="-1">
                                </form>

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
                                        @include('shared._author',[
                                          'model' => $answer,
                                          'label' => 'answered'
                                        ])
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

@endif

