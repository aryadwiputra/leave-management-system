@extends('layouts.dashboard')
@push('style')
    @include('style.datatable')
@endpush
@section('content')
    <div class="content-header">
        <h4>Data Departemen</h4>
    </div>

    <div class="card">
        <div class="card-body">
            <a href="{{ route('dashboard.departments.create') }}" class="btn btn-primary mb-2">Tambah Departemen</a>
            <table class="table table-bordered" id="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $department->name }}</td>
                            <td>
                                <a href="{{ route('dashboard.departments.edit', $department->id) }}"
                                    class="btn btn-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
@endsection

@push('script')
    @include('scripts.datatable')
    <script>
        $(function() {
            $("#data-table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": true,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
            }).buttons().container().appendTo('#data-table_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
