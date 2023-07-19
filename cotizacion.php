<?php include 'includes/config.php';
$customers = get_field(226,true);
$customersForAvailableTags = array_map(function($customer){
    $exp = explode('-', $customer['val']);
    array_splice($exp, 0,1);
    $imp = implode('-', $exp);
    $imp = back_utf8($imp);
    return [
        'label' => $imp,
        'value' => $imp,
        'rowID' => $customer['reg_val']
    ];
}, $customers['data']);
$fdoctors = get_field(2269,true);
$doctors = $fdoctors['data'];
$others = f_content_list(33,'created','upward',0,1);
$quot = isset($_GET['row'])?f_get_content($_GET['row']):null;
$code = isset($_GET['row'])?$quot['code_quot']:str_pad(getCounter(), 4, '0',STR_PAD_LEFT);
$optsStr = isset($_GET['row'])?$quot['opts_quot']:'';
$customerName = '';
$customerId = '';
if(isset($_GET['row'])){
    $key = array_search($quot['client_quot'], array_column($customersForAvailableTags, 'rowID'));
    $customerName = $key === false?'':$customersForAvailableTags[$key]['label'];
    $customerId = $key === false?-1:$customersForAvailableTags[$key]['rowID'];
} ?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="keywords" content="keywords, keywords">
    <meta name="description" content="Your description">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cotizador Harker & Lloreda</title>
    <script>
        var row = <?=(isset($_GET['row'])?$_GET['row']:0)?>;
        var customerTags = <?=json_encode($customersForAvailableTags)?>;
        var others = <?=json_encode($others)?>;
        var optsStr = '<?=$optsStr?>';
        var code = '<?=$code?>';
    </script>

</head>

<body style="display: none;">
    <!-- Your HTML Code should be here -->
    <header>
        <div class="container">
            <a href="/custom_functions/231/cotizaciones/"><img src="images/logo.svg" alt="logoHarker"></a>
            <h1>Hola <?=$_SESSION['logged']['nam_us']?> <span><?=$_SESSION['logged']['nam_us'][0]?></span></h1>
        </div>
    </header>
    <h1 class="title">Cotización #<?=$code?></h1>
    <div class="generalData">
        <input type="search" id="search2" data-id="<?=$customerId?>" name="search2" value="<?=$customerName?>" <?=($customerName == '')?'':'disabled'?> placeholder="Nombre del paciente">
        <a id="nviewclient" target="_BLANK" href="http://prod.orekacloud.com/v1.4/create.php?mod=20&rowID=<?=$customerId?>">Ver datos de contacto del cliente</a>
        <div class="customSelect">
            <select name="doctor" id="doctor">
                <option value="-1">Seleccionar doctor</option>
<?php $cDoctors = count($doctors);
for ($i=0; $i < $cDoctors; $i++) {
    $selected = $quot && $doctors[$i]['reg_val'] == $quot['doctor_quot']?'selected':''; ?>
                <option value="<?=$doctors[$i]['reg_val']?>" <?=$selected?>><?=$doctors[$i]['val']?></option>
<?php } ?>
            </select>
        </div>
    </div>
    <div class="container">
        <div class="options" id="tabs">
            <ul>
                <li data-tabnumber="1"><a href="#opt-1" class="uppercase">Opción 1 </a><a href="javascript:;" onclick="deleteTab($(this))" class="deleteTab"><img src="images/cerrar_blanco.svg" alt="Eliminar Tab"></a></li>
                <a href="javascript:addOption();" class="uppercase replaced_text addOption">Opción 1</a>
            </ul>
            <div id="opt-1" class="tabCnt clear" data-id="">
                <div class="header-tab">
                    <h1 class="bold font2 discount hide">Descuento: <span class="percent hide" contenteditable="true">0</span> <span class="hide">%</span></h1>
                    <h1 class="bold font2 finalPrice">Total cotización: <span>$0</span></h1>
                </div>
                <section class="procedures">
                    <h1 class="titleSection uppercase">Procedimientos</h1>
                    <div class="cnt">
                        <!-- <article class="procedure">
                            <a href="javascript:;" onclick="deletePr(this)" class="deleteArticle replaced_text">x</a>
                            <h2 class="font2 bold">Procedimiento a cotizar:</h2>
                            <div class="customSelect">
                                <select name="" id="">
                                    <option value="" data-price="10">Bigote 20 min.</option>
                                    <option value="" data-price="20">DYSPORT/BÓTOX</option>
                                    <option value="" data-price="30">Cirugía de párpados</option>
                                    <option value="" data-price="40">RELLENO Y ESTIMULACIÓN DE COLÁGENO</option>
                                </select>
                            </div>
                            <div class="items">
                                <div class="item">
                                    <div class="customSelectBg">
                                        <select name="" id="">
                                            <option value="" data-price="10">Bigote 20 min.</option>
                                            <option value="" data-price="20">DYSPORT/BÓTOX</option>
                                            <option value="" data-price="30">Cirugía de párpados</option>
                                            <option value="" data-price="40">RELLENO Y ESTIMULACIÓN DE COLÁGENO</option>
                                        </select>
                                    </div>
                                    <div class="IB">
                                        <h2 class="font2 bold ar">Cantidad:</h2>
                                        <input type="number" value="1">
                                    </div>
                                    <div class="IB">
                                        <a href="javascript:;" onclick="deleteProc(this,event)" class="deleteProcedur"><img src="images/cerrar_verde.svg" alt=""></a>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:;" onclick="addItem(this);" class="addItem font2 semibold">Agregar item</a>
                        </article> -->
                    </div>
                    <a href="javascript:addProcedure();" class="addGnrl font2 semibold">Agregar procedimiento</a>
                </section><!--
            --><section class="aditional">
                    <h1 class="titleSection uppercase">Adicionales</h1>
                    <div class="cnt">
                        <!-- <article>
                            <a href="javascript:;" onclick="deletePr(this)" class="deleteArticle replaced_text">x</a>
                            <h2 class="font2 bold">Item</h2>
                            <input type="text">
                            <h2 class="font2 bold">Valor</h2>
                            <input type="text" class="priceAdded">
                        </article> -->
                    </div>
                    <a href="javascript:addAditional();" class="addGnrl font2 semibold">Agregar adicional</a>
                </section><!--
            --><section class="other">
                    <h1 class="titleSection uppercase">Otros</h1>
                    <div class="cnt">
                        <!-- <article>
                            <a href="javascript:;" onclick="deletePr(this)" class="deleteArticle replaced_text">x</a>
                            <div class="IB">
                                <h2 class="font2 bold">Item:</h2>
                                <div class="customSelectBg">
                                    <select name="" id="">
                                        <option value="" data-price="10">Bigote 20 min.</option>
                                        <option value="" data-price="20">DYSPORT/BÓTOX</option>
                                        <option value="" data-price="30">Cirugía de párpados</option>
                                        <option value="" data-price="40">RELLENO Y ESTIMULACIÓN DE COLÁGENO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="IB">
                                <h2 class="font2 bold">Cantidad:</h2>
                                <input type="number" value="1">
                            </div>
                        </article> -->
                    </div>
                    <a href="javascript:addOther();" class="addGnrl font2 semibold">Agregar otro</a>
                </section>
            </div>
            <a href="javascript:saveQuot();" class="saveAll uppercase"><img src="images/guardar_blanco.svg" alt="guardar ">GUARDAR COTIZACIÓN</a>
        </div>
    </div>



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
<link href="https://d1azc1qln24ryf.cloudfront.net/114779/Socicon/style-cf.css?rd5re8" rel="stylesheet">

<?php include 'includes/scripts.php'; ?>

</html>