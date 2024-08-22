<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Email</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Raleway', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-weight: 600;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 25px;
            padding: 10px 20px;
            font-size: 16px;
        }
        #email-list {
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .list-group-item {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .list-group-item:hover {
            background-color: #f1f1f1;
        }
        #selected-email {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        #selected-email h4 {
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 10px;
        }
        #email-details {
            font-size: 16px;
            color: #495057;
        }
        #loading-message {
            text-align: center;
            color: #6c757d;
            margin-top: 10px;
            display: none;
        }
        #no-results {
            text-align: center;
            color: #dc3545;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Search Email</h2>
        <div class="form-group">
            <input type="text" id="email-search" class="form-control" placeholder="Masukan Email....">
            <ul id="email-list" class="list-group mt-2" style="display: none;"></ul>
            <p id="loading-message">Sedang mencari....</p>
            <p id="no-results">Email Tidak Di temukan..</p>
        </div>

        <div id="selected-email" class="mt-3" style="display: none;">
            <h4>Selected Email:</h4>
            <p id="email-details"></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#email-search').on('keyup', function() {
                var query = $(this).val();

                // Reset and show loading message
                $('#loading-message').show();
                $('#no-results').hide();
                $('#email-list').hide();
                $('#email-list').empty();

                if (query.length >= 2) {
                    $.ajax({
                        url: '{{ route("find-json") }}',
                        type: 'GET',
                        data: {'query': query},
                        success: function(data) {
                            $('#loading-message').hide();

                            var emailList = $('#email-list');
                            if (data.length === 0) {
                                $('#no-results').show();
                            } else {
                                $.each(data, function(index, item) {
                                    emailList.append('<li class="list-group-item email-item" data-email="' + item.email + '">' + item.email + '</li>');
                                });
                                emailList.show();
                            }
                        },
                        error: function(xhr) {
                            $('#loading-message').hide();
                            if(xhr.status === 403) {
                                $('#email-list').empty().append('<li class="list-group-item text-danger">' + xhr.responseJSON.Data + '</li>').show();
                            }
                        }
                    });
                } else {
                    $('#loading-message').hide();
                }
            });

            $(document).on('click', '.email-item', function() {
                var email = $(this).data('email');

                $('#selected-email').show();
                $('#email-details').html('<strong>Email:</strong> ' + email);
                $('#email-list').hide();
                $('#email-search').val(email); // Optional: fill input with selected email
            });
        });
    </script>
</body>
</html>
