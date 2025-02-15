<?php get_header()?>
<style>
    .error{
    display: flex;
    flex-direction: row;
    justify-content: center;
    max-width: 1170px;
    margin: 0 auto;
    margin-top: 40px;
    margin-bottom: 89px;
}
.error-left{
    display: flex;
    flex-direction: column;
    align-items: start;
}
.error-left-heading{
    font-size: 34px;
    font-weight: 700;
    line-height: 40.81px;
    max-width: 394px;
}
.error-left-button{
    margin-top: 28px;
    transition: all 0.125s linear;
}
.error-left-button:hover{
    filter: brightness(1.2);
}
.error-left-button-child{
    padding: 26px 48px 26px 48px;
    font-weight: 600;
    font-size: 20px;
    line-height: 24.5px;
    background-color: #3A6431;
    color: #FFFFFF;
    gap: 14px;
}
.up-arrow-to-the-right.svg{
    width: 12px;
    height: 12px;
}
.error-cat{
    max-width: 100%;
}
 /* Responsive */

/* Large: 992px - 1199px */
@media (max-width: 1199px) {
    .error{
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 72px;
    }
    .error-left{
        max-width: 334px;
        align-items: center;
    }
}

/* Medium: 768px - 991px */
@media (max-width: 991px) {

}

/* Small: 576px - 767px */
@media (max-width: 767px) {

}

/* Extra small: 0px (320px) - 575px */
@media (max-width: 575px) {

}
</style>
    <div class="error">
        <div class="error-left">
            <div class="error-left-heading">
                По Вашему запросу ничего не найдено
            </div>
            <div class="error-left-button">
                <a href="<?= home_url();?>">
                    <button class="error-left-button-child">
                        Перейти на главную
                        <img src="../wp-content/uploads/2024/05/up-arrow-to-the-right.svg" alt="up-arrow-to-the-right" class="up-arrow-to-the-right">
                    </button>
                </a>
            </div>
        </div>
        <div class="error-right">
            <img src="../wp-content/uploads/2024/05/error-cat.png" alt="error-cat" class="error-cat">
        </div>
    </div>
    </div>
<?php get_footer() ?>
