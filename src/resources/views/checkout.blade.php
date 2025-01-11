@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/checkout.css')}}">
@endsection

@section('script')
<script src="https://js.stripe.com/v3/"></script>
@endsection


@section('content')
<h1>Stripe Payment</h1>
@if(session('success'))
<p style="color: green;">{{ session('success') }}</p>
@endif
@if(session('error'))
<p style="color: red;">{{ session('error') }}</p>
@endif
<h1>Stripe Checkout</h1>
<button id="checkout-button">Checkout</button>

<script>
  const stripe = Stripe("pk_test_51QfKSaC2TOVtBSeSqOp5pxkgyPzowSrGpKZoeNdsaRnzcEolyX3zGUCek4WxQmbY0TrCIFVTnmk62ONyyOUz5HbC00mZt8ua81");


  document.getElementById('checkout-button').addEventListener('click', async () => {
    const response = await fetch("{{ route('checkout.session') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      }
    });

    const session = await response.json();

    if (session.error) {
      alert(session.error);
    } else {
      stripe.redirectToCheckout({
        sessionId: session.id
      });
    }
  });
</script>
@endsection