@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-10 offset-2 mt-1">
                        <div class="col-md-9">
                            <a href="{{ route('admin#pizza') }}" class=" text-decoration-none text-dark">
                                <div class="mb-3"><i class="fas fa-arrow-left pe-1"></i>back</div>
                            </a>
                            <div class="card">
                                <div class="card-header bg-info p-2">
                                    <legend class="text-center">Pizza Infomation</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane d-flex justify-content-evently align-items-center"
                                            id="activity">
                                            <div>
                                                <img src="{{ asset('uploads/' . $pizza->image) }}"
                                                    class=" img-thumbnail rounded-circle" width="250px" height="250px">
                                                <div class="ms-5 px-3 my-2">
                                                    <b>Price :</b>
                                                    <span>{{ $pizza->price }} <span class="">Kyats</span></span>
                                                </div>
                                            </div>
                                            <div class="mx-5">

                                            </div>
                                            <div>
                                                <p>
                                                    <b>Name : </b>
                                                    <span>{{ $pizza->pizza_name }}</span>
                                                </p>
                                                <p>
                                                    <b>Public Status :</b>
                                                    <span>
                                                        @if ($pizza->public_status == 1)
                                                            YES
                                                        @else
                                                            NO
                                                        @endif
                                                    </span>
                                                </p>
                                                <p>
                                                    <b>Category :</b>
                                                    <span>{{ $pizza->category_id }}</span>
                                                </p>
                                                <p class="bg-info rounded p-2">
                                                    <b>Discount :</b>
                                                    <span>{{ $pizza->discount_price . '%' }}</span>
                                                </p>
                                                <p>
                                                    <b>Buy One Get One :</b>
                                                    <span>
                                                        @if ($pizza->buy_one_get_one_status == 1)
                                                            YES
                                                        @else
                                                            NO
                                                        @endif
                                                    </span>
                                                </p>
                                                <p>
                                                    <b>Waiting Time :</b>
                                                    <span>{{ $pizza->waiting_time }} min</span>
                                                </p>
                                                <p>
                                                    <b>Description :</b>
                                                    <span>{{ $pizza->description }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection
