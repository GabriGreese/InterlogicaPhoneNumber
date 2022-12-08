<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Numbers</title>

    <!-- Styles -->
    <link href="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>

<div class="card mb-3">
    <div class="card-body overflow-auto">
        <table id="numbers" class="table table-hover">
        </table>
    </div>
</div>

<!-- modal -->
<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

            </div>

        </div>

    </div>
</div>
<!-- / modal -->


<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>
    var init = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    /**
     * Init Modal
     */
    var initModal = function () {
        // open modal trigger
        $('.load-modal').click(function () {
            var path = $(this).data('path');
            var html = $(this).data('html');

            // check if AJAX modal
            if (path !== undefined) {
                $.ajax({
                    type: 'POST',
                    url: path,
                    success: function (result) {
                        $(".modal-body").html(result);
                    },
                    error: function (error) {
                        alert(error);
                    }
                });
            } else {
                if (html !== undefined)
                    $(".modal-body").append(html);
            }

            var modal = $("#modal");

            var boostrapModal = new bootstrap.Modal(modal, {
                keyboard: false
            });

            boostrapModal.show();
        });
    };

    /**
     * Init DataTable
     */
    var initDataTable = function () {
        var tb;

        tb = $('#numbers').DataTable({
            ajax: {
                url: "{{route('number.indexAjax')}}",
                method: 'POST'
            },
            columns: [
                {data: 'csv_id', title: "{{__('ID')}}", defaultContent: '--'},
                {data: 'sms_phone', title: "{{__('Phone #')}}", defaultContent: '--'},
                {data: 'correctness', title: "{{__('Correctness')}}", defaultContent: '--', searchable: false},
                {data: 'actions', title: "{{__('Actions')}}", defaultContent: '--', searchable: false, orderable: false},
            ],
            drawCallback: function () {
                afterDataTableDraw()
            }
        });
    }

    /**
     * Actions after DataTable draw
     */
    var afterDataTableDraw = function () {
        initModal();
    }

    /**
     * Reload DataTable via API
     */
    var reloadDatatable = function () {
        tb.ajax.reload();
    };

    $(document).ready(function () {
        init();
        initDataTable();
    });
</script>
</body>
</html>
