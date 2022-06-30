<!doctype html>
<html >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sms</title>

    <link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
</head>
<body>

<!-- Add Modal -->
<div class="modal fade" id="AddMessagesModal" tabindex="-1" aria-labelledby="AddMessagesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddMessagesModalLabel">Add Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="save_msgList"></ul>

                <div class="form-group mb-3">
                    <label for="">Your  Message</label>
                    <input type="text" required class="message form-control">
                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_sms">Save</button>
            </div>

        </div>
    </div>
</div>



<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

            <div id="success_message"></div>

            <div class="card">
                <div class="card-header">
                    <h4>
                      All  Sms 
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#AddMessagesModal">Add Sms</button>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Messags</th>
                                <th>Status</th>

                             
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src=" {{asset('jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap.bundle.min.js')}}"></script>

</body>

<script>
    $(document).ready(function () {

        fetchMessage();

        function fetchMessage() {
            $.ajax({
                type: "GET",
                url: "/all-sms",
                dataType: "json",
                success: function (response) {
                    // console.log(response);
                    $('tbody').html("");
                    $.each(response.sms, function (key, item) {
                        $('tbody').append('<tr>\
                            <td>' + item.message + '</td>\
                            <td>' + item.status + '</td>\
                        \</tr>');
                    });
                }
            });
        }

        $(document).on('click', '.add_sms', function (e) {
            e.preventDefault();

            $(this).text('Sending..');
            // $(this).addClass('btn-success');

            var data = {
                'message': $('.message').val()
                
            }
            // console.log(data)

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/sms",
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == 400) {
                        $('#save_msgList').html("");
                        $('#save_msgList').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_msgList').append('<li>' + err_value + '</li>');
                        });
                        $('.add_sms').text('Save');
                    } else {
                        $('#save_msgList').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#AddMessagesModal').find('input').val('');
                        $('.add_sms').text('Save');
                        $('#AddMessagesModal').modal('hide');
                        fetchMessage();
                    }
                }
            });

        });

      

    });

</script>

