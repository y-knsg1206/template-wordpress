<?php get_header(); ?>
<div class="l-404 p-404">
    <div class="p-404__inner l-inner">
        <h2 class="p-404__title">お探しのページは見つかりませんでした。</h2>
        <div class="p-404__btn">
            <a class="c-btn" href="<?php echo esc_url(home_url($page)); ?>">TOPページへ</a>
        </div>
    </div>
</div>
<?php get_footer(); ?>

