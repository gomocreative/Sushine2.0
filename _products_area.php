<?php

$nameProducts = array(
    1 => "Panel Solar de 280W",
    2 => "Panel Solar de 260W",
    3 => "Panel Solar de 150W",

    4 => "Panel Solar de 80W",
    5 => "Panel Solar de 70W",
    6 => "Panel Solar de 60W",
    
    7 => "Panel Solar de 40W",
    8 => "Panel Solar de 20W",
    9 => "Inversor De Onda Puera",

    10 => "Controlador MPPT 30 AMP",
    11 => "Lámpara LED Exterios 40W",
    12 => "Lámpara LED Exterios 30W",
    
    13 => "Batería de 150 AH",
    14 => "Batería de 150 AH",
    15 => "Batería de 50 AH",
    
    16 => "LUZ LED ahorradora T8",
    17 => "LUZ LED Alta potencia DC / 30cm ",
    18 => "LUZ LED Alta potencia DC / 15cm "
);

$descProducts = array(
    1 => "Voltaje:35 </br> Poder Máximo (pmax): 280W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    2 => "Voltaje:29.5 </br> Poder Máximo (pmax): 2600W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    3 => "Voltaje:17.5 </br> Poder Máximo (pmax): 150W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    
    4 => "Voltaje:17.5 </br> Poder Máximo (pmax): 80W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    5 => "Voltaje:17.5 </br> Poder Máximo (pmax): 70W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    6 => "Voltaje:17.5 </br> Poder Máximo (pmax): 60W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    
    7 => "Voltaje:17.5 </br> Poder Máximo (pmax): 40W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    8 => "Voltaje:17.5 </br> Poder Máximo (pmax): 20W </br> MAterial: Silicio </br> AM: 1.5 </br> Estándares internacionales de Cálidad",
    9 => "Voltios: 12, 12/24 & 24/48 </br> Onda Pura </br> Tamaño Compacto </br> Estándares internacionales de Cálidad",

    10 => "Voltios: 12, 24, 36 & 48 </br> Poder Max: 390W(12V) / 780(24V) / </br> 1170W(36V) / 1560W(48V) </br> Tamaño Compacto </br> Estándares internacionales de Cálidad",
    11 => "Voltios: 12 AC </br> 40W </br> Estándares internacionales de Cálidad",
    12 => "Voltios: 12 AC </br> 30W </br> Estándares internacionales de Cálidad",

    13 => "AH: 150 </br> Voltios: 12V </br> Tamaño Compacto </br> Estándares internacionales de Cálidad",
    14 => "AH: 150 </br> Voltios: 12V </br> Tamaño Compacto </br> Estándares internacionales de Cálidad",
    15 => "AH: 50 </br> Voltios: 12V </br> Tamaño Compacto </br> Estándares internacionales de Cálidad",

    16 => "Voltios: 12V </br> Tamaño: 60cm </br> Alta eficiencia / Ahorro de enegia </br> Producto de baja emicion de carbono y</br>proteccion del medio ambiente. </br> Estándares internacionales de Cálidad",
    17 => "Voltios: 12V </br> Tamaño: 30cm </br> Alta eficiencia / Ahorro de enegia </br> Producto de baja emicion de carbono y</br>proteccion del medio ambiente. </br> Estándares internacionales de Cálidad",
    18 => "Voltios: 12V </br> Tamaño: 15cm </br> Alta eficiencia / Ahorro de enegia </br> Producto de baja emicion de carbono y</br>proteccion del medio ambiente. </br> Estándares internacionales de Cálidad"
);

$imgProducts = array(
    1 => "products/panels/2/panel2.2.png",
    2 => "products/panels/3/panel3.2.png",
    3 => "products/panels/4/panel4.2.png",

    4 => "products/panels/5/panel5.2.png",
    5 => "products/panels/6/panel6.2.png",
    6 => "products/panels/7/panel7.2.png",
    
    7 => "products/panels/8/panel8.2.png",
    8 => "products/panels/9/panel9.2.png",
    9 => "products/inver/inv1.1.png",

    10 => "products/cont/cont1.1.png",
    11 => "products/lampsAndBatterys/slamp1/slamp1.1.png",
    12 => "products/lampsAndBatterys/slamp2/slamp2.1.png",

    13 => "products/lampsAndBatterys/batterys/bt1/bt1.3.png",
    14 => "products/lampsAndBatterys/batterys/bt2/bt3.3.png",
    15 => "products/lampsAndBatterys/batterys/bt3/bt3.3.png",

    16 => "products/lampsAndBatterys/lamps/lp1/lp1.2.png",
    17 => "products/lampsAndBatterys/lamps/lp2/lp2.2.png",
    18 => "products/lampsAndBatterys/lamps/lp3/lp3.1.png"
);

$catProducts = array(
    1 => "Paneles",
    2 => "Inversores",
    3 => "Controls",
    4 => "Lamparas",
    5 => "Baterias",
    6 => "Lueces"
);


function printProduct($id, $img, $name, $cat, $desct)
{
    print"
      <div class='col-xs-12 col-sm-6 col-md-4'>
        <article class='post-single'>
            <figure class='post-media'>
                    <img src='$img' alt=''>
            </figure>
            <div class='post-body'>
                <div class='post-meta'>
                    <div class='post-tags'><a  data-toggle='modal' data-target='#$id' href=''>$name</a></div>
                   <div class='post-date'>$cat</div>
                </div>
                <a data-toggle='modal' data-target='#$id' class='read-more' href=''><span>INFO</span></a>
                
                <!-- modal  -->
                <div style='margin-top: 100px;' class='modal fade' id='$id' tabindex='-1' role='dialog' aria-labelledby='$id' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered' role='document'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                            <h4 class='modal-title' id='$id'>$name</h4>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>
                            <div class='modal-body'>
                            <div class='text-center'>
                                <img src='$img' alt='' style='width: 300px; height: 300px; '>
                            </div>
                            </div>
                            <div class='modal-footer'>
                                <p>$desct</p>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </article>
    </div>";
}

?>