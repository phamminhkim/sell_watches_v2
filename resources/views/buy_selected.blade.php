@extends('layouts.template_home')

@section('content')
<user-card-buy :buy_selecteds = "{{ $buy_selecteds }}"></user-card-buy>

@endsection