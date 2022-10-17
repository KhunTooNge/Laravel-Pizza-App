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
                                    <a href="{{ route('admin#addPizza') }}">
                                        <button class="btn bg-dark btn-sm text-white">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                    </a>
                                </h3>
                                <button type="button" class="btn btn-warning btn-sm position-relative ms-3">
                                    Total
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $pizza->total() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>

                                <div class="card-tools d-flex">
                                    <a href="{{ route('admin#pizzaDwonload') }}">
                                        <button type="button" class="btn btn-sm btn-success mt-1 me-2">Download
                                            CSV</button>
                                    </a>
                                    <form action="{{ route('admin#searchPizza') }}" method="GET">
                                        @csrf
                                        <div class="input-group input-group-sm mt-1" style="width: 150px;">
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
                                <table class="table table-hover text-nowrap text-center align-">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Pizza Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Publish Status</th>
                                            <th>Buy 1 Get 1 Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($status == 0)
                                            <tr class="text-white bg-black">
                                                <td colspan="7">
                                                    There is no data.
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($pizza as $items)
                                                <tr>
                                                    <td class="align-middle">{{ $items->pizza_id }}</td>
                                                    <td class="align-middle">{{ $items->pizza_name }}</td>
                                                    <td class="align-middle">
                                                        <img src="{{ asset('uploads/' . $items->image) }}"
                                                            class="img-thumbnail" width="100px">
                                                    </td>
                                                    <td class="align-middle">{{ $items->price }} kyats</td>
                                                    <td class="align-middle">
                                                        @if ($items->public_status == 1)
                                                            Publish
                                                        @elseif ($items->public_status == 0)
                                                            Unpublish
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        @if ($items->buy_one_get_one_status == 1)
                                                            Yes
                                                        @elseif ($items->buy_one_get_one_status == 0)
                                                            No
                                                        @endif
                                                    </td>
                                                    <td class="align-middle">
                                                        <div class="d-inline-block">
                                                            <a href="{{ route('admin#editPizza', $items->pizza_id) }}">
                                                                <button class="btn btn-sm bg-dark text-white">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <a href="{{ route('admin#deletePizza', $items->pizza_id) }}">
                                                                <button class="btn btn-sm bg-danger text-white">
                                                                    <i class="fas fa-trash-alt"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                        <div class="d-inline-block">
                                                            <a href="{{ route('admin#detailPizza', $items->pizza_id) }}">
                                                                <button class="btn btn-sm bg-info text-white">
                                                                    <i class="fa-solid fa-eye text-dark"></i>
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="mt-3">{{ $pizza->links() }}</div>
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
