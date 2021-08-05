@extends('setup', ['menu_group' => 'Setup', 'slug' => "Setup", 'page_title' => "Select your subscription"])
@section('content')

<div class="modal fade" id="startsubmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-heading mt-2">Confirm your Subscription</h5>
                <p class="modal-text" id="form_plan_string" style="font-size: 17px; margin-bottom: 25px;">Plan</p>

                <form action="/setup/subscription" method="POST" id="paymentFrm">
                    @csrf

                    <div class="panel-body">
                        <!-- Display errors returned by createToken -->
                        <div id="paymentResponse"></div>

                        <input type="hidden" id="form_plan_id" name="form_plan_id" value="" />

                        <div class="form-group">
                            <label>Card Number</label>
                            <div style="width: 100%; padding: 5px 8px 4px 8px; border-radius: 8px; background: white;">
                                <div id="card_number" class="field"></div>
                            </div>
                        </div>

                        <div class="form-group" style="width: 120px;">
                            <label>Card Expiry</label>
                            <div style="width: 100%; padding: 5px 8px 4px 8px; border-radius: 8px; background: white;">
                                <div id="card_expiry" class="field"></div>
                            </div>
                        </div>

                        <div class="form-group" style="width: 120px;">
                            <label>CVC Code</label>
                            <div style="width: 100%; padding: 5px 8px 4px 8px; border-radius: 8px; background: white;">
                                <div id="card_cvc" class="field"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary" style="font-size: 16px; margin: 15px 0 10px 0;" id="payBtn">Submit Payment</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    // Create an instance of the Stripe object
    // Set your publishable API key
    var stripe = Stripe('pk_live_51IdC2IIZ1wGvSYnYrO44fbA5kNECugc1TFonbkwupisBiBZh3rHNwUWnsOnBaFYh3a368m64zR7sbruyy6zJ0EPw00NtIKtbWF');

    // Create an instance of elements
    var elements = stripe.elements();

    var style = {
        base: {
            fontWeight: 400,
            fontFamily: 'Jost, sans-serif',
            fontSize: '16px',
            lineHeight: '1.9',
            color: '#555',
            backgroundColor: '#fff',
            '::placeholder': {
                color: '#888',
            },
        },
        invalid: {
            color: '#eb1c26',
        }
    };

    var cardElement = elements.create('cardNumber', {
        style: style
    });
    cardElement.mount('#card_number');

    var exp = elements.create('cardExpiry', {
        'style': style
    });
    exp.mount('#card_expiry');

    var cvc = elements.create('cardCvc', {
        'style': style
    });
    cvc.mount('#card_cvc');

    // Validate input of the card elements
    var resultContainer = document.getElementById('paymentResponse');
    cardElement.addEventListener('change', function(event) {
        if (event.error) {
            resultContainer.innerHTML = '<p>'+event.error.message+'</p>';
        } else {
            resultContainer.innerHTML = '';
        }
    });

    // Get payment form element
    var form = document.getElementById('paymentFrm');

    // Create a token when the form is submitted.
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        createToken();
    });

    // Create single-use token to charge the user
    function createToken() {
        stripe.createToken(cardElement).then(function(result) {
            if (result.error) {
                // Inform the user if there was an error
                resultContainer.innerHTML = '<p>'+result.error.message+'</p>';
            } else {
                // Send the token to your server
                stripeTokenHandler(result.token);
            }
        });
    }

    // Callback to handle the response from stripe
    function stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        form.appendChild(hiddenInput);

        // Submit the form
        form.submit();
    }
</script>





<div class="modal fade" id="errormodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-heading mt-2">Error processing payment</h5>
                <p class="modal-text" style="font-size: 17px; margin-bottom: 25px;">Sorry there was an issue processing your payment for the subscription. Please try again.</p>

                <button class="btn btn-primary" data-dismiss="modal">Dismiss</button>
            </div>
        </div>
    </div>
</div>

<script>
    var failed = "{{ $Failed }}";
    if(failed == "Yes"){
        $('#errormodal').modal('show');
    }
</script>



<div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
    <div class="widget widget-content-area br-4">
        <div class="widget-one">
            <p style="font-size: 17px; margin-top: 5px;">All our plans come with {{ $TrialDays }} days trial period where you can fully test the platform before your subscription starts.</p>

            <div style="width: 100%; margin-top: 35px; display: flex;">
                <div style="width: 50%;">
                    <h4>Monthly Plans</h4>

                    @foreach($MonthlyPlans as $MonthlyPlan)
                        <div class="card component-card_1" style="width: 80%; margin-top: 20px; background-color: rgba(255,255,255,0.85);">
                            <div class="card-body">
                                <div style="width: 100%; height: 35px;">
                                    <h5 style="color: #030B51; float: left;">{{ $MonthlyPlan->name }}</h5>
                                    <h5 style="color: #030B51; float: right;">${{ number_format($MonthlyPlan->price, 2) }}</h5>
                                </div>

                                <p style="font-size: 16px; font-weight: 500; color: #030B51">Includes:</p>

                                <ul style="font-size: 16px; color: #030B51">
                                    <li>{{ number_format($MonthlyPlan->lead_credits) }} Lead Credits</li>
                                    <li>Sync {{ number_format($MonthlyPlan->email_accounts) }} Email Account</li>
                                </ul>

                                <button class="btn btn-primary sub_button" planid="{{ $MonthlyPlan->id }}" planstring="{{ $MonthlyPlan->name }} - ${{ number_format($MonthlyPlan->price, 2) }} ( {{ ucwords($MonthlyPlan->frequency) }} )" style="margin-top: 10px;">Select Plan</button>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div style="width: 50%;">
                    <h4>Yearly Plans</h4>

                    @foreach($AnnualPlans as $AnnualPlan)
                        <div class="card component-card_1" style="width: 80%; margin-top: 20px; background-color: rgba(255,255,255,0.85);">
                            <div class="card-body">
                                <div style="width: 100%; height: 35px;">
                                    <h5 style="color: #030B51; float: left;">{{ $AnnualPlan->name }}</h5>
                                    <h5 style="color: #030B51; float: right;">${{ number_format($AnnualPlan->price, 2) }}</h5>
                                </div>

                                <p style="font-size: 16px; font-weight: 500; color: #030B51">Includes:</p>

                                <ul style="font-size: 16px; color: #030B51">
                                    <li>{{ number_format($AnnualPlan->lead_credits) }} Lead Credits</li>
                                    <li>Sync {{ number_format($AnnualPlan->email_accounts) }} Email Account</li>
                                </ul>

                                <button class="btn btn-primary sub_button" planid="{{ $AnnualPlan->id }}" planstring="{{ $AnnualPlan->name }} - ${{ number_format($AnnualPlan->price, 2) }} ({{ ucwords($AnnualPlan->frequency) }})" style="margin-top: 10px;">Select Plan</button>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('.sub_button').click(function() {
        var planid = $(this).attr('planid');
        var planstring = $(this).attr('planstring');
        $('#form_plan_id').val(planid);
        $('#form_plan_string').text(planstring);

        $('#startsubmodal').modal('show');
    });


</script>

@endsection
