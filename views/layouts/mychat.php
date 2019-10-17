<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>NodeJS Chat by @mriso_dev</title>
    <style>
        .box {
            border: 1px solid;
            height: 100px;
            width: 100%;
            overflow: auto;
        }

        .sizeinput {
            width: 400px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Realtime NodeJS Chat</h2>
                <p><em>by @mriso_dev</em></p>
                <div id="msgbox" class="box"></div>
                <br>
                <input type="text" id="msginput" placeholder="Type your message and press enter"
                    class="sizeinput form-control" onkeypress="return runChat(event)">
                <br>
                <button type="button" class="btn btn-sm btn-primary" onclick="saveChat()"><i
                        class="glyphicon glyphicon-comment"></i> Send</button>
                <br>
                <br>
                <div><a href="javascript:;" onclick="updateChat()"><i class="glyphicon glyphicon-refresh"></i>
                        Refresh</a></div>
                <em>Added this function just in case.</em>
            </div>
        </div>
    </div>
    <script src="/assets/jquery-2.1.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <script src="/assets/socket.io-1.2.0.js"></script>
    <script type="text/javascript">

        /*
        REPLACE THE IO HTTP URL BELLOW, TO YOUR OWN SERVER EX: LOCALHOST OR HTTP://YOURSERVER.COM
         */
        var socket_connect = function (room) {
            return io('http://localhost:3000', {
                query: 'r_var=' + room
            });
        }

        // socket connect: var is the room id
        // THE ROOM ID IS UP TO YOUR APP OR SESSION
        var socket = socket_connect(1);

        $(function () {
            socket.on('chat message', function (msg) {
                getChat();
            });
        });

        function runChat(event) {
            if (event.which == 13 || event.keyCode == 13) {
                saveChat();
                return false;
            }
            return true;
        };

        function saveChat() {
            var chatMsg = $("#msginput").val();
            if (chatMsg != '') {
                $.ajax({
                    type: "POST",
                    url: "http://127.0.0.1:8080/server/savedata.php",
                    dataType: "json",
                    data: { chatMsg: chatMsg }
                })
                    .done(function (data) {
                        socket.emit('chat message', chatMsg);
                        //mount(data);
                        $("#msginput").val("");
                    });
            }
        }

        function getChat() {
            $.ajax({
                type: "POST",
                url: "http://127.0.0.1:8080/server/getData.php",
                dataType: "json",
                data: { room: 1 }
            })
                .done(function (data) {
                    mount(data.data);
                    $('#msgbox').scrollTop($('#msgbox')[0].scrollHeight);
                });

        }

        function mount(data) {
            var html = "";
            var cssclass = "brown-color";
            var img = '';
            $.each(data, function (index, chat) {
                html += '<div>' + chat.user + ' Dummy Guy <i>' + chat.sent_at + '</i>:</span> ' + chat.message + '</div>';
            });

            $("#msgbox").html(html);
        }

        $(function () {
            getChat();
            $('#msgbox').scrollTop($('#msgbox')[0].scrollHeight);
            $('#msginput').focus();
        });

        function updateChat() {
            getChat();
            return false;
        }
    </script>

</body>

</html>