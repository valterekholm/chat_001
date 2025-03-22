<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatt</title>
    <style>
        #chatbox{

            max-height: 500px;
            overflow: auto;

        }
    </style>
    <script>
        function updateChat() {
            console.log("updateChat");
            fetch("backend.php")
                .then(response => response.text())
                .then(data => {
                    document.getElementById("chatbox").innerHTML = formatChatJson(JSON.parse(data));
                });
        }

        function formatChatJson(data){
            let allChat = document.createElement("div");
            //array
            data.forEach((elem) => {

                let ip = elem.ip;
                let message = elem.message;
                let created_at = elem.created_at;

                let newP = document.createElement("p");
                newP.innerHTML = "<strong>" + ip + "</strong><br>" + message + "<br><em>" + created_at + "</em><hr>";
                
                allChat.appendChild(newP);
            })

            return allChat.innerHTML;
        }

        setInterval(updateChat, 5000);

        function sendMessage() {
            console.log("sendMessage");
            let message = document.getElementById("message").value.trim();
            if (message === "") return;

            let formData = new FormData();
            formData.append("message", message);

            fetch("backend.php", {
                method: "POST",
                body: formData
            }).then(() => {
                document.getElementById("message").value = "";
                updateChat();
            });
        }

        window.addEventListener("load", function(){
            console.log("load");

            let inp = document.getElementById("message");
            inp.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                console.log('Enter key pressed in input');
                document.querySelector("#send").click();
            }
            });
        });
    </script>
</head>
<body onload="updateChat()">
    <h1>Chatt</h1>
    <div id="chatbox" style="border: 1px solid gray">
        <?php
        /*
        foreach ($messages as $msg):
            echo "<p><strong>" . htmlspecialchars($msg['ip']) . ":</strong>" . htmlspecialchars($msg['message']) ."<em>" . 
            $msg['created_at'] . "?></em></p>";
        endforeach;
        */
        ?>

    </div>
    <input type="text" id="message" placeholder="Skriv ett meddelande">
    <button onclick="sendMessage()" id="send">Skicka</button>
</body>
</html> 