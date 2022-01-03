@extends('layouts.head')
@section('title', 'Home')
@section('body')
    @extends('layouts.header')
    <div class="container">
        @if ($message = Session::has('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong> {{ Session::get('success') }} </strong>
            </div>
        @endif
        <div class="card border-0 p-3">
            <div class="row">
                <div class="col-md-7">
                    <h5>Data</h5>
                </div>
                <div class="col-md-5 text-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#importModal">
                        Import CSV
                    </button>
                    <a href="/export" class="btn btn-success">
                        Export Excel
                    </a>
                </div>
            </div>
            <div class="card-body p-0 py-3">

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>First</th>
                                <th>Last</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import CSV File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/import" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <input type="file" class="form-control" name="csv_file" id="import_file">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
