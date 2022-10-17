@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-9 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2 bg-dark text-white">
                                    <legend class="text-center ">User Admin Edit</legend>
                                </div>
                                <div class="card-body">
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
                                                action="{{ route('admin#updateAdmin', $user->id) }}">
                                                @csrf
                                                {{-- <input type="hidden" name="id"> --}}
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputName"
                                                            placeholder="Name" name="name"
                                                            value="{{ old('name', $user->name) }}">
                                                        @if ($errors->has('name'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('name') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" id="inputEmail"
                                                            placeholder="Email" name="email"
                                                            value={{ old('email', $user->email) }}>
                                                        @if ($errors->has('email'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('email') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputPhone"
                                                            placeholder="phone number" name="phone"
                                                            value={{ old('phone', $user->phone) }}>
                                                        @if ($errors->has('phone'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('phone') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="inputAddress"
                                                        class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputAddress"
                                                            placeholder="Address" name="address"
                                                            value={{ old('address', $user->address) }}>
                                                        @if ($errors->has('address'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('address') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Role</label>
                                                    <div class="col-sm-10">
                                                        <select name="role" class="form-control">s
                                                            @if ($user->role == 'user')
                                                                <option value="">Choose One</option>
                                                                <option value="user" selected>user</option>
                                                                <option value="admin">admin</option>
                                                            @endif
                                                            @if ($user->role == 'admin')
                                                                <option value="">Choose One</option>
                                                                <option value="user">user</option>
                                                                <option value="admin" selected>admin</option>
                                                            @endif

                                                        </select>
                                                        @if ($errors->has('role'))
                                                            <small class="text-danger">
                                                                {{ $errors->first('role') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit"
                                                            class="btn bg-dark text-white">Update</button>
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
