@section('scriptsload')

<script src="{{ asset('js/vendor.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/jquery.form.min.js') }}"></script>
<script src="{{ asset('js/template.js') }}"></script>

// SweetAlert
<link href="{{ asset('plugins/SweetAlert/sweetalert.css') }}" rel="stylesheet">
<script src="{{ asset('plugins/SweetAlert/sweetalert.min.js') }}"></script>

// Select2
<script src="{{ asset('plugins/Select2/Select2.min.js') }}"></script>
<link href="{{ asset('plugins/Select2/Select2.min.css') }}" rel="stylesheet">

// Tinymce
<script src="{{ asset('plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('plugins/tinymce/jquery.tinymce.min.js') }}"></script>

<script src="{{ asset('plugins/js.cookie.js') }}"></script>

<script>
    var interval= setInterval(()=>
    {
        var dowloadfile=Cookies.get('fileLoading');
        if (dowloadfile) {
            Cookies.remove('fileLoading', { path: '/ventas' });
            //reload the page after dowload the file
            clearInterval(interval);
            location.reload();
        }
    },1000);
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    $(document).ready(function() {
        $('select').select2();
    });
</script>
@endsection
