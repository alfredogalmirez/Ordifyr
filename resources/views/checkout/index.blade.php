<h1>Checkout</h1>

@foreach ($cart->items as $item)
    {{ $item->product->name }}
    x {{ $item->quantity }}
@endforeach

<form method="POST" action="">
    @csrf
    <button>Proceed to Payment</button>
</form>
