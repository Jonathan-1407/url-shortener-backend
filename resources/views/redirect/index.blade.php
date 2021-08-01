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
    <a class="text-sm font-display font-semibold text-red-700 hover:text-red-800 cursor-pointer float-right pr-5" onclick="deleteConfirm('report-link')">
      Report URL
    </a>
    <form id="report-link" action="/{{$url->short_url}}/report" method="POST">
      <input type="hidden" id="selectedReportType" name="selectedReportType">
    </form>
    <div class="flex justify-center flex-col w-full h-full h-screen">
      <span class="text-md text-center font-semibold">It will be automatically redirected in</span>
        <span class="text-center text-5xl font-bold text-indigo-500" id="countdown">10</span>
      <span class="text-md text-center font-semibold">Seconds</span>
      <span class="text-lg text-center font-semibold text-gray-700 pt-8">Thanks! for using our services</span>
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
