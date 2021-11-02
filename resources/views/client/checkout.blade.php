@extends('clientlayouts.client')
@section('title')
	Checkout
@endsection
@section('content')
    <!-- start content -->
	
	<div class="hero-wrap hero-bread" style="background-image: url('frontend/images/bg_1.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-7 ftco-animate">
				<form action="{{url('/postCheckout')}}" method="POST" class="billing-form">
					{{ csrf_field() }}
					@if (count($errors)>0)
						<div class="alert alert-danger">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{$error}}</li>
								@endforeach
							</ul>
						</div>
					@endif
					<h3 class="mb-4 billing-heading">Billing Details</h3>
					<div class="row align-items-end">
						<div class="col-md-12">
							<div class="form-group">
								<label for="firstname">First Name</label>
							<input type="text" class="form-control" name="firstName">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="lastname">Last Name</label>
							<input type="text" class="form-control" name="lastName">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="adress">Address</label>
							<input type="text" class="form-control"  name="adress">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="city">City</label>
							<input type="text" class="form-control" id="card-name" name="city">
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label for="phone">Phone Number</label>
							<input type="text" class="form-control" id="phone" name="phone">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="lastname">Postal Code</label>
							<input type="text" id="postal" name="postal" class="form-control">
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Buy Now">
							</div>
						</div>
					</div>
	          </form><!-- END -->
					</div>
					<div class="col-xl-5">
	          <div class="row mt-5 pt-3">
	          	<div class="col-md-12 d-flex mb-5">
	          		<div class="cart-detail cart-total p-3 p-md-4">
	          			<h3 class="billing-heading mb-4">Cart Total</h3>
	          			<p class="d-flex">
		    						<span>Subtotal</span>
		    						<span>$20.60</span>
		    					</p>
		    					<p class="d-flex">
		    						<span>Delivery</span>
		    						<span>$0.00</span>
		    					</p>
		    					<p class="d-flex">
		    						<span>Discount</span>
		    						<span>$3.00</span>
		    					</p>
		    					<hr>
		    					<p class="d-flex total-price">
		    						<span>Total</span>
		    						<span>$17.60</span>
		    					</p>
								</div>
	          	</div>
	          </div>
          </div> <!-- .col-md-8 -->
        </div>
      </div>
    </section> <!-- .section -->

  
 @endsection

 @section('scripts')
 <script>
    $(document).ready(function(){

    var quantitiy=0;
       $('.quantity-right-plus').click(function(e){
            
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            
            // If is not undefined
                
                $('#quantity').val(quantity + 1);

              
                // Increment
            
        });

         $('.quantity-left-minus').click(function(e){
            // Stop acting like a button
            e.preventDefault();
            // Get the field name
            var quantity = parseInt($('#quantity').val());
            
            // If is not undefined
          
                // Increment
                if(quantity>0){
                $('#quantity').val(quantity - 1);
                }
        });
        
    });
</script>
 @endsection