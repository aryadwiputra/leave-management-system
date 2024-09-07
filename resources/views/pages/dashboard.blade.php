@extends('layouts.dashboard')

@section('content')
    <div class="row py-4">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $izin_pending }}</h3>
                    <p>Izin Menunggu Disetujui</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('dashboard.leaves.index', ['type' => 'izin', 'status' => 'pending']) }}"
                    class="small-box-footer">Lihat data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $sakit_pending }}</h3>
                    <p>Sakit Menunggu Disetujui</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('dashboard.leaves.index', ['type' => 'sakit', 'status' => 'pending']) }}"
                    class="small-box-footer">Lihat data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $cuti_pending }}</h3>
                    <p>Cuti Menunggu Disetujui</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('dashboard.leaves.index', ['type' => 'cuti', 'status' => 'pending']) }}"
                    class="small-box-footer">Lihat data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $lembur_pending }}</h3>
                    <p>Lembur Menunggu Disetujui</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('dashboard.leaves.index', ['type' => 'lembur', 'status' => 'pending']) }}"
                    class="small-box-footer">Lihat data <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
