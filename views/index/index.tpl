{*<h1 >{$_layoutParams.configs.app_name}</h1>*}

<img class="center-block img-responsive img-thumbnail " src="{$_layoutParams.ruta_img}logo_telecentros.png" />
 {if Session::accesoViewEstricto(array('especial'))}
<a class="btn btn-primary btn-round" title="Crear nuevo" href="{BASE_URL}index/verTablas"><i class="glyphicon glyphicon-certificate"></i></a>
    <a class="btn btn-primary btn-round" title="Crear nenes" href="{BASE_URL}index/p"><i class="glyphicon glyphicon-dashboard"></i></a>
{/if}
 