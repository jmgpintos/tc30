<div class=" text-center">
<ul class="pagination ">
  


<?php if (isset($this->_paginacion)): ?>

    <?php if ($this->_paginacion['primero']): ?>
        <li><a href="<?php echo $link . $this->_paginacion['primero'] ?>"><?php echo GLYPH_PAG_PRIMERA?></a></li>
    <?php else:?>
        <li class="disabled"><a href="<?php echo $link . $this->_paginacion['primero'] ?>"><?php echo GLYPH_PAG_PRIMERA?></a></li>
    <?php endif; ?>

    <?php if ($this->_paginacion['anterior']): ?>
        <li><a href="<?php echo $link . $this->_paginacion['anterior'] ?>"><?php echo GLYPH_PAG_ANTERIOR?></a></li>
    <?php else:?>
        <li class="disabled"><a href="<?php echo $link . $this->_paginacion['anterior'] ?>"><?php echo GLYPH_PAG_ANTERIOR?></a></li>
    <?php endif; ?>

    <?php foreach ($this->_paginacion['rango'] as $k): ?>
        <?php if($this->_paginacion['actual']==$k):?>
        <li class="disabled"><a href="<?php echo $link . $k ?> "><?php echo $k ?></a></li>
        <?php else:?>
        <li><a href="<?php echo $link . $k ?> "><?php echo $k ?></a></li>
        <?php endif;?>
    <?php endforeach;?>
        
    <?php if ($this->_paginacion['siguiente']): ?>
        <li><a href="<?php echo $link . $this->_paginacion['siguiente'] ?>"><?php echo GLYPH_PAG_SIGUIENTE?></a></li>
    <?php else:?>
        <li class="disabled"><a href="<?php echo $link . $this->_paginacion['siguiente'] ?>"><?php echo GLYPH_PAG_SIGUIENTE?></a></li>
    <?php endif; ?>

    <?php if ($this->_paginacion['ultimo']): ?>
        <li><a href="<?php echo $link . $this->_paginacion['ultimo'] ?>"><?php echo GLYPH_PAG_ULTIMA?></a></li>
    <?php else:?>
        <li class="disabled"><a href="<?php echo $link . $this->_paginacion['ultimo'] ?>"><?php echo GLYPH_PAG_ULTIMA?></a></li>
    <?php endif; ?>

<?php endif; ?>
</div>
</ul>
        <?php // vardump($this->_paginacion)?>
