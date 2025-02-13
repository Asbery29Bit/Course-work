<footer>
     <div class="footer-search">
         <div class="footer-logo">
         <a href="<?= home_url();?>">
                    <?php the_custom_logo(); ?>
                </a>
         </div>
         <!-- <div class="footer-search-push-left">
             Главная
         </div>
         <div>
             Статьи 
         </div>
         <div>
             Контакты
         </div>
         <div>
             Доставка и оплата
         </div>
         <div class="footer-search-push-right">
             О нас
         </div> -->
         <div class="footer-search-margins">
         <?php 
                $args = [
                    'theme_location'  => 'bottom',
                    'container'       => false,
                    'menu_class'    => '',
                    'menu_id'       => '',
                    'items_wrap' => '%3$s',
                    'link_class'   => 'footer-text'
                ];
                wp_nav_menu($args);
                ?>
                </div>
         <div class="footer-contacts">
             <div class="footer-surqle">
                 <img src="http://elovpark.ru/wp-content/uploads/2024/05/Phone.svg" alt="Phone-footer" class="phone-footer">
             </div>
             <div>
                 <a href="https://taplink.cc/elovpark" target="_blank" class="footer-text">
                    +7 (3952) 57-77-00
                </a>
             </div>
         </div>
         <div class="footer-contacts">
             <div class="marker-footer">
                 <img src="http://elovpark.ru/wp-content/uploads/2024/05/Marker.svg" alt="Marker-footer">
             </div>
             <div>
                <a href="https://yandex.ru/maps/?um=constructor%3Ae986f1bb986e53caa0420aea730ef6a4e9216e3650d3c689987b008f9c8bf27a&source=constructorLink" target="_blank" class="footer-text">
                    Иркутск
                </a> 
             </div>
         </div>
     </div>
     <div>
            <div class="footer-content">
                <div class="footer-content-child-left">
                    <div class="footer-left-img">
                        <img src="http://elovpark.ru/wp-content/uploads/2024/05/Footer-img-left.svg" alt="Footer-img-left">
                    </div>
                    <div class="footer-left-img-tablet">
                        <img src="http://elovpark.ru/wp-content/uploads/2024/05/Footer-img-left-tablet.svg" alt="Footer-img-left-tablet">
                    </div>
    
                    <div class="footer-contacts-adaptive">
                        <div class="footer-surqle">
                            <img src="http://elovpark.ru/wp-content/uploads/2024/05/Phone.svg" alt="Phone-footer" class="phone-footer">
                        </div>
                        <div>
                            <a href="https://taplink.cc/elovpark" target="_blank" class="footer-text">
                                +7 (3952) 57-77-00
                            </a>
                        </div>
                    </div>
                    <div class="footer-contacts-adaptive">
                        <div class="footer-surqle-adaptive">
                            <img src="http://elovpark.ru/wp-content/uploads/2024/05/Marker.svg" alt="Marker-footer" class="marker-footer">
                        </div>
                        <div>
                            <a href="https://yandex.ru/maps/?um=constructor%3Ae986f1bb986e53caa0420aea730ef6a4e9216e3650d3c689987b008f9c8bf27a&source=constructorLink" target="_blank" class="footer-text">
                                Иркутск
                            </a> 
                        </div>
                    </div>
                </div>
                <div class="footer-content-child-right">
                    <a href="https://elovpark.ru/privacy_policy/">
                    <div class="footer-text">
                        Политика кондиценциальности
                    </div>
                    </a>
                    <div class="footer-text">
                        Все права защищены.
                    </div>
                </div>
            </div>
            <div class="footer-right-img">
                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Footer-img-right.svg" alt="Footer-right-img">
            </div>
            <div class="footer-right-img-tablet">
                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Footer-img-right-tablet.svg" alt="Footer-img-right-tablet">
            </div>
            <div class="footer-img-right-phone">
                <img src="http://elovpark.ru/wp-content/uploads/2024/05/Footer-img-right-phone.svg" alt="Footer-img-right-phone">
            </div>
        </div>
 </footer>
 <?php wp_footer(); ?>
</body>

</html>
