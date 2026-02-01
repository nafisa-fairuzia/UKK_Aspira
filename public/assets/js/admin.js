    $(document).ready(function() {
        $('.btn-open-modal').on('click', function() {
            const id = $(this).data('id');
            const form = document.getElementById('feedbackForm');
            form.action = `/admin/pengaduan/${id}`;
            
            const myModal = new bootstrap.Modal(document.getElementById('feedbackModal'));
            myModal.show();
        });
    });