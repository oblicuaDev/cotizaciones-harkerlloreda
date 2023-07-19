<div class="boxes">
    <h1>Janett</h1>
    <h2>¿Estás segura de eliminar la opción <?=$_GET['numb']?> de esta cotización?</h2>
    <img src="images/icono.svg" alt="Icono" width="23">
    <p class="font2">Esta acción no se puede deshacer</p>
    <div class="btns">
        <a href="javascript:;" onclick="deleteOpt(<?=$_GET['numb']?>)" class="btn1 uppercase">ELIMINAR</a>
        <a href="javascript:$.fancybox.close();" class="btn2 uppercase">VOLVER</a>
    </div>
</div>