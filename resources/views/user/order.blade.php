@extends('user.layout.style')
@section('content')

    <body>
        <div class="container-fluid px-4 px-lg-5">
            <div class="row mt-5 d-flex justify-content-between align-items-center">
                <div class="col-5">
                    <img src="{{ asset('uploads/' . $pizza->image) }}" width="100%" class=" rounded-2 img-thumbnail">
                    <br>
                    <a href="{{ route('user#index') }}">
                        <button class="btn btn-dark text-white" style="margin-top: 20px;">
                            <i class="fas fa-backspace text-white"></i> Back
                        </button>
                    </a>
                </div>
                <div class="col-6">
                    @if (Session::has('massage'))
                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                            Order Success! Please wait {{ Session::get('massage') }} Minutes.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Name</h5>
                        <small class="d-block">{{ $pizza->pizza_name }}</small>
                        <br>
                    </div>
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Price</h5>
                        <small class="d-block">{{ $pizza->price - $pizza->discount_price }} Kyats</small>
                        <br>
                    </div>

                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Waiting Time</h5>
                        <small class="d-block">{{ $pizza->waiting_time }} Minutes</small>
                        <br>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <div>
                            <br>
                            <label for="">Count</label>
                            <input type="number" name="pizzaCount" class="form-control">
                            @if ($errors->has('pizzaCount'))
                                <small class="text-danger">{{ $errors->first('pizzaCount') }}</small>
                            @endif
                        </div>
                        <div>
                            <br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio1"
                                    value="1">
                                <label class="form-check-label" for="inlineRadio1">Credit Card</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="paymentType" id="inlineRadio2"
                                    value="2">
                                <label class="form-check-label" for="inlineRadio2">Cash</label>
                            </div>
                            <br>
                            @if ($errors->has('paymentType'))
                                <small class="text-danger">{{ $errors->first('paymentType') }}</small>
                            @endif
                        </div>
                        <br>
                        <button class="btn btn-warning float-end mt-2 col-12" type="submit"><i
                                class="fas fa-shopping-cart"></i>
                            Place Order</button>
                    </form>



                </div>
            </div>
        @endsection
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js "></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js "></script>
</body>

</html>
