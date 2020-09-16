@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Cars</div>

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
                                    <a href="{{ route('cars.create') }}"
                                       class="btn btn-outline-secondary">Create</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered nowrap cars_listing">
                                    <thead>
                                    <tr>
                                        <th>Index</th>
                                        <th>Type</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Added By</th>
                                        <th class="noExport">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($cars) > 0)
                                        @foreach($cars as $index => $car)
                                            <tr>
                                                <td>{{ ++$index }}</td>
                                                <td>{{ !empty($car->type) ? $car->type : '-' }}</td>
                                                <td>{{ !empty($car->title) ? $car->title : '-' }}</td>
                                                <td>{{ isset($car->is_active) && $car->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                                                <td>{{ isset($car->user) && !empty($car->user) ? $car->user->name : 'N/A' }}</td>
                                                <td>
                                                    <a href="{{ route('cars.show', $car->id) }}"
                                                       class="mr-2">Show</a>
                                                    <a href="{{ route('cars.edit', $car->id) }}"
                                                       class="mr-2">Edit</a>
                                                    <a href="javascript:void(0);" class="delete_item">Delete</a>
                                                    <form class="delete_item_form"
                                                          action="{{ route('cars.destroy', $car->id) }}"
                                                          method="POST" style="display: none;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        {{ csrf_field() }}
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7">No record found.</td>
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
            $(document).off('click', '.delete_item');
            $(document).on('click', '.delete_item', function () {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this item!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((will_delete) => {
                        if (will_delete) {
                            swal("Poof! Your item has been deleted!", {
                                icon: "success",
                            });
                            setTimeout(function () {
                                $(document).find('.delete_item_form').submit();
                            }, 1000);
                        }
                    });
            });
        })
    </script>
@stop
