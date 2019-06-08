<main class="container">
<section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>


        <ul class="promo__list">
        <?php foreach ($categories as $category): ?>
            <li class="promo__item promo__item--<?= $category['code'] ?>">
                <a class="promo__link" href="all-lots.php?name=<?= $category['code'] ?>"><?= $category['name'] ?></a>
        <?php endforeach; ?>
            </li>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
            <li class="lots__item lot <?= (strtotime($lot['lot_end']) < time()) ? 'visually-hidden' : '' ?>">
                <div class="lot__image">
                    <img src="<?= $lot['image'] ?>" width="350" height="260" alt="<?= $lot['title'] ?>">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?= $lot['category_name'] ?></span>
                    <h3 class="lot__title">
                        <a class="text-link" href="lot.php?id=<?= $lot['lot_id'] ?>">
                            <?= esc($lot['title']) ?>
                        </a>
                    </h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount"><?= price_format($lot['price_start']) ?></span>
                            <span class="lot__cost">
                              <?= price_format($lot['price'] ?: $lot['price_start']) ?>  
                            </span>


                        </div>
                        <div class="lot__timer timer <?= add_lot_status_class($lot['lot_end']) ?>">
                            <?= get_formatted_lot_end($lot['lot_end']) ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>