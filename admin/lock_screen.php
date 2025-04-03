<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Lock Example</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <style>
        #lockScreen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            text-align: center;
            padding-top: 20%;
            z-index: 1000;
        }
    </style>
</head>

<body>

    <div id="lockScreen">
        <h2>Session Locked</h2>
        <p id="usernameDisplay"></p>
        <p>Please login again to continue.</p>
        <form id="unlockForm" action="../verify_password" method="POST">
            <input type="hidden" id="username" name="username" />
            <input type="password" id="password" name="password" placeholder="Enter password" required />
            <button type="submit">Unlock</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        let inactivityTime = 0;
        const lockTime = 120; // Lock after 120 seconds of inactivity

        function resetTimer() {
            inactivityTime = 0;
            localStorage.setItem('inactivityTime', inactivityTime);
        }

        function lockSession() {
            document.getElementById('lockScreen').style.display = 'block';
            localStorage.setItem('isLocked', 'true');
            const username = localStorage.getItem('username');
            document.getElementById('usernameDisplay').innerText = `${username}`;
            document.getElementById('username').value = username; // Set the hidden username input
        }

        function checkInactivity() {
            inactivityTime++;
            localStorage.setItem('inactivityTime', inactivityTime);

            if (inactivityTime >= lockTime) {
                lockSession();
            }
        }

        window.onload = function () {
            inactivityTime = parseInt(localStorage.getItem('inactivityTime')) || 0;

            // Check if the session is locked
            if (localStorage.getItem('isLocked') === 'true') {
                lockSession();
            } else {
                // Reset inactivity timer if not locked
                resetTimer();
            }

            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;

            setInterval(checkInactivity, 1000);
        };

        // Handle form submission
        document.getElementById('unlockForm').onsubmit = function (event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this); // Create FormData object from the form

            fetch(this.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        toastr.success(data.message, 'Success', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                        localStorage.setItem('isLocked', 'false'); // Unlock the session
                        document.getElementById('lockScreen').style.display = 'none'; // Hide lock screen
                        resetTimer(); // Reset inactivity timer after unlocking
                    } else {
                        toastr.error(data.message, 'Error', {
                            positionClass: 'toast-top-right',
                            timeOut: 3000
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An error occurred while unlocking the session.', 'Error', {
                        positionClass: 'toast-top-right',
                        timeOut: 3000
                    });
                });
        };
    </script>

</body>

</html>