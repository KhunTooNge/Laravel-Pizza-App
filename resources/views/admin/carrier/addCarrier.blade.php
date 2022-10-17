@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <a href="{{ route('admin#carrierList') }}" class=" text-decoration-none text-dark">
                                <div class="mb-3"><i class="fas fa-arrow-left pe-1"></i>back</div>
                            </a>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Add Carrier</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            {{-- form start --}}
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#createCarrier') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Name</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Carrier Name...." name="name"
                                                            value="{{ old('name') }}">
                                                        @if ($errors->has('name'))
                                                            <small class=text-danger>{{ $errors->first('name') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Phone</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder=""
                                                            name='phone'>
                                                        @if ($errors->has('phone'))
                                                            <small class=text-danger>{{ $errors->first('phone') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Gender</label>
                                                    <div class="col-sm-9 mt-3">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                value="1">
                                                            <label class="form-check-label">Male</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                value="0">
                                                            <label class="form-check-label">Female</label>
                                                        </div>
                                                        @if ($errors->has('gender'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('gender') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-3 col-form-label">Address</label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder=""
                                                            name="address">
                                                        @if ($errors->has('address'))
                                                            <small
                                                                class=text-danger>{{ $errors->first('address') }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit"
                                                            class="btn bg-dark text-white float-right">Add</button>
                                                    </div>
                                                </div>
                                            </form>
                                            {{-- form end --}}
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
