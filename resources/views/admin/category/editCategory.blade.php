@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <a href="{{ route('admin#category') }}" class=" text-decoration-none text-dark">
                                <div class="mb-3"><i class="fas fa-arrow-left pe-1"></i>back</div>
                            </a>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Edit Category</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            {{-- form-start --}}
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#updateCategory') }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="hidden" name="id"
                                                            value="{{ $category->category_id }}">
                                                        <input type="text" class="form-control" placeholder="Name"
                                                            name="name"
                                                            value="{{ old('name', $category->category_name) }}">
                                                        @if ($errors->has('name'))
                                                            <small class=text-danger>{{ $errors->first('name') }}</small>
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
                                            {{-- form-end --}}
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
