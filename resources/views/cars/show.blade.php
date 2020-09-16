@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Car Detail</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @if(\Illuminate\Support\Facades\Session::has('notification'))
                                    <div
                                        class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                                        <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group float-right">
                                    <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary mr-2">Back</a>
                                    <a href="{{ route('cars.edit', $car->id) }}"
                                       class="btn btn-outline-secondary">Edit</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <p>
                                    <strong>Title: </strong><br>
                                    {{ !empty($car) ? $car->title : '-' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    <strong>Status: </strong><br>
                                    {{ (isset($car->is_active) && $car->is_active == 1) ? 'Active' : 'Inactive' }}
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p>
                                    <strong>Added By: </strong><br>
                                    {{ isset($car->user) && !empty($car->user) ? $car->user->name : 'N/A' }}
                                </p>
                            </div>
                            <div class="col-md-12">
                                <p>
                                    <strong>Description: </strong><br>
                                    {{ !empty($car) ? $car->description : '-' }}
                                </p>
                            </div>
                        </div>

                        <p class="mt-4 mb-3"><strong>Attachments</strong></p>
                        <div class="row">
                            <div class="col-md-12">
                                <table
                                    class="table table-striped table-bordered nowrap car_car_listing">
                                    <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($car->attachments) > 0)
                                        @foreach($car->attachments as $index => $attachment)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>
                                                    @if(!empty($attachment->name))
                                                        <a href="{{ asset('uploads/cars/' . $attachment->name) }}" target="_blank"
                                                           class="text-underline blue">
                                                            <span>{{ $attachment->name }}</span>
                                                        </a>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="2">No record found.</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            //
        })
    </script>
@stop
