@extends('layouts.app')
@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                {{--问题展示区--}}
                <div class="card">
                    <div class="card-header">
                        {{ $question->title }}
                        @foreach($question->topics as $topic)
                            <a class="topic float-right" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                        @endforeach
                    </div>
                    <div class="card-body content">
                        <p class="card-text">
                            {!! $question->body !!}
                        </p>
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="{{ route('question.edit',$question->id) }}">编辑</a></span>
                            <form action="{{ route('question.destroy',$question->id) }}" method="POST" class="delete-form">
                                {{ method_field('DELETE') }}
                                @csrf
                                {{--TODO 删除确认--}}
                                <button class="button is-naked delete-button">删除</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                {{--问题关注--}}
                <div class="card">
                    <div class="card-body question-follow">
                        <h2>{{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <hr>
                    <div class="card-body">
                        <question-follow-button question="{{$question->id}}"></question-follow-button>
                        <a href="#editor" class="btn btn-primary float-right">撰写答案</a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-1 mt-3">
                {{--问题回答--}}
                <div class="card">
                    <div class="card-header">
                        {{ $question->answers_count }} 个答案
                    </div>
                    <div>
                        <div class="card-body">
                            @foreach($question->answers as $answer)
                                <div class="media">
                                    <img src="{{ $answer->user->avatar }}" class="mr-3 mb-3 rounded-circle" style="width:64px;" alt="{{ $answer->user->name }}">
                                    <div class="media-body">
                                        <a href="">
                                            <h5 class="mt-0">{{ $answer->user->name }}</h5>
                                        </a>
                                        {!! $answer->body !!}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="card-body content">
                        @if(Auth::check())
                            <form action="/question/{{ $question->id }}/answer" method="post">
                            @csrf
                            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                                <label for="body">撰写答案</label>

                                <script id="container" name="body" type="text/plain">{!! old('body') !!}</script>

                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success float-right" type="submit">发表回答</button>
                        </form>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-success btn-block">登录提交答案</a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-3 mt-3">
                <div class="card">
                    <div class="card-header question-follow">
                        <h5>关于作者</h5>
                    </div>
                    <div class="card-body">
                        <div class="media">
                            <img src="{{ $question->user->avatar }}" class="mr-3 mb-3 rounded-circle" style="width:36px;" alt="{{ $question->user->name }}">
                            <div class="media-body">
                                <a href="">
                                    <h5 class="mt-0">{{ $question->user->name }}</h5>
                                </a>
                            </div>
                        </div>

                        <div class="user-statics" >
                            <div class="statics-item text-center">
                                <div class="statics-text">问题</div>
                                <div class="statics-count">{{ $question->user->questions_count }}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">回答</div>
                                <div class="statics-count">{{ $question->answers_count }}</div>
                            </div>
                            <div class="statics-item text-center">
                                <div class="statics-text">关注者</div>
                                <div class="statics-count">{{ $question->user->followers_count }}</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <user-follow-button user="{{$question->user_id}}"></user-follow-button>
                            <a href="#editor" class="btn btn-primary float-right">撰写答案</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            toolbars: [
                ['bold', 'italic', 'underline', 'strikethrough', 'blockquote', 'insertunorderedlist', 'insertorderedlist', 'justifyleft','justifycenter', 'justifyright',  'link', 'insertimage', 'fullscreen']
            ],
            elementPathEnabled: false,
            enableContextMenu: false,
            autoClearEmptyNode:true,
            wordCount:false,
            imagePopup:false,
            autotypeset:{ indent: true,imageBlockLine: 'center' }
        });
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
    </script>
@endsection