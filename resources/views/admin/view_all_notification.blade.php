@extends('admin.layouts.app')
@section('panel')
<div class="row">
    <div class="col-md-6 card-header border-0 px-4 py-3 bg-transparent">
        <h5 class="mb-3">{{$pageTitle}}</h5>
    </div>
</div>
<div class="row">
    <div class="col-xl-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive white-space-nowrap">
                    <table id="event_notification" class="table text-center" >
                        @csrf
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
<style>
#event_notification thead tr {
            display: none;
    }
</style>
@endpush