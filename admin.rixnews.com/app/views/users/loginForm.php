<html>
    <head>
        <title>RixNews - Control Panel</title>
        <link rel="stylesheet" type="text/css" href="/styles/loginForm.css">
        <link rel="stylesheet" type="text/css" href="/styles/style.css">
        <link rel="shortcut icon" href="/favicon.ico" />
        <script src="https://code.jquery.com/jquery-3.4.0.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="loader-wrapper" id="loader-1">
            <div id="loader"></div>
        </div>

        <div class="wrapper fadeInDown">
            <div id="formLogin" class="form">
                <!-- Tabs Titles -->
                <h2 id="h2Login" class="active"> Sign In </h2>
                <h2 id="h2Register" class="inactive underlineHover">Sign Up </h2>

                <!-- login FORM -->
                <div id="loginForm">
                    <!-- Icon -->
                    <div class="fadeIn first">
                        <img src="/images/admin.png" id="icon" alt="User Icon" />
                    </div>

                    <!-- Login Form -->
                    <form id="formLogin">
                        <input type="text" id="l" class="fadeIn second" name="login" placeholder="login">
                        <input type="password" id="p" class="fadeIn third" name="password" autocomplete="off" placeholder="password">
                        <input type="button" id="buttonLogin" class="fadeIn fourth" value="Log In">
                    </form>
                </div>


                <!-- registerForm -->
                <div id="registerForm">
                    <!-- Register Form -->
                    <form id="formRegister">
                        <input type="text" id="login" class="fadeIn first" name="login" placeholder="Username">
                        <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email">
                        <input type="password" id="password" class="fadeIn third" name="password"  autocomplete="off" placeholder="Password">
                        <input type="password" id="repassword" class="fadeIn third" name="repassword"  autocomplete="off" placeholder="Re-enter password">
                        <input type="text" id="invitecode" class="fadeIn fourth" name="invitecode"  autocomplete="off" placeholder="Invite code">
                        <input type="button" id="buttonRegister" class="fadeIn fourth" value="Register">
                    </form>
                </div>                

                <!-- Remind Passowrd -->
                <div id="formFooter">
                    <a class="underlineHover" href="#">Forgot Password?</a>
                </div>
            </div>        
        </div>
        <script type="text/javascript">
            // function to set cookie
            function setCookie(cname, cvalue, exdays) {
                var d = new Date();
                d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
                var expires = "expires=" + d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }


            function serializeObj(form) {
                obj = {};
                form.serializeArray().map(function (key, value) {
                    obj[key.name] = key.value;
                })
                return JSON.stringify(obj);
            }


            $().ready(function () {

                $('#loader-1').hide();
                $(document).ajaxStart(function () {
                    $('#loader-1').show();
                });

                $(document).ajaxComplete(function () {
                    $('#loader-1').hide();
                });

                $('#registerForm').hide();
                $('#h2Register').click(function () {
                    $('input[type=text]').val('');
                    $('input[type=password]').val('');
                    $('input').removeClass('inputError');
                    $('#loginForm').hide();
                    $('#registerForm').show();
                    $('h2').removeClass();
                    $('#h2Register').addClass('active');
                    $('#h2Login').addClass('inactive underlineHover');
                });
                $('#h2Login').click(function () {
                    $('input[type=text]').val('');
                    $('input[type=password]').val('');
                    $('input').removeClass('inputError');
                    $('#loginForm').show();
                    $('#registerForm').hide();
                    $('h2').removeClass();
                    $('#h2Login').addClass('active');
                    $('#h2Register').addClass('inactive underlineHover');
                });


                $('#buttonLogin').click(function () {
                    $('input').removeClass('inputError');
                    $.ajax({
                        url: 'http://api.rixnews.com/user/login',
                        type: "POST",
                        data: serializeObj($('form#formLogin')),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function (data) {
                            if (data.JWT)
                            {
                                setCookie('JWT', data.JWT, 1);
                                localStorage.setItem('JWT', data.JWT);
                                location.href = '/source/edit';
                            } else {
                                $('input').addClass('inputError');
                            }

                        }
                    })
                });


                $('#buttonRegister').click(function () {
                    $('input').removeClass('inputError');

                    $.ajax({
                        url: 'http://api.rixnews.com/user/new',
                        type: 'POST',
                        data: serializeObj($('form#formRegister')),
                        contentType: 'application/json; charset=utf-8',
                        dataType: 'json',
                        success: function (data) {
                            $.each(data, function (key, value) {
                                if (!value)
                                    $('#' + key).addClass('inputError');
                            });
                            if (data.JWT)
                            {
                                setCookie('JWT', data.JWT, 1);
                                localStorage.setItem('JWT', data.JWT);
                                location.href = '/source/edit';
                            }
                        }
                    })
                })


            })
        </script>
    </body>
</html>