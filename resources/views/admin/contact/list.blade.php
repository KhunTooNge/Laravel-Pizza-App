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
                                        {{ $contact->total() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>

                                <div class="card-tools d-flex">
                                    <div class="me-3 mt-1">
                                        <a href="{{ route('admin#contactDownload') }}">
                                            <button type="button" class="btn btn-sm btn-success">Download CSV</button>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin#searchContact') }}" method="GET">
                                        @csrf
                                        <div class="input-group input-group-sm mt-1" style="width: 150px;">
                                            <input type="text" name="searchData" class="form-control float-right"
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

                                <table class="table table-hover text-nowrap text-center">

                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($status == 0)
                                            <td colspan="4">There is no data!</td>
                                        @else
                                            @foreach ($contact as $item)
                                                <tr>
                                                    <td>{{ $item->contact_id }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->email }}</td>
                                                    <td>{{ $item->message }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="mt-3">{{ $contact->links() }}</div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
