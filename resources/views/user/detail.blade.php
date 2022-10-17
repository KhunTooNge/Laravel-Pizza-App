@extends('user.layout.style')
@section('content')

    <body>
        <div class="container-fluid px-4 px-lg-5">
            <div class="row mt-5 d-flex justify-content-between align-items-center">
                <div class="col-6">
                    <img src="{{ asset('uploads/' . $pizza->image) }}" width="100%" class=" rounded-2 img-thumbnail">
                    <br>

                    <a href="{{ route('user#order') }}">
                        <button class="btn btn-primary float-end mt-2 col-12"><i class="fas fa-shopping-cart"></i>
                            Order</button>
                    </a>

                    <a href="{{ route('user#index') }}">
                        <button class="btn btn-dark text-white" style="margin-top: 20px;">
                            <i class="fas fa-backspace text-white"></i> Back
                        </button>
                    </a>
                </div>
                <div class="col-6">
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Name</h5>
                        <small class="d-block">{{ $pizza->pizza_name }}</small>
                        <br>
                    </div>
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Price</h5>
                        <small class="d-block">{{ $pizza->price }} Kyats</small>
                        <br>
                    </div>
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Price</h5>
                        <small class="d-block">{{ $pizza->price }} Kyats</small>
                        <br>
                    </div>
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5> Discount Price</h5>
                        <small class="d-block">{{ $pizza->discount_price }} Kyats</small>
                        <br>
                    </div>

                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>By One Get One </h5>
                        @if ($pizza->buy_one_get_one_status == 0)
                            Not Have
                        @else
                            Have
                        @endif
                        <br><br>
                    </div>
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Waiting Time</h5>
                        <small class="d-block">{{ $pizza->waiting_time }} Minutes</small>
                        <br>
                    </div>
                    <div style="border-bottom: 1px solid rgba(128, 128, 128, 0.466)" class="shadow-sm px-3">
                        <h5>Description</h5>
                        <small class="d-block">{{ $pizza->description }}</small>
                        <br>
                    </div>
                    <div class="px-3">
                        <br>
                        <p class="text-danger">Total Price</p>
                        <h4 class="text-success">{{ $pizza->price - $pizza->discount_price }}Kyats</h4>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js "></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js "></script>
</body>

</html>
