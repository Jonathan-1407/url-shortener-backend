@extends('layout.app')

@section('title') 
  @if($exists == 0 || $url->title == "none" || $url->title == "")
    Shortener URL Free
  @else
    {{$url->title}}
  @endif
@endsection

@section('content')
  <div class="flex justify-center flex-col w-full h-full h-screen">
    @if($exists)
    <span class="text-md text-center font-semibold">It will be automatically redirected in</span>
      <span class="text-center text-5xl font-bold text-indigo-500" id="countdown">10</span>
    <span class="text-md text-center font-semibold">Seconds</span>
    <span class="text-lg text-center font-semibold text-gray-700 pt-8">Thanks! for using our services</span>
    @else
      <h1 class="text-center font-bold">404 URI Not Found</h1>
    @endif
  </div>
@endsection

@section('scripts')
  @if($exists)
    <script type="text/javascript">
      var timeleft = 10;
      var downloadTimer = setInterval(function(){
        if(timeleft <= 0){
          clearInterval(downloadTimer);
          document.getElementById("countdown").innerHTML = "Redirecting...";
          window.location.href = "{{$url->original_url}}";
        } else {
          document.getElementById("countdown").innerHTML = timeleft;
        }
        timeleft -= 1;
      }, 1000);
    </script>
  @endif
@endsection
