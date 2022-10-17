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
                                    <legend class="text-center">Add Pizza</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            {{-- form start --}}
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#createPizza') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Pizza Name" name="name"
                                                            value="{{ old('name') }}">
                                                        @if ($errors->has('name'))
                                                            <small class=text-danger>{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Image</label>
                                                    <div class="col-sm-9">
                                                        <input type="file" class="form-control" name="image"
                                                            placeholder="Enter Pizza Image" value="{{ old('image') }}">
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
                                                            placeholder="Price of Pizza" value="{{ old('price') }}">
                                                        @if ($errors->has('price'))
                                                            <small class=text-danger>{{ $errors->first('price') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Public Status</label>
                                                    <div class="col-sm-9">
                                                        <select name="publicStatus" class="form-control">
                                                            <option value="">Choose Status</option>
                                                            <option value="1">Publish</option>
                                                            <option value="0">Unpublish</option>
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
                                                            <option value="">Choose Category</option>

                                                            @foreach ($category as $item)
                                                                <option value="{{ $item->category_id }}">
                                                                    {{ $item->category_name }}
                                                                </option>
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
                                                            placeholder="discount ?" value="{{ old('discount') }}">
                                                        @if ($errors->has('discount'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('discount') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">By 1 get 1 </label>
                                                    <div class="col-sm-9 mt-2">
                                                        <input type="radio" name="buyOneGetOne" class="form-input-check"
                                                            value="1">Yes
                                                        <input type="radio" name="buyOneGetOne" class="form-input-check"
                                                            value="0">No
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
                                                            placeholder="Enter Waiting Time"
                                                            value="{{ old('waitingTime') }}">
                                                        @if ($errors->has('waitingTime'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('waitingTime') }}</small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Description</label>
                                                    <div class="col-sm-9">
                                                        <textarea name="description" class="form-control" cols="30" rows="2">{{ old('description') }}Enter Description</textarea>
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
                                                                class="btn bg-dark text-white">Add</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

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
