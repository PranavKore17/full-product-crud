<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card p-5 mt-5 ">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name"
                                value="{{ $product->name ?? old('name') }}">
                                <span class="text-danger">
                                    @error('name')
                                        {{$message}}
                                    @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">email</label>
                            <input type="text" name="email" class="form-control" placeholder="Enter your email"
                                value="{{ $product->email ?? old('email') }}">
                                <span class="text-danger">
                                    @error('email')
                                        {{$message}}
                                    @enderror
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea type="text" rows="2" name="address" id="address" class="form-control"
                                placeholder="Enter your address">{{ $product->address ?? old('address') }}</textarea>
                                <span class="text-danger">
                                    @error('address')
                                        {{$message}}
                                    @enderror
                        </div>

                        <div class="form-group">
                            <label for="country">Select Country </label>
                            @if ($errors->has('country'))
                                <span class="text-danger">{{ $errors->first('country') }}</span>
                            @endif
                            <select name="country" id="country" class="form-control">
                                <option value="{{ $row->country_id??old('name')}}">Select Country</option>
                                @foreach ($countries as $test)
                                    {
                                        <option value="{{ $test->id}}" {{ ($test->id == old('country', $product->country_id??''))?'selected':'' }}>{{ $test->country_name }}</option>
                                    }
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="state">Select State</label>
                            @if ($errors->has('state'))
                            <span class="text-danger">{{ $errors->first('state') }}</span>
                        @endif
                            <select name="state" id="state" class="form-control">
                                <option value="{{ $row->state_id??old('name')}}">Select State</option>
                                @foreach ($states as $test )
                                <option value="{{ $test->id}}" {{ ($test->id == old('state', $product->state_id??''))?'selected':'' }}>{{ $test->state_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="city">Select City</label>
                            @if ($errors->has('city'))
                            <span class="text-danger">{{ $errors->first('city') }}</span>
                        @endif
                            <select name="city" id="city" class="form-control">
                                <option value="{{ $row->city_id??old('name')}}">Select city</option>
                                @foreach ($cities as $test )
                                <option value="{{ $test->id}}" {{ ($test->id == old('city', $product->city_id??''))?'selected':'' }}>{{ $test->city_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="hobby">Select Hobby</label>
                            <select name="hobby[]" id="hobby" class="form-control" multiple>
                                @foreach ($hobbies as $test )
                                <option value="{{ $test->id }}" {{ (is_array(old('hobby')) && in_array($test->id, old('hobby'))) || isset($hobby_id) && in_array($test->id, $hobby_id) ? 'selected':'' }}>{{ $test->hobby_name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('hobby'))
                            <span class="text-danger">{{ $errors->first('hobby') }}</span>
                        @endif
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Image</label>
                            <input type="file" name="image" class="form-control mb-2">
                         
                            @if (isset($product) && $product !== null)
                                <img src="{{ url('public/products/', $product->image) }}" alt="" height="70px"
                                    width="70px">
                            @endif

                            <span class="text-danger">
                                @error('image')
                                    {{ $message }}
                                @enderror

                        </div>
                        {{-- 
                        <div class="mb-3 mt-3">
                            <label for="fromdate" class="form-label">From Date</label>
                            <input type="text" name="fromdate" id="fromdate" class="form-control"
                                value="{{ $product->fromdate ?? old('fromdate') }}" autocomplete="off">
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="todate" class="form-label">To Date</label>
                            <input type="text" name="todate" id="todate" class="form-control"
                                value="{{ $product->todate ?? old('todate') }}" autocomplete="off">
                        </div> --}}

                        <div class="form-group">
                            <label>Status</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input status" type="radio" name="status" id="active"
                                    checked='checked' value="active"
                                    {{ old('status', $info->status ?? '') === 'active' ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">Active</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input status" type="radio" name="status" id="inactive"
                                    value="inactive"
                                    {{ old('status', $info->status ?? '') === 'inactive' ? 'checked' : '' }}>
                                <label class="form-check-label" for="inactive">Inactive</label>
                            </div>

                            {{-- <span class="text-danger" id="statusError"></span> --}}
                            @if ($errors->has('status'))
                                <span class='text-danger'>{{ $errors->first('status') }}</span>
                            @endif
                        </div>


                        <input type="hidden" name="id" value="{{ $product->id ?? '' }}">
                        <button type='submit' value="{{ $title }}" name="button"
                            class='btn btn-dark mt-3'>{{ $title }}</button>

                        <a class="btn btn-danger mt-3" href="{{ route('products.index') }}">Cancel</a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    new MultiSelectTag('hobby');
</script>
<script>
    $(document).ready(function() {
        // country dependant states
        $("#country").change(function() {
            var cid = $(this).val();
            $("#state").html('');
            $.ajax({
                url: "{{ route('getState') }}",
                type: 'post',
                dateType: 'json',
                data: {
                    country_id: cid,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {

                    console.log(result);
                    $("#state").html(result
                        .html);
                }

            });

        });

        // state dependant cities
        $("#state").change(function() {
            var sid = $(this).val();
            $("#city").html('');
            $.ajax({
                url: "{{ route('getCity') }}",
                type: 'post',
                dateType: 'json',
                data: {
                    state_id: sid,
                    _token: '{{ csrf_token() }}'
                },
                success: function(result) {

                    console.log(result);
                    $("#city").html(result
                        .html); //accessing the HTML content from the json responce
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {

        $("#fromdate").datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function(selectDate) {
                // Set the minimum selectable date for #todate
                $("#todate").datepicker('option', 'minDate', selectDate);
            }
        });

        $("#todate").datepicker({
            dateFormat: "dd-mm-yy",
            onSelect: function(selectDate) {
                // Set the maximum selectable date for #fromdate
                $("#fromdate").datepicker('option', 'maxDate', selectDate);
            }
        });

    });
</script>
