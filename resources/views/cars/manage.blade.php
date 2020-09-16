@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Car {{ isset($car) ? ' Edit' : ' Create' }}</div>

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
                                    <a href="{{ route('cars.index') }}" class="btn btn-outline-secondary">Back</a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <?php
                                $redirect_route = !empty($car)
                                    ? route('cars.update', $car->id)
                                    : route('cars.store');
                                ?>
                                <form action="{{ $redirect_route }}" method="post"
                                      enctype="multipart/form-data" class="car_form" id="car_form">
                                    {{ csrf_field() }}
                                    @if(isset($car) && !empty($car))
                                        <input type="hidden" name="_method" value="put">
                                        <input type="hidden" name="id" class="car_id"
                                               value="{{ isset($car) && !empty($car) ? $car->id : 0 }}">
                                    @endif
                                    @include('cars.form')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <template class="general_attachments_html">
                <div class="attachments_html">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name" class="form-label">Picture</label>
                                <input type="file" class="form-control" value=""
                                       name="attachments[0][name]">
                                <input type="hidden" class="form-control" value=""
                                       name="attachments[0][old_name]">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="button" class="btn btn-outline-secondary remove_from_more" style="margin-top: 30px !important;"
                                        data-parent-element="attachments_html">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).off('click', '.remove_from_more');
            $(document).on('click', '.remove_from_more', function () {
                let $this = $(this);
                let $parent_attr = $this.attr('data-parent-element');
                $(this).parents('.' + $parent_attr).remove();
                updateIndex('attachments');
            });

            $(document).off('click', '.add_attachments');
            $(document).on('click', '.add_attachments', function (e) {
                let attachments_html = document.querySelector('.general_attachments_html');
                let clone_node = attachments_html.content.cloneNode(true);
                let clone_html = document.importNode(clone_node, true);
                $(document).find('.attachments_section').append(clone_html);
                updateIndex('attachments');
            });
        });

        function updateIndex($module_name) {
            $('.' + $module_name + '_html').each(function (key, value) {
                let common_value = $module_name + '[' + (key) + ']';
                $(value).addClass('attachments_html_' + key);
                $(value).find('[name*="[name]"]').attr('name', common_value + '[name]');
                $(value).find('[name*="[old_name]"]').attr('name', common_value + '[old_name]');
            });
        }

        document.getElementById('autocomplete').addEventListener('keypress', function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });

        var placeSearch, autocomplete;
        var componentForm = {
            locality: 'long_name'
        };
        function initAutocomplete() {
            autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            var place = autocomplete.getPlace();

            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();

            for (var component in componentForm) {
                document.getElementById(component).value = '';
                document.getElementById(component).disabled = false;
            }

            for (var i = 0; i < place.address_components.length; i++) {
                var addressType = place.address_components[i].types[0];
                if (componentForm[addressType]) {
                    var val = place.address_components[i][componentForm[addressType]];
                    document.getElementById(addressType).value = val;
                }
            }
        }

        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('constants.GOOGLE_MAP_API') }}&libraries=places&callback=initAutocomplete"
            async defer></script>
@stop
