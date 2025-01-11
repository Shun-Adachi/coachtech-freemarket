@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sccess.css')}}">
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')
<section>
  <p>
    We appreciate your business! If you have any questions, please email
    <a href="mailto:orders@example.com">orders@example.com</a>.
  </p>
</section>
@endsection