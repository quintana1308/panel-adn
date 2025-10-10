<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Herramienta de Business Intelligence">
    <meta name="author" content="ADN PANEL">

    <meta name="theme-color" content="#fff">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ADN Panel">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="white">


    <link rel="apple-touch-icon" href="<?= media(); ?>/img/icon_5000.png">
    <link rel="apple-touch-icon" sizes="2000x2000" href="<?= media(); ?>/img/icons/icon_2000.png">
    <link rel="apple-touch-icon" sizes="1000x1000" href="<?= media(); ?>/img/icons/icon_1000.png">


    <link href="<?= media(); ?>/img/icon_2000.png" sizes="2000x2000" rel="apple-touch-startup-image" />
    <link href="<?= media(); ?>/img/icon_1000.png" sizes="1000x1000" rel="apple-touch-startup-image" />

    <link rel="shortcut icon" type="image/png" href="<?= media(); ?>/img/brand/logoadn.ico">
    <link rel="manifest" href="./manifest.json">

    <link rel="apple-touch-icon" sizes="76x76" href="<?= media(); ?>/img/apple-icon.png">
    <link rel="icon" type="image/png" href="<?= media(); ?>/img/favicon.png">
    <title>Login Panel</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="<?= media(); ?>/css/nucleo-icons.css" rel="stylesheet" />
    <link href="<?= media(); ?>/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="<?= media(); ?>/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="<?= media(); ?>/css/argon-dashboard.css?v=2.0.4" rel="stylesheet" />
    <link id="pagestyle" href="<?= media(); ?>/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

</head>
<style>

</style>
<?php if($_COOKIE['theme'] == 'dark-version' || $_COOKIE['theme'] == ''){?>

<body id="BgBody" class="bg-body <?= $_COOKIE['theme'] == ''? 'dark-version': $_COOKIE['theme']  ?>"
    style="background-image: url('<?= media() ?>/img/dashboard-oscuro.png');">
    <?php }else{ ?>

    <body id="BgBody" class="bg-body" style="background-image: url('<?= media() ?>/img/dashboard.png');">
        <?php }?>
        <div id="baseUrl" data-value="<?= base_url() ?>"></div>
        <nav
            class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow position-absolute mt-4 py-2 start-0 end-0 mx-4">
            <div class="container-fluid container-topbar-login" bis_skin_checked="1">
                <div>
                    <a class="navbar-brand font-weight-bolder ms-lg-0 ms-3 me-5" href="https://sistemasadn.com/">
                        <?php if($_COOKIE['theme'] == 'dark-version' || $_COOKIE['theme'] == ''){?>
                        <img src="<?= media();?>/img/brand/logo-adn-blanco.png" class="navbar-brand-img h-100"
                            width="100">
                        <?php }else{ ?>
                        <img src="<?= media();?>/img/brand/logo-adn-azul.png" class="navbar-brand-img h-100"
                            width="100">
                        <?php }?>
                    </a>

                </div>
                <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon mt-2">
                        <span class="navbar-toggler-bar bar1 button-togle-sidebar"></span>
                        <span class="navbar-toggler-bar bar2 button-togle-sidebar"></span>
                        <span class="navbar-toggler-bar bar3 button-togle-sidebar"></span>
                    </span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navigation" bis_skin_checked="1">
                    <ul class="navbar-nav top-bar-login-menu">
                        <li class="nav-item text-center">
                            <a class="nav-link me-2" href="https://sistemasadn.com/software-gestion/">
                                Software de Gestion
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link me-2" href="https://sistemasadn.com/productos-web/">
                                Productos Web
                            </a>
                        </li>
                        <li class="nav-item text-center">
                            <div class="d-flex align-items-center justify-content-between">
                                <?php if($_COOKIE['theme'] == 'dark-version'){?>
                                <div id="iconTheme"><i class="fa-regular fa-sun mx-2 mt-2"></i></div>
                                <div class="form-check form-switch ps-0 mt-2 me-3">
                                    <input class="form-check-input mt-0 ms-auto btn-button-login" type="checkbox"
                                        id="dark-version" onclick="darkModeTheme(this)" checked="true">
                                </div>
                                <?php }else{ ?>
                                <div id="iconTheme"><i class="fa-solid fa-moon mx-2 mt-2"></i></div>
                                <div class="form-check form-switch ps-0 mt-2 me-3">
                                    <input class="form-check-input mt-0 ms-auto btn-button-login" type="checkbox"
                                        id="dark-version" onclick="darkModeTheme(this)">
                                </div>
                                <?php }?>
                                <a class="nav-link me-2" href="https://www.facebook.com/sistemasadn/">
                                    <i class="fab fa-facebook-square"></i>
                                </a>
                                <a class="nav-link me-2"
                                    href="https://www.instagram.com/adnsoftware?utm_medium=copy_link">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item text-center">
                            <a href="https://sistemasadn.com/contacto/"
                                class="nav-link btn btn-sm mb-0 me-1 btn-button-login text-white ps-4 pe-4"><i
                                    class="ni ni-support-16 me-2"></i>
                                Ayuda</a>
                        </li>
                    </ul>



                </div>
            </div>
        </nav>
        <main class="main-content">
            <!-- Header -->
            <div class="header  py-7 py-lg-8 pt-lg-9 login-clip-path">
                <div class="container pt-5">
                    <div class="header-body text-center mb-7" style="margin-top: -70px">

                    </div>
                </div>

            </div>

            <!-- Page content -->
            <div class="container mt--8 pb-5">
                <div class="row justify-content-center">
                    <div id="divLoading">
                        <div class="contenedor-loader">
                            <div></div>
                        </div>
                        <p class="cargando">Cargando...</p>
                    </div>
                    <div class="col-lg-4 col-md-7 column-form-login">
                        <div class="card p-4">
                            <div class="card-header pb-0 text-center">
                                <h3>ADN Panel</h3>
                                <p class="mb-0">"Herramienta de Business Intelligence"</p>
                            </div>
                            <div class="card-body">
                                <form class="login-form" name="formLogin" id="formLogin" action="">
                                    <div class="mb-3">
                                        <div class="input-group" bis_skin_checked="1">
                                            <span class="input-group-text ps-3 px-3 bg-secondary" id="basic-addon1"><i
                                                    class="ni ni-email-83 text-white"></i></span>
                                            <input id="txtEmail" name="txtEmail" type="text"
                                                class="form-control form-control-lg ps-3" placeholder="Usuario"
                                                aria-label="Usuario">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group" bis_skin_checked="1">
                                            <span class="input-group-text ps-3 px-3 bg-secondary" id="basic-addon1"><i
                                                    class="ni ni-lock-circle-open text-white"></i></span>
                                            <input id="txtPassword" name="txtPassword" type="password"
                                                class="form-control form-control-lg ps-3" placeholder="Clave"
                                                aria-label="Clave">
                                        </div>
                                    </div>
                                    <!-- <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="rememberMe">
                      <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div> -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-button-login mt-4 mb-0">Entrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="pt-2" id="footer-main">
            <div class="container">
                <div class="row align-items-center justify-content-xl-between">
                    <div class="col-xl-6">
                        <div class="nav nav-footer justify-content-center justify-content-xl-start">
                            &copy; 2024 <a class="font-weight-bold ml-1 ms-2" target="_blank"> ADN
                                Software</a>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                            <li class="nav-item">
                                <a href="https://sistemasadn.com/" target="_blank">www.sistemasadn.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!--   Core JS Files   -->
        <script src="<?= media(); ?>/js/core/popper.min.js"></script>
        <script src="<?= media(); ?>/js/core/bootstrap.min.js"></script>
        <script src="<?= media(); ?>/js/plugins/perfect-scrollbar.min.js"></script>
        <script src="<?= media(); ?>/js/plugins/smooth-scrollbar.min.js"></script>
        <script src="<?= media(); ?>/js/<?= $data['page_functions_js']; ?>"></script>
        <script src="./script.js"></script>
        <script>
        const base_url = "<?= base_url(); ?>";

        // Se ejecuta después de que el DOM cargue completamente
        document.addEventListener("DOMContentLoaded", function () {

        const element = document.getElementById("divLoading");
        if (element) {
            element.style.display = "none";
        }

        // Obtener el elemento de loading
        const loadingElement = document.getElementById('divLoading');

        // Escuchar clics en el documento
        document.addEventListener('click', function (event) {
            let target = event.target;

            while (target && target.tagName !== 'A') {
                target = target.parentElement;
            }

            // Verificar si el elemento clicado es una etiqueta <a>
            if (target && target.tagName === 'A') {

                const href = target.getAttribute('href'); // Obtener la ruta del atributo href

                // Evitar activar el loading para enlaces locales o vacíos (como anclas locales)
                if (href.startsWith('#') || href.trim() === '') {
                    return; // No hacemos nada para anclas o enlaces vacíos
                }

                event.preventDefault(); // Prevenir la acción predeterminada del enlace

                // Mostrar el loading
                loadingElement.style.display = 'flex';

                // Redirigir después de un breve retraso para mostrar el loading
                setTimeout(() => {
                    window.location.href = href;
                }, 50); // Breve retraso para permitir que el overlay se renderice
            }
        });
        });
        </script>

        <script>
        /*var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }*/
        </script>
        <!-- Github buttons -->
        <script async defer src="https://buttons.github.io/buttons.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>

        <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="<?= media(); ?>/js/argon-dashboard.min.js?v=2.0.4"></script>
        <script type="text/javascript" src="<?= media();?>/js/functions_theme_dark.js"></script>
    </body>

</html>