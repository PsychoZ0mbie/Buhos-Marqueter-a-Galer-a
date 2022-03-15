<?php
    //include("Views/Publicaciones/articulo.php");
?>
<div class="modal fade" id="modalCompartir" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Compartir en</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul class="social-networks">
            <li>
              <a href="#" 
              onclick="window.open('http://www.facebook.com/sharer.php?u=<?=$urlShared?>&t=<?=$arrPost['title'];?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')">
              <i class="fab fa-facebook-square" aria-hidden="true"></i>
              </a>
            </li>
            <li><a href="#" onclick="window.open('https://twitter.com/intent/tweet?text=<?=$arrPost['title'];?>&url=<?=$urlShared?>&hashtags=<?=SHAREDHASH?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')"><i class="fab fa-twitter-square" aria-hidden="true"></i></a></li>
            <li><a href="#" onclick="window.open('http://www.linkedin.com/shareArticle?url=<?=$urlShared?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')"><i class="fab fa-linkedin" aria-hidden="true"></i></a></li>
            <li><a href="#" onclick="window.open('https://pinterest.com/pin/create/button/?url=<?=$urlShared?>&media=<?=$arrPost['image'];?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')"><i class="fab fa-pinterest-square" aria-hidden="true"></i></a></li>
            <li><a href="#" onclick="window.open('https://telegram.me/share/url?url=<?=$urlShared?>&text=<?=$arrPost['title'];?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')"><i class="fab fa-telegram-plane" aria-hidden="true"></i></a></li>
            <li><a href="#" onclick="window.open('https://api.whatsapp.com/send?text=<?=$urlShared?>','ventanacompartir','toolbar=0,status=0,width=650,height=450')"><i class="fab fa-whatsapp-square" aria-hidden="true"></i></a></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>