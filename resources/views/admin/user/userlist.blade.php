@extends('admin.layout.add')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- massge show case --}}
                @if (Session::has('massage'))
                    <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert">
                        {{ Session::get('massage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- massage show case end --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title pt-2">
                                    <div class="d-inline-block">
                                        <a href="{{ route('admin#userList') }}">
                                            <button class="btn btn-sm btn-outline-dark">User List</button>
                                        </a>
                                    </div>

                                    <a href="{{ route('admin#adminList') }}">
                                        <button class="btn btn-sm btn-outline-dark">Admin List</button>
                                    </a>
                                </h3>
                                <button type="button" class="btn btn-warning btn-sm position-relative ms-3 mt-2">
                                    User Total
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $users->total() }}
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </button>
                                <div class="card-tools d-flex">
                                    <a href="{{ route('admin#usersDownload') }}">
                                        <button type="button" class="btn btn-sm btn-success mt-2 me-2">Download
                                            CSV</button>
                                    </a>
                                    <form action="{{ route('admin#userSearch') }}" method="GET">
                                        @csrf
                                        <div class="input-group input-group-sm mt-2" style="width: 150px; ">
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
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($users as $user)
                                            @if ($user->role != 'admin')
                                                <tr>
                                                    <td>{{ $user->id }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                    <td>{{ $user->address }}</td>
                                                    <td>
                                                        <a href="{{ route('admin#deleteUser', $user->id) }}">
                                                            <button class="btn btn-sm bg-danger text-white">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="mt-3">{{ $users->links() }}</div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
