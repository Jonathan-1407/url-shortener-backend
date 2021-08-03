@extends('layout.app')

@section('title') 
  @if($exists == 0 || $url->title == "none" || $url->title == "")
    Shortener URL Free
  @else
    {{$url->title}}
  @endif
@endsection

@section('content')
    @if($exists)
    <div class="flex justify-center flex-col w-full h-full h-screen">
    <form id="report-link" action="/{{$url->short_url}}/report" method="POST">
      <input type="hidden" id="selectedReportType" name="selectedReportType">
    </form>
      <span class="text-md text-center font-semibold" id="text">Getting URL, wait:</span>
      <span class="text-center text-5xl font-bold text-indigo-500" id="countdown">10</span>
      <span class="text-md text-center font-semibold mb-4" id="text-second">Seconds</span>
      <span class="text-lg text-center font-semibold text-gray-700 hidden m-4" id="thanks">Thanks! for using our services</span>
      <a class="text-sm text-center font-display font-semibold text-red-400 hover:text-red-600 cursor-pointer hover:underline" onclick="deleteConfirm('report-link')">
        Report URL
      </a>
    </div>
    @else
    <div class="flex justify-center flex-col w-full h-full h-screen">
      <span class="fas fa-link text-5xl text-gray-600 text-center pb-4"></span>
        <h1 class="text-center font-bold">404 URI Not Found</h1>
    </div>
    @endif
@endsection

@section('scripts')
  @if($exists)
    <script type="text/javascript">
      window.deleteConfirm = function(formId) {
        Swal.fire({
          title: '<strong>Report URL</strong>',
          html:
            '<label class="inline-flex items-center p-1"> \
              <input type="radio" class="form-radio" name="reportType" value="Spam content" checked>\
              <span class="ml-2">Spam content</span>\
            </label><br>' +
            '<label class="inline-flex items-center p-1">\
              <input type="radio" class="form-radio" name="reportType" value="Violent content">\
              <span class="ml-2">Violent content</span>\
            </label><br>' +
            '<label class="inline-flex items-center p-1">\
              <input type="radio" class="form-radio" name="reportType" value="Sexual content">\
              <span class="ml-2">Sexual content</span>\
            </label><br>' +
            '<label class="inline-flex items-center p-1">\
                <input type="radio" class="form-radio" name="reportType" value="Infringes my rights">\
              <span class="ml-2">Infringes my rights</span>\
            </label>',
          showCloseButton: true,
          showCancelButton: true,
          focusConfirm: false,
          confirmButtonText: 'Report!',
          confirmButtonAriaLabel: 'Report',
          cancelButtonText: 'Cancel',
          cancelButtonAriaLabel: 'Cancel'
          }).then((result) => {
              if (result.isConfirmed) {
                let report = document.querySelector('input[name="reportType"]:checked').value;
                let reportType = document.getElementById('selectedReportType');
                reportType.value = report;
                document.getElementById(formId).submit();
                Swal.fire('Reported link!', '', 'success')
                reportType = "";
              }
          });
      }

      var timeleft = 10;
      var downloadTimer = setInterval(function(){
        if(timeleft <= 0){
          clearInterval(downloadTimer);
              document.getElementById("text").innerHTML = 'Prepared URL:';
              document.getElementById("text-second").style.display = 'none';
              document.getElementById("thanks").style.display = 'block';
              document.getElementById("countdown").innerHTML = "<a href={{$url->original_url}} class='rounded-full py-3 px-6 bg-indigo-500 text-sm text-white'>Get Link</a>";
        } else {
              document.getElementById("text").innerHTML = 'Getting URL, wait:';
          document.getElementById("countdown").innerHTML = timeleft;
        }
        timeleft -= 1;
      }, 1000);
    </script>
  @endif
@endsection
