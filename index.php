<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <link rel="stylesheet" href="css/normalize.css" />
    <link rel="stylesheet" href="css/sweetalert2.css" />
    <link rel="stylesheet" href="css/material2.min.css" />
    <link rel="stylesheet" href="css/material-design-iconic-font.min.css" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.css" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
      window.jQuery ||
        document.write('<script src="js/jquery-1.11.2.min.js"><\/script>');
    </script>
    <script src="js/material.min.js"></script>
    <script src="js/sweetalert2.min.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/main.js"></script>
  </head>
  <body>
    <div class="login-wrap cover">
      <div class="container-login">
        <p class="text-center" style="font-size: 25px">
          <img
            src="assets/img/fontLogin3.jpg"
            alt="Logo"
            style="max-width: 35%; border-radius: 50%"
          />
        </p>

        <p class="text-center text-condensedLight">
          Inicie sesión con su cuenta
        </p>
        <form action="login.php" method="POST">
          <div
            class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
          >
            <input
              class="mdl-textfield__input"
              type="text"
              name="user"
              required
              id="user"
            />
            <label
              class="mdl-textfield__label"
              style="text-align: center"
              for="user"
              >Usuario</label
            >
          </div>
          <div
            class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label"
          >
            <input
              class="mdl-textfield__input"
              type="text"
              name="pass"
              required
              id="pass"
            />
            <label
              class="mdl-textfield__label"
              for="pass"
              style="text-align: center"
              >Contraseña</label
            >
          </div>
          <button
            type="submit"
            value="sesion"
            class="mdl-button mdl-js-button mdl-js-ripple-effect"
            style="color: #3f51b5; margin: 0 auto; display: block"
          >
            Inciar
          </button>
        </form>
      </div>
    </div>
  </body>
</html>
