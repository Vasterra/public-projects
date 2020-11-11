76767676
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>

<button onclick="getForAll('users/me')">Me</button>
<button onclick="updateMe()">Update Me</button>
<script>
    function getForAll(action) {
        $.ajax({
            url: 'http://larpass.loc/api/v1/' + action,
            headers: {
                'Authorization': 'Bearer ' + '{{$token}}',
                'Content-Type': 'application/json'
            },
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });
    };

    function updateMe() {
        $.ajax({
            url: 'http://larpass.loc/api/v1/users/updateAndActivateMe',
            headers: {
                'Authorization': 'Bearer ' + '{{$token}}',
                'Content-Type': 'application/json'
            },
            data: JSON.stringify({
                'password': '12345678',
            }),
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
        });
    };
</script>
