 <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <script>
     @if (Session::has('message'))
         var type = "{{ Session::get('alert-type', 'info') }}";

         switch (type) {
             case 'info':
                 Swal.fire({
                     icon: 'info',
                     title: "{{ Session::get('message') }}",
                     showConfirmButton: false,
                     timer: 3000,
                     timerProgressBar: true,
                     didOpen: (toast) => {
                         toast.addEventListener('mouseenter', Swal.stopTimer);
                         toast.addEventListener('mouseleave', Swal.resumeTimer);
                     }
                 });
                 break;
             case 'success':
                 Swal.fire({
                     icon: 'success',
                     title: "{{ Session::get('message') }}",
                     showConfirmButton: false,
                     timer: 3000,
                     timerProgressBar: true,
                     didOpen: (toast) => {
                         toast.addEventListener('mouseenter', Swal.stopTimer);
                         toast.addEventListener('mouseleave', Swal.resumeTimer);
                     }
                 });
                 break;
             case 'warning':
                 Swal.fire({
                     icon: 'warning',
                     // toast: true,
                     // position: "top-end",
                     title: "{{ Session::get('message') }}",
                     showConfirmButton: false,
                     timer: 3000,
                     timerProgressBar: true,
                     didOpen: (toast) => {
                         toast.addEventListener('mouseenter', Swal.stopTimer);
                         toast.addEventListener('mouseleave', Swal.resumeTimer);
                     }
                 });
                 break;
             case 'error':
                 Swal.fire({
                     icon: 'error',
                     // toast: true,
                     // position: "top-end",
                     title: "{{ Session::get('message') }}",
                     showConfirmButton: false,
                     timer: 3000,
                     timerProgressBar: true,
                     didOpen: (toast) => {
                         toast.addEventListener('mouseenter', Swal.stopTimer);
                         toast.addEventListener('mouseleave', Swal.resumeTimer);
                     }
                 });
                 break;
         }
     @endif
 </script>
 <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCheckbox = document.getElementById('select-all');
        const checkboxes = document.querySelectorAll('input[name="permission[]"]');

        // Only continue if the selectAllCheckbox exists
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(function (checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener('change', function () {
                    if (!checkbox.checked) {
                        selectAllCheckbox.checked = false;
                    } else {
                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        selectAllCheckbox.checked = allChecked;
                    }
                });
            });
        }
    });
</script>

