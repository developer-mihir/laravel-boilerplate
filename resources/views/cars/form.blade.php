<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title"
                   value="{{ !empty($car) ? $car->title : old('title') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="is_active">Is Active</label><br>
            <div class="checkbox-fade fade-in-primary">
                <label>
                    <input type="checkbox" value="1" name="is_active"
                        {{ isset($car) && $car->is_active == 1 ? 'checked="checked"' : '' }}>
                    <span class="cr">
                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                    </span> <span></span>
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label" for="location">Location</label>
            <input type="text" id="autocomplete" class="form-control" name="location"
                   placeholder="Enter a location" onFocus="geolocate()"
                   value="{{ !empty($car) ? $car->location : old('location') }}"/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="latitude">Latitude</label>
            <input type="text" class="form-control" id="latitude" name="latitude"
                   value="{{ !empty($car) ? $car->latitude : old('latitude') }}">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="form-label" for="longitude">Longitude</label>
            <input type="text" class="form-control" id="longitude" name="longitude"
                   value="{{ !empty($car) ? $car->longitude : old('longitude') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label class="form-label" for="description">Description</label>
            <textarea rows="5" cols="5" class="form-control" name="description" id="description"
                      placeholder="Type here something...">{{ !empty($car) ? $car->description : old('description') }}</textarea>
        </div>
    </div>
</div>

<div class="well">
    <h5 class="mb-4"><strong>Attachments</strong></h5>
    <div class="attachments_section">
        @if(!empty($car->attachments) && count($car->attachments) > 0)
            @foreach($car->attachments as $key => $car_attachment)
                <div class="attachments_html attachments_html_{{ $key }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="picture" class="form-label">Picture</label>
                                @if(isset($car_attachment) && !empty($car_attachment->name))
                                    <a href="{{ asset('uploads/cars/' . $car_attachment->name) }}"
                                       target="_blank" class="pull-right">
                                        <i class="fa fa-image"></i>
                                    </a>
                                @endif

                                <input type="file" class="form-control" value=""
                                       name="attachments[{{ $key }}][name]">
                                <input type="hidden" class="form-control"
                                       value="{{ isset($car_attachment) && !empty($car_attachment->name) ? $car_attachment->name : '' }}"
                                       name="attachments[{{ $key }}][old_name]">
                            </div>
                        </div>

                        @if($key > 0)
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-secondary remove_from_more"
                                            style="margin-top: 30px !important;"
                                            data-parent-element="attachments_html">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
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
                </div>
            </div>
        @endif
    </div>

    <div class="row mt-3">
        <div class="col-md-3">
            <div class="form-group">
                <a href="javascript:void(0);" class="btn btn-outline-primary add_attachments">
                    <i class="ti ti-plus"></i>
                    Add More Attachments
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <button type="submit" class="btn btn-primary pull-right">Submit</button>
        </div>
    </div>
</div>
