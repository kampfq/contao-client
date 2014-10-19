window.onload = function () {

    var server = document.getElementById('auth_server');
    server.addEventListener ('change', onChangeServer, true);

    var submit = document.getElementById('login');
    submit.addEventListener ('click', onSubmit, true);

    var serverId = 0;

    function onSubmit() {
        if(serverId == 0 || serverId == "") {
            return;
        }

        document.getElementById("username").removeAttribute('required');
        document.getElementById("password").removeAttribute('required');
    }

    function onChangeServer() {
        serverId = server.options[server.selectedIndex].value;

        var toggleElements;
        // var submitButton;
        //var submitButtonInitialValue;
        toggleElements = document.querySelectorAll(
            ".tl_login_form tbody tr:nth-child(2)," +
            ".tl_login_form tbody tr:nth-child(3)," +
            ".tl_login_form tbody tr:nth-child(4)"
        );
        //submitButton = document.getElementById("login");
        //submitButtonInitialValue = submitButton.value;

        if(serverId == "0" || serverId == "") {
            // display
            for (var i = 0; i < toggleElements.length; i++) {
                toggleElements[i].style.display = "table-row";
            }
            //submitButton.value = submitButtonInitialValue;
        }
        else {
            // hide
            for (var i = 0; i < toggleElements.length; i++) {
                toggleElements[i].style.display = "none";
            }
            //submitButton.value = 'Weiter';
        }
    }
}