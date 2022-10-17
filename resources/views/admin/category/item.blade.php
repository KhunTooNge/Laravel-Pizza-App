@extends('admin.layout.add')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-4">
                    <div class="col-8 offset-2 ">
                        <h4 class="my-3"> {{ $pizza[0]->category_name }}</h4>
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-warning btn-sm position-relative ms-3">
                                    Total
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $pizza->total() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">

                                <table class="table table-hover text-nowrap text-center">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pizza as $item)
                                            <tr>
                                                <td>{{ $item->pizza_id }}</td>
                                                <td>
                                                    <img src="{{ asset('/uploads/' . $item->image) }}" width="100px">
                                                </td>
                                                <td>{{ $item->pizza_name }}</td>
                                                <td>{{ $item->price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                <button class="btn bg-dark text-white">
                                    <a href="{{ route('admin#category') }}">Back</a>
                                </button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="d-flex justify-content-center align-items-center">
                            {{-- <div class="mt-3">{{ $category->links() }}</div> --}}
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
