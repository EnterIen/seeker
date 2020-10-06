@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                <strong>{{ $question->title }}</strong>
                <a class="btn-card-header" href="{{ route('question.follow',[$question->id]) }}">{{ $question->follow->count() ? '取消关注' : '关注' }}</a>
                </div>
                <div class="card-body">
                <p>
                @foreach($question->labels as $label)
                <a href="{{ route('label.show',[$label->id]) }}" class="badge badge-pill badge-primary badge-label">{{ $label->name }}</a>
                @endforeach
                </p>
                <p>
                {!! nl2br($question->description) !!}
                </p>
                @if($question->user->id == Auth::id())
                <a class="btn btn-link btn-edit" href="{{ route('question.edit',[$question->id]) }}">编辑</a>
                @endif
                </div>
            </div>

           @foreach($question->answers as $answer)
             <div class="card" id="answer{{ $answer->id }}">
               <div class="card-body">
                 <p><a href="{{ route('user.show',[$answer->user->id]) }}">
                 <img class="avatar-small" src="{{ asset('images/avatar/'.$answer->user->avatar) }}"> 
                 {{ $answer->user->name }}
                 </a></p>
                 <p>{!! nl2br($answer->content ?? '') !!}</p>
                 <a id="{{ $answer->id }}" href="{{ route('answer.like',['id'=>$answer->id]) }}" class="btn btn-warning">赞 {{ $answer->likes->count() }}</a>
                 <input type="hidden" id="answer-content" value="{!! $answer->content ?? '' !!}">

                 @if ($answer->user->id == Auth::id())
                 <a href="#answer" class="btn btn-link btn-edit" id="edit-answer">编辑</a>
                 @endif
               </div>
             </div>
           @endforeach

           <div class="card card-answer" style="{{ ($answer->user->id ?? 0) != Auth::id() ? '' : 'display:none' }}">
           <div class="card-body">
               <form method="post" action="{{ route('question.answer',[$question->id]) }}">
                 @csrf
                 <div class="form-group">
                   <label for="question">添加回答</label>
                   <textarea name="content" rows=8 class="form-control" id="answer" value="{{old('content')}}"></textarea>
                    @if ($errors->has('content'))
                    <p class="alert alert-danger">{{ $errors->first('content') }}</p>
                    @endif
                 </div>
               <button type="submit" class="btn btn-primary">提交</button>
               </form>
           <div>
           <div>

        </div>
    </div>
</div>
@endsection