<?php
/*
* Template Name: Busqueda de Stands
*/

echo '<style> 
.mainHeader{
display: none !important;
}
</style>';

// cosas de WP

boldthemes_set_override();

get_header();

$action_slug = $wp_query->query_vars['name'];

?>
    <section id="bt_section5fa58e86b011a" class="boldSection gutter inherit" style="background-color:#fbc100;">
        <div class="port">
            <div class="boldCell">
                <div class="boldCellInner">
                    <div class="boldRow ">
                        <div class="boldRowInner">
                            <div class="rowItem col-md-12 col-ms-12  btTextLeft inherit" style="background-color: rgba(255, 255, 255, 1);" data-width="12">
                                <div class="rowItemContent">
                                    <div class="btClear btSeparator bottomSemiSpaced noBorder"><hr></div>
                                    <div class="btText">
                                        <p>
                                            <img loading="lazy" class="alignnone wp-image-2104 size-full" src="https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1.png" alt="Logotipo ARPA 2020 del 26 al 28 de noviembre" srcset="https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1.png 957w, https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1-320x52.png 320w, https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1-768x125.png 768w, https://www.eventos-digitales.com/wp-content/uploads/2020/09/Diseno-sin-titulo-19-1-540x88.png 540w" sizes="(max-width: 957px) 100vw, 957px" width="957" height="156">
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div id="arpa_main_buscador">
    <section class="boldSection topSpaced bottomSemiSpaced gutter inherit">
        <form role="search" method="get" class="search-form">
            <label>
                <span class="screen-reader-text"><?php echo _x('Buscar:', 'label') ?></span>
                <input type="hidden" value="stands" id="modo" name="modo" />
                <input type="search" class="search-field arpa_busqueda_nombre" placeholder="<?php echo esc_attr_x('Introduzca su búsqueda...', 'placeholder') ?>"
                       value="<?php echo get_search_query() ?>" name="s" id="s"
                       title="<?php echo esc_attr_x('Buscar:', 'label') ?>"/>
                <select class="arpa_busqueda_select" name="select_entidad" id="select_entidad">
                    <option value="">Elija entidad expositora</option>
                    <option value="Institución">Institución</option>
                    <option value="Instituto de patrimonio">Instituto de patrimonio</option>
                    <option value="Fundación o asociación">Fundación o asociación</option>
                    <option value="Universidad, centro de investigación">Universidad, centro de investigación</option>
                    <option value="Escuela taller o casa de oficios">Escuela taller o casa de oficios</option>
                    <option value="Editorial o revista especializada">Editorial o revista especializada</option>
                    <option value="Empresa de restauración">Empresa de restauración</option>
                    <option value="Empresa de servicios">Empresa de servicios</option>
                    <option value="Otro">Otro</option>
                </select>
                <select class="arpa_busqueda_select" name="select_entidad" id="select_entidad">
                    <option value="">Elija programa</option>
                    <option value="AR&amp;PA Instituciones">AR&amp;PA Instituciones</option>
                    <option value="AR&amp;PA Negocio">AR&amp;PA Negocio</option>
                    <option value="AR&amp;PA Empleo">AR&amp;PA Empleo</option>
                    <option value="AR&amp;PA Museos">AR&amp;PA Museos</option>
                    <option value="AR&amp;PA Iniciativas">AR&amp;PA Iniciativas</option>
                    <option value="AR&amp;PA Innovación">AR&amp;PA Innovación</option>
                </select>
            </label>
            <input type="submit" name="search-submit" class="search-submit arpa_submit" value="<?php echo esc_attr_x('Buscar', 'submit button') ?>"/>
        </form>
        <div id="parent_results">
            <div id="mostrar" class="rowItem col-md-6 col-sm-12 btTextLeft inherit"></div>
        </div>
    </section>
</div>

<?php

get_footer();