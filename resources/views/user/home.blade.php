@extends('user.layout.style')
@section('content')
    <!-- Page Content-->
    <div class="container px-4 px-lg-5" id="home">
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center my-5">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" id="code-lab-pizza"
                    src="https://www.pizzamarumyanmar.com/wp-content/uploads/2019/04/chigago.jpg" alt="..." />
            </div>
            <div class="col-lg-5">
                <h1 class="font-weight-light" id="about">CODE LAB Pizza</h1>
                <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it,
                    but it makes a great use of the standard Bootstrap core components. Feel free to use this template
                    for any project you want!</p>
                <a class="btn btn-primary" href="#!">Enjoy!</a>
            </div>
        </div>

        <!-- Content Row-->
        <div class="d-flex justify-content-between">
            <div class="col-3 me-2">
                <div class="">
                    <div class="py-1 text-center">
                        <form class="d-flex mt-5 mb-3" action="{{ route('user#pizzaSearch') }}" method="get">
                            @csrf
                            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                                name="serach">
                            <button type="submit" class="btn btn-default">
                                <i class="fa-solid fa-magnifying-glass bg-white text-black"></i>
                            </button>
                        </form>

                        <div class="">
                            <a href="{{ route('user#index') }}" class=" text-decoration-none text-black">
                                <div class="m-1 p-2 bg-dark text-white">All</div>
                            </a>
                            @foreach ($category as $item)
                                <a href="{{ route('user#categorySearch', $item->category_id) }}"
                                    class=" text-decoration-none text-black">
                                    <div class="m-1 p-2 bg-dark text-white " id="category">{{ $item->category_name }}
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <hr>
                        <form action="{{ route('user#pizzaSearchWithPrice') }}" method="GET">
                            @csrf
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Start Date - End Date</h3>

                                <input type="date" name="startDate" id="" class="form-control"> -
                                <input type="date" name="endDate" id="" class="form-control">
                            </div>
                            <hr>
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Min - Max Amount</h3>

                                <input type="number" name="minprice" id="" class="form-control"
                                    placeholder="minimum price"> -
                                <input type="number" name="maxprice" id="" class="form-control"
                                    placeholder="maximun price">
                                <button class="btn btn-dark mt-3 col-12" type="submit">Search..<i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                @if ($status == 1)
                    <div class="row gx-4 gx-lg-5" id="pizza">
                        @foreach ($pizza as $item)
                            <div class="col-lg-4 col-md-6 mb-5">
                                <div class="d-flex" style="width: 250px">
                                    <div class="card h-100 ms-3">
                                        <!-- Sale badge-->
                                        @if ($item->buy_one_get_one_status == 1)
                                            <div class="badge bg-danger text-white position-absolute"
                                                style="top: 0.5rem; right: 0.5rem; z-index: 3">
                                                Buy 1 Get 1</div>
                                        @endif
                                        <!-- Product image-->
                                        <img class="card-img-top" id="pizza_image"
                                            src="{{ asset('uploads/' . $item->image) }}" alt="..." height="160px" />
                                        <!-- Product details-->
                                        <div class="card-body p-4">
                                            <div class="text-center">
                                                <!-- Product name-->
                                                <h5 class="fw-bolder">{{ $item->pizza_name }}</h5>
                                                <!-- Product price-->
                                                <span class="text-muted text-decoration-line-through">$20.00</span>
                                                {{ $item->price }} <small>kyats</small>
                                            </div>
                                        </div>
                                        <!-- Product actions-->
                                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                            <div class="text-center"><a class="btn btn-outline-dark mt-auto"
                                                    href="{{ route('user#pizzaDetailShowUser', $item->pizza_id) }}">
                                                    More Detail</a></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="mb-5 text-center" style="width:600px">

                            <h3 class="mb-4 text-info"> Not Avaliable Right Now. <span class="text-danger">:(</span> Sorry!
                            </h3>

                            <div>
                                <img src="	https://w7.pngwing.com/pngs/490/601/png-transparent-cupcake-cooking-chef-cartoon-breakfast-child-food-breakfast.png"
                                    alt="" style="width:450px; height:400px;" class="rounded-circle">
                            </div>

                        </div>

                        <div>{{ $pizza->links() }}</div>
                    </div>
                @endif
            </div>

        </div>

    </div>

    <div class="text-center d-flex justify-content-center align-items-center" id="contact">
        <div class="col-6 border shadow-sm ps-5 pt-5 pe-5 pb-2 mb-5">
            <h3>Contact Us</h3>
            {{-- massge show case --}}
            @if (Session::has('massage'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ Session::get('massage') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            {{-- massage show case end --}}
            <form action="{{ route('user#contactCreate') }}" method="POST" class="my-4">
                @csrf
                <input type="text" name="name" value="{{ old('name') }}" class="form-control my-3"
                    placeholder="Name">
                @if ($errors->has('name'))
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                @endif
                <input type="email" name="email" value="{{ old('email') }}" class="form-control my-3"
                    placeholder="Email">
                @if ($errors->has('email'))
                    <small class="text-danger">{{ $errors->first('email') }}</small>
                @endif
                <textarea class="form-control my-3" name="message" rows="3" placeholder="Message">{{ old('message') }}</textarea>
                @if ($errors->has('message'))
                    <small class="text-danger">{{ $errors->first('message') }}</small>
                @endif
                <button type="submit" class="btn btn-outline-dark">Send <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>
@endsection
