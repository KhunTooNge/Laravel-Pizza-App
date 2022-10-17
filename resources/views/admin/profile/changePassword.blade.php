@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-10 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Change Password</legend>
                                </div>
                                <div class="card-body">
                                    @if (Session::has('errMassage'))
                                        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                            {{ Session::get('errMassage') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    @if (Session::has('massage'))
                                        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                            {{ Session::get('massage') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            {{-- FORM START --}}
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#changePassword', Auth()->user()->id) }}">
                                                @csrf
                                                {{-- <input type="hidden" name="id"> --}}
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Old Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" placeholder=""
                                                            name="oldPassword">
                                                        @if ($errors->has('oldPassword'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('oldPassword') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">New
                                                        Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" placeholder=""
                                                            name="newPassword">
                                                        @if ($errors->has('newPassword'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('newPassword') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Confirm
                                                        Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" placeholder=""
                                                            name="confirmPassword">
                                                        @if ($errors->has('confirmPassword'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('confirmPassword') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10 ">
                                                        <button type="submit"
                                                            class="btn bg-dark text-white float-right">Change</button>
                                                        <a href="{{ route('admin#profile') }}">
                                                            <button type="button"
                                                                class="btn btn-warning float-right me-3">back</button></a>
                                                    </div>


                                                </div>
                                            </form>
                                            {{-- FORM End --}}
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
