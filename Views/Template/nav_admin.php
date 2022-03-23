    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    
    <aside class="app-sidebar">
      <div class="app-sidebar__user">
        <a href="<?=base_url();?>/Usuarios/perfil">
          <img class="app-sidebar__user-avatar" src="<?= media();?>/images/uploads/<?=$_SESSION['userData']['picture']?>">
        </a>
        <div>
          <p class="app-sidebar__user-name"><?=$_SESSION['userData']['firstname'] ?></p>
          <p class="app-sidebar__user-designation"><?=$_SESSION['userData']['role'] ?></p>
        </div>
      </div>
      <ul class="app-menu">´
        <?php
          if(!empty($_SESSION['permisos'][1]['r'])){
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][2]['r'])){
        ?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Usuarios</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?=base_url();?>/usuarios"><i class="icon fa fa-circle-o"></i> Usuarios</a></li>
            <li><a class="treeview-item" href="<?=base_url();?>/roles" rel="noopener"><i class="icon fa fa-circle-o"></i> Roles</a></li>
          </ul>
        </li>
        <?php
          }
        ?>
        <?php
          if(!empty($_SESSION['permisos'][3]['r'])){
        ?> 
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-crop"></i><span class="app-menu__label">Marquetería</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?=base_url();?>/marqueteria/productos"><i class="app-menu__icon far fa-circle"></i>Producto</a></li>
            <li><a class="treeview-item" href="<?=base_url();?>/marqueteria/subcategorias"><i class="app-menu__icon far fa-circle"></i>Categorías</a></li>
            <li><a class="treeview-item" href="<?=base_url();?>/marqueteria/tecnicas"><i class="app-menu__icon far fa-circle"></i>Subcategorias</li>
            <li><a class="treeview-item" href="<?=base_url();?>/marqueteria/atributos"><i class="app-menu__icon far fa-circle"></i>Atributos</li>
          </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-picture-o"></i><span class="app-menu__label">Galería</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?=base_url();?>/galeria/productos"><i class="app-menu__icon far fa-circle"></i>Producto</a></li>
            <li><a class="treeview-item" href="<?=base_url();?>/galeria/subcategorias"><i class="app-menu__icon far fa-circle"></i>Categorías</a></li>
            <li><a class="treeview-item" href="<?=base_url();?>/galeria/tecnicas"><i class="app-menu__icon far fa-circle"></i>Técnicas</li>
          </ul>
        </li>
        <li><a class="app-menu__item" href="<?=base_url();?>/mensaje"><i class="app-menu__icon fa fa-envelope"></i><span class="app-menu__label">Mensajes</span></a></li>
        <?php
          }
        ?>
        <li><a class="app-menu__item" href="<?=base_url();?>/pedidos"><i class="app-menu__icon fa fa-truck"></i><span class="app-menu__label">Pedidos</span></a></li>
        <li><a class="app-menu__item mt-4" href="<?=base_url();?>/usuarios/perfil"><i class="app-menu__icon fa fa-user"></i><span class="app-menu__label">Perfil</span></a></li>
        <li><a class="app-menu__item" href="<?= base_url();?>/logout"><i class="app-menu__icon fa fa-sign-out"></i><span class="app-menu__label">Cerrar sesión</span></a></li>
      </ul>
    </aside>