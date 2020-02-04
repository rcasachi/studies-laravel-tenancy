@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form id="registration-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 offset-md-4 mb-3">
                                <h4>Account Info</h4>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="account" class="col-md-4 col-form-label text-md-right">{{ __('Account') }}</label>

                            <div class="col-md-4">
                                <input id="account" type="text" class="form-control text-right @error('account') is-invalid @enderror @error('fqdn') is-invalid @enderror" name="account" value="{{ old('account') }}" required autocomplete="account" autofocus>

                                @error('account')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('fqdn')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ str_replace('fqdn','account',$message) }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-md-4"><span class="sign-in-tld">.{{ config('app.url_base') }}</span></div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <hr class="separator mt-5 mb-4">

                        <div class="row">
                            <div class="col-md-6 offset-md-4 mb-3">
                                <h4>Choose a Plan</h4>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4 mb-3">
                                <div class="radio">
                                    <label><input type="radio" name="product" value="swell" checked>Just Swell @ $10.00/mo</label>
                                </div>
                                <div class="radio">
                                    <label><input type="radio" name="product" value="amazing">Amazing @ $11.00/mo</label>
                                </div>
                            </div>
                        </div>

                        <hr class="separator mt-3 mb-4">

                        <div class="row">
                            <div class="col-md-6 offset-md-4 mb-3">
                                <h4>Payment Info</h4>
                            </div>
                        </div>

                        <div class="form-group row">                           
                            <label for="card-holder-name" class="col-md-4 col-form-label text-md-right">{{ __('Name on Card') }}</label>

                            <div class="col-md-6">
                                <input id="card-holder-name" type="text" class="form-control @error('card-holder-name') is-invalid @enderror" name="card-holder-name" value="{{ old('card-holder-name') }}" required autocomplete="card-holder-name">

                                @error('card-holder-name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="cardnumber" class="col-md-4 col-form-label text-md-right">{{ __('Credit or Debit') }}</label>
                            <div class="col-md-6">
                                <div id="card-element">
                                    <!-- A Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </div>                        

                        <hr class="separator mt-5 mb-3">

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" id="card-button" class="btn btn-primary" data-secret="{{ $intent->client_secret }}">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        {{-- <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div> --}}
                    </form>

                    <script src="https://js.stripe.com/v3/"></script>

                    <script>
                        const form = document.getElementById( 'registration-form' );
                        const stripe = Stripe('{{ config('services.stripe.key') }}');
                        const elements = stripe.elements();
                        const cardElement = elements.create('card');
                        const cardHolderName = document.getElementById('card-holder-name');
                        const cardButton = document.getElementById('card-button');
                        const clientSecret = cardButton.dataset.secret;
                        
                        cardElement.mount('#card-element');

                        form.addEventListener( 'submit', (e) => {
                            e.preventDefault();
                        });

                        cardButton.addEventListener( 'click', async (e) => {
                            const { setupIntent, error } = await stripe.handleCardSetup(
                                clientSecret, cardElement, {
                                    payment_method_data: {
                                        billing_details: { name: cardHolderName.value }
                                    }
                                }
                            );

                            if (error) {
                                // Display "error.message" to the user...
                            } else {
                                // The card has been verified successfully...
                                handleStripePayment( setupIntent );
                            }
                        });

                        let handleStripePayment = setupIntent => {
                            
                            let paymentInput = document.createElement( 'input' );
                            paymentInput.setAttribute( 'name', 'stripePaymentMethod' );
                            paymentInput.setAttribute( 'type', 'hidden' );
                            paymentInput.setAttribute( 'value', setupIntent.payment_method );
                            form.appendChild( paymentInput );

                            form.submit();
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
