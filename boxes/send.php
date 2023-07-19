<div class="boxes">
    <h1>Cotización enviada</h1>
    <img src="images/icono.svg" alt="Icono" width="23">
    <p class="font2">La cotización No. <?=$_GET['code']?> fue enviada a <?=$_GET['email']?></p>
    <div class="btns">
        <a href="javascript:$.fancybox.close();<?=$_GET['afterClose']?>" class="btn2 uppercase">CONTINUAR</a>
    </div>
</div>