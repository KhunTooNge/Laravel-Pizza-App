@extends('admin.layout.add')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-warning btn-sm position-relative ms-3">
                                    Total
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $orders->total() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                                <div class="card-tools d-flex">
                                    <div class="me-3 mt-1">
                                        <a href="{{ route('admin#orderDownload') }}">
                                            <button type="button" class="btn btn-sm btn-success">Download CSV</button>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin#searchOrder') }}" method="GET">
                                        @csrf
                                        <div class="input-group input-group-sm my-1" style="width: 150px;">
                                            <input type="text" name="search" class="form-control float-right"
                                                placeholder="Search">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Pizza Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Order Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $item)
                                                <tr>
                                                    <td>{{ $item->order_id }}</td>
                                                    <td>{{ $item->customer_name }}</td>
                                                    <td>{{ $item->pizza_name }}</td>
                                                    <td>{{ $item->quantity }}</td>
                                                    <td>{{ $item->order_time }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="mt-3">{{ $orders->links() }}</div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
