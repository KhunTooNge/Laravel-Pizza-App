@extends('admin.layout.add')
@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('massage'))
                    <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                        {{ Session::get('massage') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <a href="{{ route('admin#addCarrier') }}">
                                    <button class="btn btn-info btn-sm mt-1">Add Carrier</button>
                                </a>

                                <div class="card-tools d-flex">
                                    <div class="me-3 mt-1">
                                        <a href="{{ route('admin#carrierDownload') }}">
                                            <button type="button" class="btn btn-sm btn-success">Download CSV</button>
                                        </a>
                                    </div>
                                    <form action="{{ route('admin#searchCarrier') }}" method="GET" class="mt-2">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 150px;">
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
                                <table class="table table-hover text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>Carrier ID</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Gender</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carriers as $carrier)
                                            <tr>
                                                <td>{{ $carrier->carrier_id }}</td>
                                                <td>{{ $carrier->name }}</td>
                                                <td>{{ $carrier->phone }}</td>
                                                <td>
                                                    @if ($carrier->gender == 1)
                                                        Male
                                                    @elseif ($carrier->gender == 0)
                                                        Female
                                                    @else
                                                        Other
                                                    @endif
                                                </td>
                                                <td>{{ $carrier->address }}</td>
                                                <td>
                                                    <a href="{{ route('admin#deleteCarrier', $carrier->carrier_id) }}">
                                                        <button class="btn btn-sm bg-danger text-white"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </a>
                                                    <a href="{{ route('admin#editCarrier', $carrier->carrier_id) }}">
                                                        <button class="btn btn-sm bg-dark text-white"><i
                                                                class="fas fa-edit"></i></button>
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
                            <div class="mt-3">{{ $carriers->links() }}</div>
                        </div>
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
