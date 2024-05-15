<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>create</title>
</head>

<body>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    <div class="bg-dark py-3">
        <div class="container">
            <a class="h3 text-white text-decoration-none" href="{{ route('products.index') }}">PRODUCTS VIEW PAGE</a>
        </div>
    </div>

    <div class="container">
        <h2 class="text-center mt-3">View Page</h2>
        {{-- {{$title}} --}}
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card p-3 mt-3 ">
                    <form action="" method="" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">Name :- {{ $product->name }}</label>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email :- {{ $product->email }}</label>

                        </div>

                        <div class="form-group">
                            <label for="name" class="form-label">Address :- {{ $product->address }}</label>
                        </div>

                        <div class="form-group">
                            <label for="country" class="form-label">Country :- {{ $product->countries->country_name }} </label>
                        </div>

                        <div class="form-group">
                            <label for="state" class="form-label">State :- {{ $product->states->state_name }} </label>
                        </div>

                        <div class="form-group">
                            <label for="city" class="form-label">City :- {{ $product->cities->city_name }} </label>
                        </div>

                        <div class="form-group">
                            <label for="hobby" class="form-label">Hobby :- {{ $product->hobby_mapping->pluck('hobby.hobby_name')->implode(',') }} </label>
                        </div>


                        {{-- <div class="form-group">
                            <label for="fromdate" class="form-label">From Date :{{ $product->fromdate }} </label>
                        </div>

                        <div class="form-group">
                            <label for="todate">To Date : {{ $product->todate }}</label>
                        </div> --}}

                        <div class="form-group">
                            <label for="name" class="form-label">Image:</label><br>
                            {{-- <input type="file" name="image" class="form-control"  value="{{$product->image ?? old('image')}}"> --}}
                            <img src="{{ url('public/products/' . $product->image) }}" alt="" height="100px"
                                width="100px">

                        </div>


                        {{-- <input type="text" name="id"  value="{{ $product->id ?? ''}}" readonly>
                        <button type='submit' value="{{$title}}" name="button" class='btn btn-dark'>{{$title}}</button>
                        <a class="btn btn-danger" href="{{route('products.index')}}">Cancel</a> --}}



                    </form>


                </div>
                
                <button type="submit" value="" class="btn btn-dark mt-2"
                    onclick="window.location='{{ route('products.index') }}'">Back</button>
            </div>

        </div>

    </div>




</body>

</html>
