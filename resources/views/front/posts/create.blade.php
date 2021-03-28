<?php
$title = '投稿登録';
?>
@extends('back.layouts.base')
 
@section('content')
    <div class="card-header">{{ $title }}</div>
    <div class="card-body">
        {{ Form::open(['route' => 'back.posts.store']) }}
        @include('back.posts._form')  {{-- フォームは、登録と編集共通でおなじになるので、共通のファイルとして作り、「@include」で読み込む --}}
        {{ Form::close() }}
    </div>
@endsection