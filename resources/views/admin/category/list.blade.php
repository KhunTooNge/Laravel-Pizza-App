@extends('admin.layout.add')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- massge show case --}}
                @if (Session::has('massage'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {{ Session::get('massage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- massage show case end --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin#addCategory') }}">
                                        <button class="btn btn-sm btn-outline-dark">Add Category</button>
                                    </a>
                                </h3>
                                <button type="button" class="btn btn-warning btn-sm position-relative ms-3">
                                    Total
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $category->total() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>

                                <div class="card-tools d-flex">
                                    <div class="me-3 mt-1">
                                        <a href="{{ route('admin#categoryDownloadCSV') }}">
                                            <button type="button" class="btn btn-sm btn-success">Download CSV</button>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin#searchCategory') }}" method="GET">
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
                                            <th>Category Name</th>
                                            <th>Product Count</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($category as $item)
                                            <tr>
                                                <td>{{ $item->category_id }}</td>
                                                <td>{{ $item->category_name }}</td>
                                                <td>
                                                    @if ($item->count == 0)
                                                        <a href="#"
                                                            class=" text-decoration-none">{{ $item->count }}</a>
                                                    @else
                                                        <a href="{{ route('admin#categoryItem', $item->category_id) }}"
                                                            class=" text-decoration-none">{{ $item->count }}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-inline-block">
                                                        <a href="{{ route('admin#editCategory', $item->category_id) }}">
                                                            <button class="btn btn-sm bg-dark text-white">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </a>
                                                    </div>

                                                    <a href="{{ route('admin#deleteCategory', $item->category_id) }}">
                                                        <button class="btn btn-sm bg-danger text-white">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="mt-3">{{ $category->links() }}</div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
