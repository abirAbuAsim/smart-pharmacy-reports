@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pharmacy Sales</h5>
                        <ul class="list-group list-group-flush">
                            {{--
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            --}}
                            <li class="list-group-item"><a href="{{ URL::to('sales')}}" class="btn btn-primary">Go to Sales Page</a></li>
                        </ul>

                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Purchases By Pharmacies</h5>
                        <ul class="list-group list-group-flush">
                            {{--
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            --}}
                            <li class="list-group-item"><a href="#" class="btn btn-primary">Go to Purchase Page</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection