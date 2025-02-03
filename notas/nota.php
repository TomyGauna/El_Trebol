<?php
// Incluir el archivo de conexión a la base de datos
require('../includes/conexion.php');

// Verificar si se recibió el ID de la noticia
if(isset($_GET['id_noticia'])) {
    // Obtener el ID de la noticia desde el parámetro de la URL
    $id_noticia = $_GET['id_noticia'];

    // Consultar la base de datos para obtener los detalles de la noticia
    $consulta = "SELECT * FROM noticias WHERE id = ?";
    $stmt = $conexion->prepare($consulta);
    $stmt->bind_param("i", $id_noticia);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró la noticia
    if($result->num_rows === 1) {
        $noticia = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:title" content="<?php echo $noticia['titulo']; ?>" />
    <meta property="og:image" content="https://treboldiario.com.ar/img/<?php echo $noticia['imagen']; ?>" />
    <meta property="og:url" content="https://treboldiario.com.ar/notas/nota.php?id_noticia=<?php echo $noticia['id']; ?>" />
    <meta property="og:type" content="article" />
    <link rel="shortcut icon" href="../img/svg/logo.png" type="image/x-icon">
    <title>El Trébol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom">
        <ul id="redes" class="nav mb-2 justify-content-start mb-md-0">
            <!--<li>-->
            <!--    <a href="#" class="nav-link px-2">-->
            <!--        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"-->
            <!--            class="bi bi-youtube" viewBox="0 0 16 16">-->
            <!--            <path-->
            <!--                d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z" />-->
            <!--        </svg>-->
            <!--    </a>-->
            <!--</li>-->
            <!--<li>-->
            <!--    <a href="#" class="nav-link px-2">-->
            <!--        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"-->
            <!--            class="bi bi-linkedin" viewBox="0 0 16 16">-->
            <!--            <path-->
            <!--                d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z" />-->
            <!--        </svg>-->
            <!--    </a>-->
            <!--</li>-->
            <li>
                <a href="https://www.instagram.com/treboldiario?igsh=MXY4amsyNHZyaW4ycQ==" class="nav-link px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-instagram" viewBox="0 0 16 16">
                        <path
                            d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="https://x.com/treboldiario?t=MDkGSPk8Ea5dRRDQq_DErg&s=08" class="nav-link px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-twitter-x" viewBox="0 0 16 16">
                        <path
                            d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="https://www.facebook.com/people/Tr%C3%A9bol-Diario/100092711918404/?mibextid=ZbWKwL" class="nav-link px-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        class="bi bi-facebook" viewBox="0 0 16 16">
                        <path
                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                    </svg>
                </a>
            </li>
        </ul>

        <div id="logo" class="col-auto mb-0  justify-content-center">
            <a href="../index.php"
                class="d-flex align-items-center justify-content-center mb-0 me-auto link-body-emphasis text-decoration-none">

                <svg class="ms-1 ms-sm-2 ms-xl-4" id="Capa_2" data-name="Capa 2" height="53"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 379.95 284.97">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #39b54a;
                            }

                            .cls-2 {
                                fill: #008f39;
                            }
                        </style>
                    </defs>
                    <g id="TREBOL_DIARIO" data-name="TREBOL DIARIO">
                        <g>
                            <path class="cls-1"
                                d="m379.95,142.49c0,26.21-21.27,47.48-47.5,47.48h-142.47V47.51c0-26.24,21.27-47.51,47.48-47.51s47.51,21.27,47.51,47.51c0,.74-.02,1.5-.07,2.25-.02.63-.07,1.28-.13,1.93-.04.52-.09,1.04-.15,1.56-.04.48-.11.98-.19,1.47-3.04,22.29-19.04,52.12-37.29,78.1,25.97-18.26,55.81-34.26,78.1-37.29.5-.09,1-.15,1.47-.2.52-.07,1.04-.11,1.56-.15.65-.07,1.3-.11,1.93-.13.76-.04,1.52-.07,2.26-.07,26.24,0,47.5,21.27,47.5,47.51Z" />
                            <path class="cls-2"
                                d="m332.45,189.98h-142.47c0,6.33,10.86,19.23,27.08,33.54t.04.04c1.67,1.47,3.38,2.95,5.16,4.47.02,0,.04,0,.04.02,29.53,24.89,73.02,52.3,102.92,56.37.5.09,1,.15,1.47.2.52.06,1.04.11,1.56.15.65.07,1.3.11,1.93.13.76.04,1.52.07,2.25.07,26.24,0,47.51-21.27,47.51-47.5,0-26.21-21.27-47.48-47.51-47.48Z" />
                            <path class="cls-2"
                                d="m47.51,189.98h142.47c0,6.33-10.86,19.23-27.08,33.54t-.04.04c-1.67,1.47-3.38,2.95-5.16,4.47-.02,0-.04,0-.04.02-29.53,24.89-73.02,52.3-102.92,56.37-.5.09-1,.15-1.47.2-.52.06-1.04.11-1.56.15-.65.07-1.3.11-1.93.13-.76.04-1.52.07-2.25.07C21.27,284.97,0,263.7,0,237.46s21.27-47.48,47.51-47.48Z" />
                            <path class="cls-2"
                                d="m189.98,47.51v142.47c-6.33,0-19.23-10.86-33.54-27.08t-.04-.04c-1.47-1.67-2.95-3.38-4.47-5.16,0-.02,0-.04-.02-.04-6.33-7.52-12.84-15.96-19.08-24.83-18.26-25.97-34.26-55.81-37.29-78.1-.09-.5-.15-1-.2-1.47-.06-.52-.11-1.04-.15-1.56-.07-.65-.11-1.3-.13-1.93-.04-.76-.07-1.52-.07-2.25C94.99,21.27,116.26,0,142.49,0s47.48,21.27,47.48,47.51Z" />
                            <path class="cls-1"
                                d="m189.98,189.98H47.51c-26.24,0-47.51-21.27-47.51-47.48s21.27-47.51,47.51-47.51c.74,0,1.5.02,2.26.07.63.02,1.28.06,1.93.13.52.04,1.04.09,1.56.15.48.04.98.11,1.47.2,22.29,3.04,52.12,19.04,78.1,37.29,6.24,8.87,12.75,17.3,19.08,24.83.02,0,.02.02.02.04,1.52,1.78,2.99,3.49,4.47,5.16t.04.04c14.31,16.22,27.21,27.08,33.54,27.08Z" />
                        </g>
                    </g>
                </svg>

                <svg class="ms-1 ms-sm-2 ms-md-3 ms-xl-4" id="Capa_2" data-name="Capa 2" height="53"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 739.13 313.1">
                    <g id="TREBOL_DIARIO" data-name="TREBOL DIARIO">
                        <g id="trebollogo_1" data-name="trebollogo 1">
                            <path
                                d="m38.43,151.19h5.78c6.69,0,10.05-3.1,10.05-9.29V39.68h-16.58c-3.52,0-6.07.75-7.66,2.26-1.59,1.51-2.39,3.94-2.39,7.28v10.3H0V14.32h147.68v45.21h-27.38v-10.3c0-3.35-.8-5.78-2.39-7.28-1.59-1.51-4.14-2.26-7.66-2.26h-16.58v102.22c0,6.2,3.43,9.29,10.3,9.29h5.78v25.37H38.43v-25.37Z" />
                            <path
                                d="m144.66,150.94h4.77c3.52,0,6.07-.79,7.66-2.39,1.59-1.59,2.39-3.98,2.39-7.16v-50.48c0-3.01-.71-5.31-2.13-6.91-1.42-1.59-3.81-2.39-7.16-2.39h-5.27v-25.62h47.22l3.01,12.81c3.01-4.52,7.2-7.79,12.56-9.79,5.36-2.01,11.05-3.01,17.08-3.01h14.57v25.62h-20.34c-7.03,0-12.1,1.63-15.19,4.9-3.1,3.26-4.65,8.33-4.65,15.19v39.93c0,3.18.71,5.53,2.13,7.03,1.42,1.51,3.81,2.26,7.16,2.26h4.77v25.62h-68.56v-25.62Z" />
                            <path
                                d="m258.81,164.38c-11.8-10.63-17.71-26.33-17.71-47.09s5.56-38.05,16.7-48.85c11.13-10.8,27-16.2,47.59-16.2s35.37,5.49,45.84,16.45c10.46,10.97,15.7,25.66,15.7,44.08v12.05h-86.4c0,10.89,2.26,18.75,6.78,23.61,4.52,4.86,11.64,7.28,21.35,7.28,8.2,0,15.15-1.26,20.85-3.77v-9.29h33.15v20.59c-6.37,5.69-13.94,9.96-22.73,12.81-8.79,2.85-19.38,4.27-31.77,4.27-21.1,0-37.55-5.31-49.35-15.95Zm68.94-60.9c0-8.7-1.93-15.28-5.78-19.72-3.85-4.43-9.54-6.66-17.08-6.66-8.04,0-14.11,2.26-18.21,6.78-4.1,4.52-6.15,11.05-6.15,19.59h47.22ZM305.65,0h42.95l-28.38,45.21h-33.4L305.65,0Z" />
                            <path
                                d="m430.34,175.55c-6.95-3.18-12.77-8.45-17.45-15.82l-2.01,16.83h-27.37V46.21c0-3.35-.67-5.86-2.01-7.53-1.34-1.67-3.77-2.51-7.28-2.51h-4.27V10.3h49.73v55.76c5.36-4.85,11.13-8.37,17.33-10.55,6.19-2.17,13.39-3.26,21.6-3.26,17.58,0,30.85,5.61,39.81,16.83,8.95,11.22,13.44,27.38,13.44,48.47,0,19.93-5.07,35.37-15.19,46.34-10.13,10.97-23.65,16.45-40.56,16.45-10.21,0-18.8-1.59-25.74-4.77Zm36.67-27.5c3.77-6.44,5.65-16.78,5.65-31.02s-1.88-24.49-5.65-30.77c-3.77-6.28-10.42-9.42-19.97-9.42-7.87,0-14.02,2.89-18.46,8.66-4.44,5.78-6.66,13.86-6.66,24.24v13.81c0,9.71,2.3,17.83,6.91,24.36,4.6,6.53,10.84,9.79,18.71,9.79,9.21,0,15.7-3.22,19.46-9.67Z" />
                            <path
                                d="m544.24,163.88c-11.22-10.96-16.83-26.75-16.83-47.34s5.53-36.67,16.58-47.72c11.05-11.05,27.12-16.58,48.22-16.58s37.17,5.53,48.22,16.58c11.05,11.05,16.58,26.96,16.58,47.72s-5.61,36.38-16.83,47.34c-11.22,10.97-27.21,16.45-47.97,16.45s-36.75-5.48-47.97-16.45Zm67.56-18.46c4.02-6.03,6.03-15.65,6.03-28.88s-2.01-23.36-6.03-29.38c-4.02-6.03-10.55-9.04-19.59-9.04s-15.53,3.01-19.46,9.04c-3.94,6.03-5.9,15.82-5.9,29.38s1.97,22.85,5.9,28.88c3.93,6.03,10.42,9.04,19.46,9.04s15.57-3.01,19.59-9.04Z" />
                            <path
                                d="m667.55,150.94h6.03c3.52,0,6.07-.79,7.66-2.39,1.59-1.59,2.39-4.06,2.39-7.41V43.95c0-3.35-.63-5.73-1.88-7.16-1.26-1.42-3.48-2.13-6.66-2.13h-7.53V10.3h55.76v131.35c0,6.2,3.26,9.29,9.79,9.29h6.03v25.62h-71.58v-25.62Z" />
                            <path
                                d="m149.43,298.37h3.9c2.26,0,3.87-.51,4.83-1.52.96-1.02,1.44-2.65,1.44-4.91v-72.5c0-2.14-.48-3.7-1.44-4.66-.96-.96-2.57-1.44-4.83-1.44h-3.9v-12.37h48.79c15.7,0,27.36,4.8,34.98,14.4,7.62,9.6,11.43,23.21,11.43,40.83,0,16.49-3.93,29.67-11.77,39.56-7.85,9.88-19.4,14.82-34.64,14.82h-48.79v-12.2Zm46.42,0c11.07,0,19.03-3.5,23.89-10.5,4.85-7,7.28-17.56,7.28-31.68s-2.43-25.24-7.28-32.36c-4.86-7.11-12.82-10.67-23.89-10.67h-18.3v85.21h18.3Z" />
                            <path
                                d="m254.12,298.03h4.91c2.26,0,3.87-.51,4.83-1.52.96-1.02,1.44-2.65,1.44-4.91v-43.54c0-2.14-.48-3.7-1.44-4.66-.96-.96-2.57-1.44-4.83-1.44h-4.91v-12.71h29.31v62.51c0,2.15.51,3.73,1.52,4.74s2.6,1.52,4.74,1.52h4.91v12.54h-40.49v-12.54Zm10.67-97.24h19.14v15.58h-19.14v-15.58Z" />
                            <path
                                d="m309.43,307.17c-4.69-3.95-7.03-9.54-7.03-16.77,0-8.13,2.57-14.09,7.71-17.87,5.14-3.78,12.56-6.01,22.28-6.69l23.72-1.52v-10.33c0-5.31-1.13-9.15-3.39-11.52-2.26-2.37-6.1-3.56-11.52-3.56-3.73,0-6.8.31-9.23.93-2.43.62-4.66,1.61-6.69,2.96v6.1h-15.75v-13.38c9.49-5.87,20.16-8.81,32.02-8.81,21.68,0,32.53,9.6,32.53,28.8v37.1c0,2.26.42,3.9,1.27,4.91.85,1.02,2.23,1.52,4.15,1.52h3.73v11.52h-19.48l-2.2-10.67c-3.62,4.63-7.82,7.99-12.62,10.08-4.8,2.09-11.1,3.13-18.89,3.13-9.04,0-15.9-1.98-20.58-5.93Zm40.74-10.67c3.95-2.94,5.93-7.4,5.93-13.38v-8.13l-22.36,1.69c-5.53.34-9.38,1.5-11.52,3.47-2.15,1.98-3.22,5.11-3.22,9.4,0,3.73,1.19,6.55,3.56,8.47,2.37,1.92,6.21,2.88,11.52,2.88,6.78,0,12.14-1.47,16.09-4.4Z" />
                            <path
                                d="m393.55,298.03h4.24c2.26,0,3.87-.48,4.83-1.44.96-.96,1.44-2.57,1.44-4.83v-43.71c0-2.14-.45-3.73-1.35-4.74-.91-1.02-2.43-1.52-4.57-1.52h-3.56v-12.54h23.38l2.37,9.32c2.26-3.5,5.17-5.93,8.72-7.28,3.56-1.36,7.76-2.03,12.62-2.03h7.79v12.54h-9.49c-6.44,0-11.01,1.44-13.72,4.32-2.71,2.88-4.07,7.31-4.07,13.3v32.36c0,2.26.45,3.87,1.36,4.83.9.96,2.43,1.44,4.57,1.44h4.24v12.54h-38.79v-12.54Z" />
                            <path
                                d="m458.97,298.03h4.91c2.26,0,3.87-.51,4.83-1.52.96-1.02,1.44-2.65,1.44-4.91v-43.54c0-2.14-.48-3.7-1.44-4.66-.96-.96-2.57-1.44-4.83-1.44h-4.91v-12.71h29.31v62.51c0,2.15.51,3.73,1.52,4.74,1.02,1.02,2.6,1.52,4.74,1.52h4.91v12.54h-40.49v-12.54Zm10.67-97.24h19.14v15.58h-19.14v-15.58Z" />
                            <path
                                d="m516.85,301.75c-7-7.56-10.5-18.13-10.5-31.68s3.47-24.31,10.42-31.93c6.95-7.62,17.36-11.43,31.25-11.43s24.31,3.81,31.25,11.43c6.95,7.62,10.42,18.27,10.42,31.93s-3.5,24.11-10.5,31.68c-7,7.57-17.39,11.35-31.17,11.35s-24.17-3.78-31.17-11.35Zm49.3-8.81c3.95-4.97,5.93-12.59,5.93-22.87s-1.98-18.1-5.93-23.12c-3.95-5.02-9.99-7.54-18.13-7.54s-14.14,2.51-18.04,7.54c-3.9,5.03-5.84,12.73-5.84,23.12s1.95,17.9,5.84,22.87c3.9,4.97,9.91,7.45,18.04,7.45s14.17-2.48,18.13-7.45Z" />
                        </g>
                    </g>
                </svg>

            </a>
        </div>

        <div id="botones" class="text-end">
            <ul id="sueltos" class="nav nav-pills">
                <li class="nav-item"><a href="../index.php" class="nav-link" aria-current="page">Inicio</a>
                </li>
                <!--<li class="nav-item">-->
                <!--    <div class="dropdown">-->
                <!--        <a class="btn dropdown-toggle nav-link" role="button" data-bs-toggle="dropdown"-->
                <!--            aria-expanded="false">-->
                <!--            Regiones-->
                <!--        </a>-->

                <!--        <ul class="dropdown-menu">-->
                <!--            <li>-->
                <!--                <a class="dropdown-item" href="{% url 'news_in_region' region='san martin' %}">San-->
                <!--                    Martín</a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a class="dropdown-item" href="{% url 'news_in_region' region='tres de febrero' %}">Tres-->
                <!--                    de Febrero</a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a class="dropdown-item"-->
                <!--                    href="{% url 'news_in_region' region='malvinas argentinas' %}">Malvinas-->
                <!--                    Argentinas</a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a class="dropdown-item" href="{% url 'news_in_region' region='san isidro' %}">San-->
                <!--                    Isidro</a>-->
                <!--            </li>-->
                <!--            <li>-->
                <!--                <a class="dropdown-item"-->
                <!--                    href="{% url 'news_in_region' region='vicente lópez' %}">Vicente-->
                <!--                    López</a>-->
                <!--            </li>-->
                <!--        </ul>-->
                <!--    </div>-->
                <!--</li>-->
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="btn dropdown-toggle nav-link" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Secciones
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="../seccion.php?seccion=politica">Política</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../seccion.php?seccion=sociedad">Sociedad</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../seccion.php?seccion=cultura">Cultura</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../seccion.php?seccion=deportes">Deportes</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="../seccion.php?seccion=unsam">UNSAM</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item"><a href="../somos.php" class="nav-link">Quiénes somos</a></li>
            </ul>
            <div class="container">
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarsExample11" aria-controls="navbarsExample11" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon mb-2 me-2"><svg xmlns="http://www.w3.org/2000/svg" width="32"
                            height="32" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                        </svg></span>
                </button>
                <div class="navbar-collapse d-lg-flex collapse" id="navbarsExample11">
                    <ul class="navbar-nav col-lg-6 justify-content-lg-center">
                        <li class="nav-item"><a href="../index.php" class="nav-link "
                                aria-current="page">Inicio</a>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="dropdown-toggle nav-link" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Regiones
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{% url 'news_in_region' region='san martin' %}">San
                                        Martín</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{% url 'news_in_region' region='tres de febrero' %}">Tres
                                        de Febrero</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{% url 'news_in_region' region='malvinas argentinas' %}">Malvinas
                                        Argentinas</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{% url 'news_in_region' region='san isidro' %}">San
                                        Isidro</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{% url 'news_in_region' region='vicente lópez' %}">Vicente
                                        López</a>
                                </li>
                            </ul>
                        </li> -->
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle nav-link" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Secciones
                            </a>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                        href="../seccion.php?seccion=politica">Política</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="../seccion.php?seccion=sociedad">Sociedad</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="../seccion.php?seccion=cultura">Cultura</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="../seccion.php?seccion=deportes">Deportes</a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="../seccion.php?seccion=unsam">UNSAM</a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="../somos.php" class="nav-link">Quiénes somos</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="nt_container">
            <div class="nota_fuerte">
                <div class="card border-0">
                    <div class="fechaSegment">
                        <?php
                        // Obtener el segmento y decodificar cualquier entidad HTML
                        $segment = htmlspecialchars_decode($noticia['segment']);

                        // Convertir la primera letra a mayúscula
                        $segment = ucfirst($segment);

                        // Verificar si el segmento es "Política" y ajustar si es necesario
                        if (strtolower($segment) === 'politica') {
                            $segment = 'Política';
                        }
                        ?>
                        <a class="text-dark" href="../seccion.php?seccion=<?php echo urlencode($noticia['segment']); ?>">
                            <?php echo htmlspecialchars($segment); ?>
                        </a>
                        <p id="creacion" ><?php echo $noticia['dia_creacion']; ?></p>
                    </div>
                    <h1><span><?php echo $noticia['titulo']; ?></span></h1>
                    <h2 class="card-title"><?php echo $noticia['contenido']; ?></h2>
                    <hr>
                    <div class="compartir">
                        <span>Compartinos en:</span>
                        <a href="https://api.whatsapp.com/send?text=<?php echo $noticia['titulo']; ?> - https://treboldiario.com.ar/notas/nota.php?id_noticia=<?php echo $noticia['id']; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16"><path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg></a>
                        <a href="http://www.facebook.com/sharer.php?u=https://treboldiario.com.ar/notas/nota.php?id_noticia=<?php echo $noticia['id']; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/></svg></a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo $noticia['titulo']; ?> - https://treboldiario.com.ar/notas/nota.php?id_noticia=<?php echo $noticia['id']; ?>" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/></svg></a>
                    </div>
                    <hr>
                    <?php if ($noticia['imagen']): ?>
                        <img src="../img/<?php echo $noticia['imagen']; ?>" class="card-img-top img-principal w-100 mx-0" alt="<?php echo $noticia['titulo']; ?>">
                    <?php endif; ?>
                    
                    <div class="textito"><?php echo $noticia['content_nuevo'];?></div>
                    
                </div>
            </div>
        </div>
    </main>


    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top bg-secondary px-3 mb-0 mt-3">
        <div class="col-md-4 d-flex align-items-center">
        <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
            <svg class="ms-1 ms-sm-2 ms-xl-4" id="Capa_2" data-name="Capa 2" height="24"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 379.95 284.97">
                    <defs>
                        <style>
                            .cls-1 {
                                fill: #39b54a;
                            }

                            .cls-2 {
                                fill: #008f39;
                            }
                        </style>
                    </defs>
                    <g id="TREBOL_DIARIO" data-name="TREBOL DIARIO">
                        <g>
                            <path class="cls-1"
                                d="m379.95,142.49c0,26.21-21.27,47.48-47.5,47.48h-142.47V47.51c0-26.24,21.27-47.51,47.48-47.51s47.51,21.27,47.51,47.51c0,.74-.02,1.5-.07,2.25-.02.63-.07,1.28-.13,1.93-.04.52-.09,1.04-.15,1.56-.04.48-.11.98-.19,1.47-3.04,22.29-19.04,52.12-37.29,78.1,25.97-18.26,55.81-34.26,78.1-37.29.5-.09,1-.15,1.47-.2.52-.07,1.04-.11,1.56-.15.65-.07,1.3-.11,1.93-.13.76-.04,1.52-.07,2.26-.07,26.24,0,47.5,21.27,47.5,47.51Z" />
                            <path class="cls-2"
                                d="m332.45,189.98h-142.47c0,6.33,10.86,19.23,27.08,33.54t.04.04c1.67,1.47,3.38,2.95,5.16,4.47.02,0,.04,0,.04.02,29.53,24.89,73.02,52.3,102.92,56.37.5.09,1,.15,1.47.2.52.06,1.04.11,1.56.15.65.07,1.3.11,1.93.13.76.04,1.52.07,2.25.07,26.24,0,47.51-21.27,47.51-47.5,0-26.21-21.27-47.48-47.51-47.48Z" />
                            <path class="cls-2"
                                d="m47.51,189.98h142.47c0,6.33-10.86,19.23-27.08,33.54t-.04.04c-1.67,1.47-3.38,2.95-5.16,4.47-.02,0-.04,0-.04.02-29.53,24.89-73.02,52.3-102.92,56.37-.5.09-1,.15-1.47.2-.52.06-1.04.11-1.56.15-.65.07-1.3.11-1.93.13-.76.04-1.52.07-2.25.07C21.27,284.97,0,263.7,0,237.46s21.27-47.48,47.51-47.48Z" />
                            <path class="cls-2"
                                d="m189.98,47.51v142.47c-6.33,0-19.23-10.86-33.54-27.08t-.04-.04c-1.47-1.67-2.95-3.38-4.47-5.16,0-.02,0-.04-.02-.04-6.33-7.52-12.84-15.96-19.08-24.83-18.26-25.97-34.26-55.81-37.29-78.1-.09-.5-.15-1-.2-1.47-.06-.52-.11-1.04-.15-1.56-.07-.65-.11-1.3-.13-1.93-.04-.76-.07-1.52-.07-2.25C94.99,21.27,116.26,0,142.49,0s47.48,21.27,47.48,47.51Z" />
                            <path class="cls-1"
                                d="m189.98,189.98H47.51c-26.24,0-47.51-21.27-47.51-47.48s21.27-47.51,47.51-47.51c.74,0,1.5.02,2.26.07.63.02,1.28.06,1.93.13.52.04,1.04.09,1.56.15.48.04.98.11,1.47.2,22.29,3.04,52.12,19.04,78.1,37.29,6.24,8.87,12.75,17.3,19.08,24.83.02,0,.02.02.02.04,1.52,1.78,2.99,3.49,4.47,5.16t.04.04c14.31,16.22,27.21,27.08,33.54,27.08Z" />
                        </g>
                    </g>
                </svg>
        </a>
        <span id="trebol" class="mb-3 mb-md-0 text-body-secondary">© 2024 El Trébol Diario</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="https://www.instagram.com/treboldiario?igsh=MXY4amsyNHZyaW4ycQ=="><svg class="bi" width="24" height="24"><path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z" /></svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="https://x.com/treboldiario?t=MDkGSPk8Ea5dRRDQq_DErg&s=08"><svg class="bi" width="24" height="24"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z" /></svg></a></li>
        <li class="ms-3"><a class="text-body-secondary" href="https://www.facebook.com/people/Tr%C3%A9bol-Diario/100092711918404/?mibextid=ZbWKwL"><svg class="bi" width="24" height="24"><path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" /></svg></a></li>
        </ul>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
<?php
    } else {
        echo "La noticia no fue encontrada.";
    }
    // Cerrar la consulta y la conexión
    $stmt->close();
    $conexion->close();
} else {
    echo "ID de noticia no proporcionado.";
}
?>