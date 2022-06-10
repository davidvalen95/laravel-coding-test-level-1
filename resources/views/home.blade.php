@extends('master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 id="ip">
                    Loading...
                </h1>

                <a href="{{route('events.get')}}">
                    <h2>Event List</h2>
                </a>

                {{Cache::get('data','not yet go to event  controller, no data set yet')}}
            </div>
        </div>
    </div>



@endsection

@section('script')

    <script>
        $(document).ready(function () {
            $.ajax({
                type   : "GET",
                url    : 'http://ipinfo.io/ip',
                success: function (data) {

                    $("#ip").html("Your IP Address: " + data)
                },
            });
        })


    </script>
@append