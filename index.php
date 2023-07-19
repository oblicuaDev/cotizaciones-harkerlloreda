<?php include 'includes/config.php'; 


$fdoctors = get_field(2269,true);
$doctors = $fdoctors['data'];
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="keywords, keywords">
    <meta name="description" content="Your description">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cotizador Harker & Lloreda</title>

</head>

<body style="display: none;">
    <!-- Your HTML Code should be here -->
    <header>
        <div class="container">
            <img src="images/logo.svg" alt="logoHarker">
            <h1>Hola <?=$_SESSION['logged']['nam_us']?> <span class="uppercase"><?=$_SESSION['logged']['nam_us'][0]?></span></h1>
        </div>
    </header>
    <h1 class="title">Cotizaciones</h1>
    <form action="">
            <input type="search" id="search1" name="s" placeholder="Busca cotizaciones por nombre o cédula del paciente">
        </form>
    <div class="cfilters container clear">
        <p class="bigcolumn w_40 ">
            <label>Responsable</label>
            <select class="font2" id="doctorfilter">
                <option value="0">Todos</option>
                <?php $cDoctors = count($doctors);
                for ($i=0; $i < $cDoctors; $i++) { ?>
                    <option value="<?=$doctors[$i]['reg_val']?>" ><?=$doctors[$i]['val']?></option>
                <?php } ?>
            </select>
        </p>
        <div class="bigcolumn w_60 clear">
            <p class="bigcolumn w_30 "><label>Desde</label>
            <input  type="date" class="font2" id="dfrom"></p>
            <p class="bigcolumn w_30 "><label>Hasta</label>
            <input  type="date" class="font2" id="dto"></p>
            <!--<p class="bigcolumn w_30 "><label>#Cotización</label>-->
            <!--<input  type="text" class="font2" id="idquot" name="idquot"></p>-->
            <button class="bigcolumn w_10" id="go">Ir</button>
        </div>
        
    </div>
    <a href="cotizacion.php" class="replaced_text create"><img src="images/crear.svg" alt="nueva cotización"> Nueva cotización</a>
    <script>
        var s = '<?=$_GET['s']?>';
    </script>
    <table class="container" id="tableQuots">
        <thead>
            <tr>
                <th>NÚMERO DE COTIZACIÓN</th>
                <th>PACIENTE</th>
                <th>FECHA DE COTIZACIÓN</th>
                <th>CANTIDAD DE OPCIONES</th>
                <th>VALOR PROMEDIO</th>
                <th></th>
            </tr>
        </thead>
        <tbody class="font2">
           
        </tbody>
    </table>
    <nav data-pagination class="hide font2">
        <a class="before-page" href="javascript:;">
        <svg version="1.1"
        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
        x="0px" y="0px" width="7.8px" height="16.1px" viewBox="0 0 7.8 16.1" style="enable-background:new 0 0 7.8 16.1;"
        xml:space="preserve">
        <style type="text/css">
        .st0{fill:#808080;}
        </style>
        <path class="st0" d="M6.8,16.1c-0.3,0-0.6-0.1-0.8-0.4l-5.8-7c-0.3-0.4-0.3-0.9,0-1.3l5.8-7c0.4-0.4,1-0.5,1.4-0.1
        c0.4,0.4,0.5,1,0.1,1.4L2.3,8l5.3,6.4c0.4,0.4,0.3,1.1-0.1,1.4C7.3,16,7,16.1,6.8,16.1z"/>
        </svg>
        </a>
        <ul>
            <li><a href=#1 class="beforeLink">1</a>
            <li><a href="#2" class="beforeLink">2</a>
            <li class="current"><a href="#3" class="">3</a>
            <li><a href="#4" class="">4</a>
            <li><a href="#10" class="more">…</a>
            <li><a href="#41" class="">10</a>
        </ul>
        <a class="after-page" href="javascript:;">
            <svg version="1.1"
            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:a="http://ns.adobe.com/AdobeSVGViewerExtensions/3.0/"
            x="0px" y="0px" width="7.8px" height="16.1px" viewBox="0 0 7.8 16.1" style="enable-background:new 0 0 7.8 16.1;"
            xml:space="preserve">
            <style type="text/css">
            .st0{fill:#808080;}
            </style>
            <path class="st0" d="M1,16.1c-0.2,0-0.4-0.1-0.6-0.2c-0.4-0.4-0.5-1-0.1-1.4L5.5,8L0.2,1.6c-0.4-0.4-0.3-1.1,0.1-1.4
            c0.4-0.3,1.1-0.3,1.4,0.1l5.8,7c0.3,0.4,0.3,0.9,0,1.3l-5.8,7C1.6,15.9,1.3,16.1,1,16.1z"/>
            </svg>
        </a>
    </nav>
<div id="loader"></div>
</body>
<link rel="stylesheet" type="text/css" href="css/reset.css">
<link rel="stylesheet" type="text/css" href="css/jquery.bxslider.css">
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css">
<link rel="stylesheet" href="js/jqueryui/jquery-ui.css">

<!-- Your CSS includes should be here-->
<link rel="stylesheet" type="text/css" href="css/default.css">
<link rel="stylesheet" type="text/css" href="css/styles.css?1.0.5">


<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">

<?php include 'includes/scripts.php'; ?>

</html>