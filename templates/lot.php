<main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php foreach ($categories as $category): ?>
        <li class="nav__item">
          <a href="all-lots.php?name=<?= $category['code'] ?>"><?= $category['name'] ?></a>
        </li>
        <?php endforeach ?>
      </ul>
    </nav>
    <section class="lot-item container">
      <h2><?= $lot['title'] ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= $lot['image'] ?>" width="730" height="548" alt="Сноуборд">
          </div>
          <p class="lot-item__category">Категория: <span><?= $lot['category_name'] ?></span></p>
          <p class="lot-item__description"><?= $lot['description'] ?>.</p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state <?= !isset($_SESSION['user']['name']) ? 'visually-hidden' : '' ?>">
            <div class="lot-item__timer timer <?= add_lot_status_class($lot['lot_end']) ?>">
             <?= get_formatted_lot_end($lot['lot_end']) ?>
            </div>
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot__cost">
                  <?= price_format($lot['price'] ?: $lot['price_start']) ?>
                  </span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка<br> <span><?= price_format(get_min_bid($lot)) ?></span>
              </div>
            </div>
            <form class="lot-item__form" action="" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item <?= !empty($error) ? 'form__item--invalid' : '' ?>">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="price" placeholder="<?= get_min_bid($lot) ?>">
                <span class="form__error"><?= isset($error) ? $error : '' ?></span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
          <div class="history">
            <h3>История ставок (<span><?= count($lot_bids) ?></span>)</h3>
            <table class="history__list">
              <?php foreach ($lot_bids as $lot_bid): ?>
              <tr class="history__item">
                <td class="history__name"><?= $lot_bid['name'] ?></td>
                <td class="history__price"><?= $lot_bid['price'] ?></td>
                <td class="history__time"><?= get_bid_expire($lot_bid) ?></td>
              </tr>
              <?php endforeach ?>
            </table>
          </div>
        </div>
      </div>
    </section>
</main>