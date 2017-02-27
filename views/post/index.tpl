
{if isset($posts) && count($posts)}
    <table class="table table-striped table-hover">
        <thead class="bg-primary">
            <tr>
                <th>id</th>
                <th>Titulo</th>
                <th>Cuerpo</th>
{*                <th>Img</th>*}
                <th class="text-right">
{*                    {if Session::accesoViewEstricto(array('especial'))}*}
                        <a class="btn btn-primary" href="{$_layoutParams.root}post/nuevo">Nuevo post</a>
{*                    {/if}*}
                </th>
            </tr>
        </thead>
        {foreach item=post from=$posts}
            <tr>
                <td>{$post.id}</td>
                <td>{$post.titulo}</td>
                <td>{$post.cuerpo}</td>
                {if isset($post.imagen)}
                <td>
                    <a href='{$_layoutParams.root}public/img/post/{$post.imagen}'>
                        <img src='{$_layoutParams.root}public/img/post/thumb/thumb_ls_{$post.imagen}'
                    </a>
                </td>
                {/if}
                <td>
{*            <a href="index.phtml"></a>*}
            {if Session::accesoViewEstricto(array('especial'))}
                <a title="Editar" class="btn btn-default btn-sm" href="{$_layoutParams.root}post/editar/{$post.id}/{$pagina}"><span class=" glyphicon glyphicon-pencil"></span></a>
            {/if}
            {if Session::accesoViewEstricto(array('especial'))}
            <a title="Eliminar" class="btn btn-danger btn-sm" href="{$_layoutParams.root}post/eliminar/{$post.id}/{$pagina}"><span class=" glyphicon glyphicon-trash"></span></a>
            {/if}
            </td>

        </tr>
    {/foreach}
</table>
{*<hr>*}
{*<div class="text-center" style="letter-spacing: 1em;">F I N</div>*}
{else}
    <div class="alert alert-warning" style="padding-top: 250px;">
        No hay posts!!!!!!
    </div>
{/if}
    {$paginacion}





