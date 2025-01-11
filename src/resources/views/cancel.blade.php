@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/cancel.css')}}">
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')
<section>
  <p>Forgot to add something to your cart? Shop around then come back to pay!</p>
</section>
@endsection