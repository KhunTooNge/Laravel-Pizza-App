@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-9 offset-3 mt-1">
                        <div class="col-md-9">
                            <a href="{{ route('admin#pizza') }}" class=" text-decoration-none text-dark">
                                <div class="mb-3"><i class="fas fa-arrow-left pe-1"></i>back</div>
                            </a>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Edit Pizza</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">

                                            {{-- form start --}}
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#updatePizza', $pizza->pizza_id) }} "
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="text-center mb-3">
                                                    <img src="{{ asset('uploads/' . $pizza->image) }} " width="150px"
                                                        class="img-thumbnail">
                                                </div>
                                                {{-- <input type="hidden" name="id" value={{ $pizza->pizza_id }}> --}}
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder="Name"
                                                            name="name" value="{{ old('name', $pizza->pizza_name) }}">
                                                        @if ($errors->has('name'))
                                                            <small class=text-danger>{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Image</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="image"
                                                            value="{{ old('image', $pizza->image) }}">
                                                        @if ($errors->has('image'))
                                                            <small class=text-danger>{{ $errors->first('image') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div
                                                    class="form-group
                                                            row">
                                                    <label class="col-sm-3 col-form-label">Price</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="price"
                                                            value="{{ old('price', $pizza->price) }}">
                                                        @if ($errors->has('price'))
                                                            <small class=text-danger>{{ $errors->first('price') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Public Status</label>
                                                    <div class="col-sm-9">
                                                        <select name="publicStatus" class="form-control">
                                                            @if ($pizza->public_status == 1)
                                                                <option value="">Choose Status</option>
                                                                <option value="1" selected>Publish</option>
                                                                <option value="0">Unpublish</option>
                                                            @endif
                                                            @if ($pizza->public_status == 0)
                                                                <option value="">Choose Status</option>
                                                                <option value="1">Publish</option>
                                                                <option value="0" selected>Unpublish</option>
                                                            @endif

                                                        </select>
                                                        @if ($errors->has('publicStatus'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('publicStatus') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Category</label>
                                                    <div class="col-sm-9">
                                                        <select name="category" class="form-control">
                                                            <option value="{{ $pizza->category_id }}">
                                                                {{ $pizza->category_name }}
                                                            </option>

                                                            @foreach ($category as $item)
                                                                @if ($item->category_id != $pizza->category_id)
                                                                    <option value="{{ $item->category_id }}">
                                                                        {{ $item->category_name }}
                                                                    </option>
                                                                @endif
                                                            @endforeach

                                                        </select>

                                                        @if ($errors->has('category'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('category') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Discount</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="discount"
                                                            value="{{ old('discount', $pizza->discount_price) }}">
                                                        @if ($errors->has('discount'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('discount') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">By 1 get 1 </label>
                                                    <div class="col-sm-9 mt-2">
                                                        @if ($pizza->buy_one_get_one_status == 1)
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" value="1" checked>Yes
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" value="0">No
                                                        @endif
                                                        @if ($pizza->buy_one_get_one_status == 0)
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" value="1">Yes
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" value="0" checked>No
                                                        @endif

                                                        @if ($errors->has('buyOneGetOne'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('buyOneGetOne') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Waiting Time</label>
                                                    <div class="col-sm-9">
                                                        <input type="number" class="form-control" name="waitingTime"
                                                            value="{{ old('waitingTime', $pizza->waiting_time) }}">
                                                        @if ($errors->has('waitingTime'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('waitingTime') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Description</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="description" class="form-control" cols="30" rows="2">{{ old('description', $pizza->description) }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('description') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <div class="mt-1 float-end">
                                                            <button type="submit"
                                                                class="btn bg-dark text-white">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- form - end --}}
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
