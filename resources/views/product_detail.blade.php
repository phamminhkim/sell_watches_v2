@extends('layouts.template_home')

@section('content')
<product-detail :id="{{ $id }}"></product-detail>

@endsection